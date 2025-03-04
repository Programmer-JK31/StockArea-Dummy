<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreAssignBook extends FormRequest
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
        // return [
        //     'user_id' => 'required|int|exists:users,id',
        //     'shelf_id' => 'required|int|exists:shelf,id',
        //     'book_id' => 'required|int|exists:books,id'
        // ];

        return [
            'user_id' => 'required|int|exists:users,id',
            'shelf_id' => [
                'required',
                Rule::exists('shelf', 'id')->where('user_id', $this->input('user_id'))
            ],
            'book_id' => 'required|int|exists:books,id|unique:shelf_has_books,book_id'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
