<?php

namespace App\Jobs;

use ACFBentveld\XML\XML;
use App\Models\Game;
use App\Models\Plugin;
use App\Models\PluginConfiguration;
use App\Models\PluginData;
use App\Notifications\GenericNotification;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use MongoDB\Driver\Session;

class ExtractUploadedPlugin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;

    protected $plugin;

    private const DIR_PLUGINS = "plugins";
    private $PATH_extract_location;
    private $PATH_values = "/res/values/values.xml";
    private $PATH_assets = "/assets/";
    private $PUBLIC_PATTERN = "_public_";
    /**
     * Create a new job instance.
     *
     * @param Plugin $plugin
     */
    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
        $this->PUBLIC_PATTERN = $plugin->identifier.$this->PUBLIC_PATTERN;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(!$this->pluginExists()) return;
        $this->unzipPlugin();
        DB::beginTransaction();
        try {
            $this->extractPluginInformation();
            $this->plugin->data()->delete(); // Cleanup old configs
            $this->extractStrings();
            $this->extractAssets();
            DB::commit();

            $this->cleanupExtracts();

            $this->plugin->user->notify(new GenericNotification(
                'Plugin upload success',
                "{$this->plugin->identifier} has been uploaded, processed and is ready to be used!",
                GenericNotification::TYPE_SUCCESS,
                route('studio.plugins.edit', ['plugin' => $this->plugin])
            ));
        } catch(Exception $e) {
            DB::rollback();
            $this->fail($e);
        }
    }

    private function pluginExists() {
        if(!$this->plugin) return false;
        if(!$this->plugin->plugin_source) return false;
        return true;
    }

    private function unzipPlugin() {
        // Open Zip
        $zip = new \ZipArchive();
        Storage::disk('local')->put(
            $this->plugin->plugin_source,
            Storage::cloud()->get($this->plugin->plugin_source)
        );

        if($zip->open(Storage::disk('local')->path($this->plugin->plugin_source)) !== TRUE) {
            throw new Exception('Uploaded file was not a .jar or .aar file.');
        }

        // Find extract location
        $basename_plugin = basename(
            $this->plugin->plugin_source,
            pathinfo($this->plugin->plugin_source, PATHINFO_EXTENSION)
        );
        $basename_plugin = substr($basename_plugin, 0, -1);

        $this->PATH_extract_location = self::DIR_PLUGINS."/{$basename_plugin}";
        $this->setupPaths();

        // Cleanup if old directory exists at location
        $this->cleanupExtracts();
        // Complete extraction
        $zip->extractTo(Storage::disk('local')->path($this->PATH_extract_location));
        $zip->close();
    }

    private function setupPaths() {
        $prefix = $this->PATH_extract_location;
        $this->PATH_values = $prefix.$this->PATH_values;
        $this->PATH_assets = $prefix.$this->PATH_assets.$this->plugin->identifier;
    }

    private function extractPluginInformation() {
        if(!Storage::disk('local')->exists($this->PATH_assets)) {
            throw new Exception("Missing path 'assets/{$this->plugin->identifier}'. Have you forgotten to define your '".PluginData::FILE_PLUGIN_INFO."' or defined an incorrect identifier?");
        }

        $path = "{$this->PATH_assets}/".PluginData::FILE_PLUGIN_INFO;
        if (!Storage::disk('local')->exists($path)) {
            // TODO: Throw error!
//            $result = "Missing file '{$path}'";
//            flash()->error($result);
//            return $result;
            throw new Exception("Missing ".PluginData::FILE_PLUGIN_INFO);
        }

        // Decode plugin information
        $contents = Storage::disk('local')->get($path);
        $json = json_decode($contents, true);
        $error = json_last_error();
        if($error != JSON_ERROR_NONE) {
//            $result = "Failed to decode '".PluginData::FILE_PLUGIN_INFO."'. Reason: {$error}";
//            flash()->error($result);
//            return $result;
            throw new Exception("Failed to decode '".PluginData::FILE_PLUGIN_INFO."'. Reason: {$error}");
        }

        /* Verify that plugin information have the correct form */
        $validator = Validator::make($json, [
            'main' => array([
                'required',
                'string',
                'regex:/^[a-zA_Z_][\\.\\w]*$/',
                Rule::unique('plugins', 'id')->ignore($this->plugin)
            ]),
            'title' => Plugin::$rules['title'],
            'short_description' => Plugin::$rules['short_description'],
            'description' => Plugin::$rules['description'],
            'version' => Plugin::$rules['version'],
            'author' => 'required|string|min:3|max:150',
            'gradle_implementations' => 'array'
        ]);

        if($validator->fails()) {
//            flash()->error($validator->errors()->first());
            $msg = "";
            foreach($validator->errors() as $error) {
                $msg += $error;
            }
//            return $validator->errors()->first();
            throw new Exception(PluginData::FILE_PLUGIN_INFO." has the following error/s: {$validator->errors()->first()}");
        }

        $this->plugin->title = $json['title'];
        $this->plugin->main = $json['main'];
        $this->plugin->version = $json['version'];
        $this->plugin->short_description = $json['short_description'] ?? null;
        $this->plugin->description = $json['description'] ?? null;
        $this->plugin->save();
    }

    private function extractStrings(){
        // TODO: Manage with Laravel chunks as soon as you figure out how to use XML->collection()
        if(!Storage::disk('local')->exists($this->PATH_values)) return;
        $xml = XML::import(Storage::disk('local')->path($this->PATH_values));
        $raw = $xml->raw();

        $data = [];
        foreach ($raw->string as $str) {
            $name = $str->attribute('name', null);

            // Allow only names that follow this pattern <identifier>_public (e.x geomakeit_public)
            if(is_null($name) || !Str::startsWith($name, $this->PUBLIC_PATTERN)) continue;
            $name = Str::replaceFirst($this->PUBLIC_PATTERN, '', $name);
            if($name == '') continue; // If name is empty, skip.

            // TODO: Switch this with collection
            array_push($data, [
                'plugin_id' => $this->plugin->id,
                'type' => PluginData::TYPE_STRING,
                'name' => $name,
                'display_name' => $str->attribute('display_name', null),
                'description' => $str->attribute('description', null),
                'contents' => strval($str)
            ]);
        }

        // Upload data as chunks of 100
        $data = collect($data);
        $chunks = $data->chunk(100);
        foreach ($chunks as $chunk) {
            PluginData::insert($chunk->toArray());
        }
    }

    private function extractAssets(){
        $ignore_files = [PluginData::FILE_PLUGIN_INFO]; // These files will not be saved into the database

        $data = [];
        foreach (Storage::disk('local')->files($this->PATH_assets) as $file) {
            $file_name = basename($file);

            // Check if file name format is correct
            if(!preg_match('/^[a-zA-Z0-9_]+\.json$/', $file_name)) {
//                flash()->error("Skipping file '$file_name'. File names can be alpha-number, can contain '_' and must end in .json.");
                continue;
            }

            // Check if file is in ignored list
            if(in_array($file_name, $ignore_files)) continue;

            // Remove the .json extension
            $file_name = pathinfo($file_name, PATHINFO_FILENAME);

            $contents = Storage::disk('local')->get($file);

            // Check if the file is JSON
            json_decode($contents);
            if(json_last_error() != JSON_ERROR_NONE) {
//                flash()->error("Skipping file '$file_name'. Failed json check: ".json_last_error());
                continue;
            }


            // Create plugin configuration
            array_push($data, [
                'plugin_id' => $this->plugin->id,
                'type' => PluginData::TYPE_CONFIG,
                'name' => $file_name,
                'display_name' => null,
                'description' => null,
                'contents' => json_encode(json_decode($contents)), // Compress the string
            ]);
        }

        // Upload data as chunks of 10
        $data = collect($data);
        $chunks = $data->chunk(10);
        foreach ($chunks as $chunk) {
            PluginData::insert($chunk->toArray());
        }
    }

    private function cleanupExtracts() {
        if($this->PATH_extract_location != null && File::exists(Storage::disk('local')->path($this->PATH_extract_location))) {
            File::deleteDirectory(Storage::disk('local')->path($this->PATH_extract_location));
        }
    }

    public function failed($exception) {
        $this->plugin->user->notify(new GenericNotification(
            'Plugin upload failed',
            "{$this->plugin->identifier} has failed to be uploaded & processed. Exception: {$exception->getMessage()}",
            GenericNotification::TYPE_ERROR,
            route('studio.plugins.edit', ['plugin' => $this->plugin])
        ));
        if($this->plugin->plugin_source) {
            Storage::cloud()->delete($this->plugin->plugin_source);
            $this->plugin->plugin_source = null;
            $this->plugin->save();
        }
        $this->cleanupExtracts();
    }
}
