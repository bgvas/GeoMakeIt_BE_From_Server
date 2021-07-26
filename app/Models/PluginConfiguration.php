<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class GamePlugin
 * @package App\Models
 * @version June 5, 2020, 1:48 pm UTC
 *
 * @property integer plugin_id
 * @property string file_name
 * @property string contents
 */
class PluginConfiguration extends Model
{
    public $table = 'plugin_configurations';

    public $timestamps = false;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
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
        'plugin_id' => 'required',
        'file_name' => 'required',
        'contents' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function plugin()
    {
        return $this->belongsTo(\App\Models\Plugin::class, 'plugin_id');
    }
}
