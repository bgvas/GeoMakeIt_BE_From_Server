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
 * @property integer plugin_id
 * @property boolean enabled
 */
class GamePlugin extends Pivot
{
    use Compoships;
    public $table = 'game_plugin';
    public $timestamps = false;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'game_id' => 'integer',
        'plugin_id' => 'integer',
        'enabled' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'plugin_id' => 'required',
        'enabled' => 'required'
    ];

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

    /**
     * @return \Awobaz\Compoships\Database\Eloquent\Relations\HasMany
     **/
    public function configs()
    {
        return $this->hasMany(\App\Models\GamePluginConfig::class, ['game_id', 'plugin_id'], ['game_id', 'plugin_id']);
    }

    /**
    * @return \Awobaz\Compoships\Database\Eloquent\Relations\HasMany
    **/
    public function data()
    {
        return $this->hasMany(\App\Models\GamePluginData::class, ['game_id', 'plugin_id'], ['game_id', 'plugin_id']);
    }
}
