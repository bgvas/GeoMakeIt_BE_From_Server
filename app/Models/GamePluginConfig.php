<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class GamePlugin
 * @package App\Models
 * @version June 5, 2020, 1:48 pm UTC
 *
 * @property \App\Models\Game game
 * @property \App\Models\Plugin plugin
 * @property integer game_id
 * @property integer plugin_id
 * @property string file_name
 * @property string contents
 */

class GamePluginConfig extends Pivot
{
    use Compoships;
    public $table = 'game_plugin_config';
    public $timestamps = false;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'game_id' => 'integer',
        'plugin_id' => 'integer',
        'file_name' => 'string',
        'contents' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'game_id' => 'required',
        'plugin_id' => 'required',
        'file_name' => 'required',
        'contents' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function gamePlugin()
    {
        return $this->belongsTo(GamePlugin::class, ['game_id', 'plugin_id'], ['game_id', 'plugin_id']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function game()
    {
        return $this->belongsTo(\App\Models\Game::class, 'game_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function plugin()
    {
        return $this->belongsTo(\App\Models\Plugin::class, 'plugin_id');
    }
}
