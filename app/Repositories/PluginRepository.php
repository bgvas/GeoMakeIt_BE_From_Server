<?php

namespace App\Repositories;

use App\Jobs\ExtractUploadedPlugin;
use App\Models\Plugin;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

/**
 * Class PluginRepository
 * @package App\Repositories
 * @version May 18, 2020, 11:59 am UTC
*/

class PluginRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'description',
        'active',
        'user_id'
    ];

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
        return Plugin::class;
    }

    function create($input)
    {
        $model = $this->model->newInstance($input);
        $model->user_id = auth()->id();
        $model->save();

        return $model;
    }

    public function update($input, $id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        $model->fill($input);

        if(isset($input['plugin_source']) && !empty($input['plugin_source'])) {
            if($model->plugin_source) Storage::cloud()->delete($model->plugin_source);
            $model->plugin_source = $input['plugin_source']->store('plugins',
                App::environment('local') ? 'local' : 's3');
        }
        $model->save();

        ExtractUploadedPlugin::dispatch($model);
        return $model;
    }
}
