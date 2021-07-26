<?php

namespace App\Jobs;

use App\Models\Game;
use App\Models\GamePluginData;
use App\Models\Plugin;
use App\Models\PluginData;
use App\Notifications\GenericNotification;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssembleGame implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;

    public $timeout = 900;

    protected $game;

    private const PATH_PROTOTYPE = "builds/prototype";
    private $PATH_build;
    private $PATH_plugins;
    private $build_name;

    /**
     * Create a new job instance.
     *
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
        $this->build_name = "build_{$game->id}";
        $this->PATH_build = "builds/{$this->build_name}";
        $this->PATH_plugins = "{$this->PATH_build}/app/libs";
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->game->release_file = null;
        $this->game->status = Game::STATUS_BUILDING;
        $this->game->save();

        // TODO: Clean old file
        $this->prepareDirectory();
        $this->configureStrings();
        $gradle_plugins = $this->assemblePlugins();
        $this->assembleGradleConfig($gradle_plugins);
        $this->assemblePluginsConfig();
        $this->buildRelease();
    }

    // Delete old build & replace with custom builder
    private function prepareDirectory()
    {
        Storage::disk('local')->deleteDirectory($this->PATH_build);
        File::copyDirectory(
            Storage::disk('local')->path(self::PATH_PROTOTYPE),
            Storage::disk('local')->path($this->PATH_build)
        );
    }


    // Create build.gradle file
    private function configureStrings()
    {
        $path = "{$this->PATH_build}/app/src/main/res/values/strings.xml";
        $build_gradle_contents = Storage::disk('local')->get($path);
        $build_gradle_contents = str_replace('{{$app_name}}', addslashes ($this->game->title), $build_gradle_contents); // Insert title
        $build_gradle_contents = str_replace('{{$app_description}}', addslashes ($this->game->description), $build_gradle_contents); // Insert description
        $build_gradle_contents = str_replace('{{$app_version}}', addslashes ($this->game->version), $build_gradle_contents); // Insert version
        $build_gradle_contents = str_replace('{{$app_build}}', "DEVELOPMENT", $build_gradle_contents); // Insert plugins
        Storage::disk('local')->put($path, $build_gradle_contents);
    }

    // Copy plugins into plugins directory
    private function assemblePlugins()
    {
        $plugins = $this->game->plugins;
        $gradle_plugins = "";
        foreach ($plugins as $plugin) {
            if(!$plugin->plugin_source) continue;
            $plugin_path = "{$this->PATH_plugins}/{$plugin->identifier}.aar";
            Storage::disk('local')->put($plugin_path, Storage::cloud()->get($plugin->plugin_source));
//          Storage::copy($plugin->plugin_source, $plugin_path);
            $this->assemblePlugin($plugin, $plugin_path);
        }

        return $gradle_plugins;
    }

    // Assemble a specific plugin
    private function assemblePlugin(Plugin $plugin, string $plugin_path)
    {
        $zip = new \ZipArchive();

        $basename_plugin = basename(
            $plugin_path,
            pathinfo($plugin_path, PATHINFO_EXTENSION)
        );
        $basename_plugin = substr($basename_plugin, 0, -1);

        $PATH_plugin_extract = "{$this->PATH_plugins}/{$basename_plugin}";

        if(Storage::disk('local')->exists($PATH_plugin_extract)) Storage::disk('local')->deleteDirectory($PATH_plugin_extract);
        if($zip->open(Storage::disk('local')->path($plugin_path)) !== TRUE) return;

        $gpd = GamePluginData::where('game_id', $this->game->id)->where('plugin_id', $plugin->id)->where('type', PluginData::TYPE_CONFIG)->get();
        // For Assets
        foreach($gpd as $data) {
            $zip->deleteName("assets/{$plugin->identifier}/{$data->name}.json");
            $zip->addFromString("assets/{$plugin->identifier}/{$data->name}.json", $data->contents);
        }

        $zip->close();
        File::deleteDirectory(Storage::disk('local')->path($PATH_plugin_extract));
    }

    // Create build.gradle file
    private function assembleGradleConfig($gradle_plugins)
    {
        $path = "{$this->PATH_build}/app/build.gradle";
        $contents = Storage::disk('local')->get($path);
        $contents = str_replace('{{$version}}', addslashes ($this->game->version), $contents); // Insert Version
//        $build_gradle_contents = str_replace('{{$plugins}}', $gradle_plugins, $build_gradle_contents); // Insert plugins
        Storage::disk('local')->put($path, $contents);
    }

    // Create plugins.json
    private function assemblePluginsConfig()
    {
        $path = "{$this->PATH_build}/app/src/main/assets/plugins.json";
        $plugins = $this->game->plugins;
        $plugin_array = array();
        foreach($plugins as $plugin) {
            if($plugin->id == 1) continue;
            $pos = strrpos($plugin->main, '.');

            array_push($plugin_array,
                [
                    "package" => substr($plugin->main, 0, $pos),
                    "main" => substr($plugin->main, $pos+1)
                ]
            );
        }
        Storage::disk('local')->put($path, json_encode($plugin_array));
    }

    private function buildRelease()
    {
        $gradle_path = base_path('gradlew');
        $build_path = Storage::disk('local')->path($this->PATH_build);
        $res = shell_exec("{$gradle_path} -p {$build_path} assembleDebug 2>&1");
        $success = Str::contains($res, 'BUILD SUCCESS');
        if(!$success) {
            throw new Exception($res);
        }
        //        $res = shell_exec(storage_path('app')."/{$this->PATH_build}/gradlew -p ".storage_path('app')."/{$this->PATH_build} assembleDebug 2>&1");
        $release_file = 'releases/'.uniqid('release_', true).'.apk';
        Storage::cloud()->put(
            $release_file,
            Storage::disk('local')->get("{$this->PATH_build}/app/build/outputs/apk/debug/app-debug.apk")
        );

        //        Storage::copy("{$this->PATH_build}/app/build/outputs/apk/debug/app-debug.apk", $release_file);
//        Storage::deleteDirectory($this->PATH_build);
        $this->game->release_file = $release_file;
        $this->game->status = Game::STATUS_RELEASE;
        $this->game->save();
        $this->game->user->notify(new GenericNotification(
            'Build complete',
            "{$this->game->title} was built. Click to download.",
            GenericNotification::TYPE_SUCCESS,
            route('studio.games.builder.download', ['game' => $this->game])
        ));
    }

    public function failed($exception)
    {
        $this->game->status = Game::STATUS_ERROR;
        $this->game->save();

        $this->game->user->notify(new GenericNotification(
            'Build failed',
            "{$this->game->title} has failed to be build. Click to learn more.",
            GenericNotification::TYPE_ERROR,
            route('studio.games.builder.index', ['game' => $this->game])
        ));
    }
}
