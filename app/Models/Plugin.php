<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


/**
 * Class Plugin
 * @package App\Models
 * @version May 18, 2020, 11:59 am UTC
 *
 * @property \App\User user
 * @property string identifier
 * @property string title
 * @property string short_description
 * @property string description
 * @property string main
 * @property string version
 * @property integer user_id
 * @property string plugin_source
 */
class Plugin extends Model
{
    use SoftDeletes;

    /* ID of plugins to be required on each game */
    const REQUIRED_PLUGINS = [
        1
    ];

    public $table = 'plugins';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];

    public $fillable = ['identifier',];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'identifier' => 'string',
        'title' => 'string',
        'description' => 'string',
        'short_description' => 'string',
        'main' => 'string',
        'version' => 'string',
        'user_id' => 'integer',
        'plugin_source' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'identifier' => array(
            'required',
            'string',
            'regex:/^[A-Za-z][\w\d]*[A-Za-z\d]$/',
            'min:3',
            'max:32',
            'unique:plugins'
        ),
        'title' => 'nullable|string|min:3|max:30',
        'short_description' => 'nullable|string|min:5|max:70',
        'description' => 'nullable|string|min:70|max:1000',
        'version' => 'string|min:1|max:16',
//        'main' => array(
//            'required_with:plugin_source',
//            'regex:/^[a-z][a-z0-9_]*(\.[a-z0-9_]+)+[0-9a-z_]$/',
//            'unique:plugins',
//        ),
        'user_id' => 'exists:App\User,id',
//        'plugin_source' => 'file|mimes:application/zip',
    ];

    public function setIdentifierAttribute($value)
    {
        $this->attributes['identifier'] = strtolower($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function configs()
    {
        return $this->hasMany(\App\Models\PluginConfiguration::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function data() {
        return $this->hasMany(PluginData::class);
    }

    public function downloadSource()
    {
        if(!$this->plugin_source) return;
        return Storage::cloud()->download($this->plugin_source, $this->title.'.aar');
    }

    public function isRequired()
    {
        return in_array($this->id, self::REQUIRED_PLUGINS);
    }
}
