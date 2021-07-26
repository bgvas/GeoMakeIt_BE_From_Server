<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GamePluginConfig;
use App\Models\Plugin;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GamePluginConfigController extends Controller
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
     * Show the application dashboard.
     *
     * @param Request $request
     * @param Game $game
     * @param Plugin $plugin
     * @param string $file_name
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game, Plugin $plugin, string $name)
    {
        $contents = $request->input('contents');
        if (empty($game) || empty($plugin) || empty($file_name) || empty($contents)) {
            Flash::error('Configuration not found!');

            return redirect(route('studio.games.index'));
        }

        $config = GamePluginConfig::where('game_id', '=', $game->id)
            ->where('plugin_id', '=', $plugin->id)
            ->where('file_name', '=', $file_name)->first();
        if (empty($config)) {
            Flash::error('Configuration not found!');

            return redirect(route('games.index'));
        }

        json_decode($contents);
        $is_json = (json_last_error() == JSON_ERROR_NONE);
        if(!$is_json) {
            Flash::error('Configuration is not in json format!');

            return app(GamePluginController::class)->show($game, $plugin);
        }

        DB::update('update `game_plugin_config` set `contents` = ? where `game_id` = ? and `plugin_id` = ? and `file_name` = ?',
            [$contents, $game->id, $plugin->id, $file_name]);
        Flash::success('Configuration edited!');

        return app(GamePluginController::class)->show($game, $plugin);
    }
}
