<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GamePlugin;
use App\Models\GamePluginConfig;
use App\Models\GamePluginData;
use App\Models\Plugin;
use App\Models\PluginConfiguration;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GamePluginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the Game's Plugins (for edit).
     *
     * @param Game $game
     * @return Response
     */
    public function index(Game $game)
    {
        return view('studio.games.plugins.index',
        [
            'game' => $game,
            'plugins' => Plugin::all(),
        ]);
    }

    /**
     * Display a listing of a specific Game's Plugin (for edit).
     *
     * @param Game $game
     * @param Plugin $plugin
     * @return Response
     */
    public function show(Game $game, Plugin $plugin)
    {
        if($game->plugins()->where('id', $plugin->id)->doesntExist()) {
            Flash::warning('This plugin isn\'t installed on this game');
            return redirect(route('studio.games.plugins.index', ['game'=>$game]));
        }

        return view('studio.games.edit',
            [
                'game' => $game,
                'focus' => 'tab_plugins_'.$plugin->identifier
            ]);
    }

    /**
     * Remove the specified Plugin from the game.
     *
     * @param Game $game
     * @param Plugin $plugin
     * @return Response
     */
    public function destroy(Game $game, Plugin $plugin)
    {
        if(in_array($plugin->id, Plugin::REQUIRED_PLUGINS)) {
            flash('Can\'t uninstall a required plugin!')->warning();
            return redirect(route('studio.games.plugins.index', ['game'=>$game]));
        }

        if($game->plugins()->where('id', $plugin->id)->doesntExist()) {
            Flash::warning('This plugin isn\'t installed on this game');
            return redirect(route('studio.games.plugins.index', ['game'=>$game]));
        }

        DB::delete('DELETE FROM `game_plugin_config` WHERE `game_id` = ? and `plugin_id` = ?', [
            $game->id, $plugin->id
        ]);
        $game->plugins()->detach($plugin);

        Flash::success("<b>{$plugin->title}</b> was removed from <b>{$game->title}</b>");

        return redirect(route('studio.games.plugins.index', ['game'=>$game]));
    }


    /**
     * Install a plugin to a game.
     *
     * @param Game $game
     * @param Plugin $plugin
     * @return Response
     */
    public function install(Game $game, Plugin $plugin)
    {
        $plugin_data = $plugin->data;

        DB::transaction(function() use ($game, $plugin, $plugin_data) {
            $game->plugins()->attach($plugin);
            $data = [];
            foreach ($plugin_data as $item) {
                array_push($data, [
                    'game_id' => $game->id,
                    'plugin_id' => $plugin->id,
                    'type' => $item->type,
                    'name' => $item->name,
                    'contents' => $item->contents,
                ]);
            }

            $data = collect($data);
            $chunks = $data->chunk(100);
            foreach ($chunks as $chunk) {
                GamePluginData::insert($chunk->toArray());
            }
        });

        Flash::success("<b>{$plugin->title}</b> was installed on <b>{$game->title}</b>");

        return redirect(route('studio.games.plugins.index', ['game'=>$game]));
    }
}
