<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Game extends Model
{
    use SoftDeletes;

    public const STATUS_NOTHING = 'nothing';
    public const STATUS_BUILDING = 'building';
    public const STATUS_RELEASE = 'release';
    public const STATUS_ERROR = 'error';

    public $table = 'games';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|string|min:3|max:150',
//        'user_id' => 'required|exists:App\User,id'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function plugins()
    {
        return $this->belongsToMany(\App\Models\Plugin::class, GamePlugin::class, 'game_id')->withPivot('enabled');
    }

    public function download_release()
    {
        if(!$this->release_file) return;
        return Storage::cloud()->download($this->release_file, $this->title.'.'.$this->version.'.apk');
    }

}
