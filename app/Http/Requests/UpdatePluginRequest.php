<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Plugin;
use Illuminate\Validation\Rule;

class UpdatePluginRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        dd(Rule::unique('plugins', 'id')->ignore($this->plugin->id));
        $rules = Plugin::$rules;
        $rules['identifier'] = array(
            'required',
            'regex:/^[A-Za-z][\w\d]*[A-Za-z\d]$/',
            'max:32',
            Rule::unique('plugins')->ignore($this->plugin->id),
        );
//        $rules['main'] = array(
//            'required_with:plugin_source',
//            'regex:/^[a-z][a-z0-9_]*(\.[a-z0-9_]+)+[0-9a-z_]$/',
//            Rule::unique('plugins', 'id')->ignore($this->plugin),
//        );
        return $rules;
    }
}
