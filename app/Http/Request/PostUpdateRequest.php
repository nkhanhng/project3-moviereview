<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class PostUpdateRequest extends FormRequest
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
        return [
            'name'          => 'required',
            'description'   => 'required',
            'content'       => 'required',
            'id'   => 'required',
        ];
    }
    public function message(){
         return [
            'name.required'         => 'The title is required ',
            'description.required'   => 'The description is required',
            'content.required'       => 'The content is required',
            'id.required'   => 'We have some exception',
    ];
    }
}