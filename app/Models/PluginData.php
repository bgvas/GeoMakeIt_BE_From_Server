<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PluginData
 * @package App\Models
 * @version July 12, 2020, 5:32 pm UTC
 *
 * @property integer plugin_id
 * @property string type
 * @property string name
 * @property string display_name
 * @property string description
 * @property string contents
 */
class PluginData extends Model
{
    use Compoships;
    const TYPE_CONFIG = 'config';
    const TYPE_STRING = 'string';
    const FILE_PLUGIN_INFO = 'plugin.json';

    public $table = 'plugin_data';

    public $timestamps = false;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'plugin_id' => 'integer',
        'type' => 'string',
        'name' => 'string',
        'display_name' => 'string',
        'description' => 'string',
        'contents' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'plugin_id' => 'required',
        'name' => 'required',
    ];

    public static function getTypes() {
        return [self::TYPE_CONFIG, self::TYPE_STRING];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function plugin()
    {
        return $this->belongsTo(\App\Models\Plugin::class, 'plugin_id');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
