<?php

namespace App\Http\Controllers\Games\Plugins;

use App\Models\Game;
use App\Http\Controllers\Controller;
use App\Models\GamePlugin;
use App\Models\GamePluginData;
use App\Models\Plugin;
use App\Models\PluginData;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class DataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Game $game, Plugin $plugin, string $type, Request $request)
    {
        if(!in_array($type, PluginData::getTypes())) {
            flash()->error("Configuration type $type doesn't exist.");
            return view('studio.games.edit',
                [
                    'game' => $game,
                    'focus' => 'tab_plugins_'.$plugin->identifier
                ]);
        }

        DB::beginTransaction();
        $plugin_data = $plugin->data()->ofType($type)->get(['name']);
//        $old = GamePluginData::ofType($type)->where('game_id', $game->id)->where('plugin_id', $plugin->id)->get(['name',]);
        $data = [];
        $updated_names = [];
        $allowed_name = collect($plugin_data->toArray())->map(function ($item, $key) { return $item['name']; })->toArray();

        foreach ($request->except('_token') as $name=>$contents) {
            if(!in_array($name, $allowed_name)) continue;

            // Config Validation
            if($type == PluginData::TYPE_CONFIG) {
                json_decode($contents);
                $is_json = (json_last_error() == JSON_ERROR_NONE);
                if(!$is_json) {
                    flash()->error("Configuration '{$name}' was not in a JSON format & was not saved!");
                    continue;
                }
            }

            array_push($data, [
                'game_id' => $game->id,
                'plugin_id' => $plugin->id,
                'type' => $type,
                'name' => $name,
                'contents' => $contents,
            ]);
            array_push($updated_names, $name);
        }

        GamePluginData::ofType($type)->where('game_id', $game->id)->where('plugin_id', $plugin->id)->whereIn('name', $updated_names)
            ->delete();

        $data = collect($data);
        $chunks = $data->chunk(100);
        foreach ($chunks as $chunk) {
            GamePluginData::insert($chunk->toArray());
        }
        DB::commit();

        flash()->success("Data of '$plugin->title' for game '$game->title' have been saved.");
        return redirect(route('studio.games.plugins.show',
            [
                'game' => $game,
                'plugin' => $plugin,
            ]));
    }
}
