<?php

namespace App\Http\Requests;

use App\Checklist;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateChecklist extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $checklist = Checklist::find($this->checklist_id);

        return Auth::user()->id === $checklist->created_by;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:checklists,name,NULL,NULL,deleted_at,NULL|max:255',
            'description' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'A name is required',
            'name.unique' => 'A checklist name should be unique',
            'name.max' => 'A checklist name exceeds the max limit',
            'description.required'  => 'A description is required',
        ];
    }
}
