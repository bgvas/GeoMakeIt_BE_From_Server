<?php

namespace App\Repositories;

use App\Models\Game;
use App\Models\GamePluginData;
use App\Models\Plugin;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class GameRepository
 * @package App\Repositories
 * @version June 5, 2020, 10:06 am UTC
*/

class GameRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'description',
        'user_id'
    ];

    function create($input)
    {
        $game = $this->model->newInstance($input);
        $game->user_id = auth()->id();
        $game->save();

        /* Install GeoMakeIt! */
        $plugin = Plugin::find(1);
        $plugin_data = $plugin->data;
        DB::transaction(function() use ($game, $plugin, $plugin_data)
        {
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

        return $game;
    }

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Game::class;
    }
}
