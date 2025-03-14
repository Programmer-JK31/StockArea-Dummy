<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserShowRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'required|int|exists:users,id',
            'load_books' => 'sometimes|boolean'
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'id' => $this->route('id')
        ]);
        $this->mergeIfMissing([
            'load_books' => false, // Default value if not present
        ]);
    }
}
