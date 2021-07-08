<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StackRequest extends FormRequest
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
            'name' => 'required|max:250',
            'link' => 'nullable|url',
            'comment' => 'nullable|max:250',
        ];
    }

    public function messages()
    {
        $limitInputsMessage = '入力できる文字数は250字以内です';
        return [
            'name.required' => '入力は必須です',
            'name.max' => $limitInputsMessage,
            'link.url' => '有効なURLを入力してください',
            'comment.max' => $limitInputsMessage,
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'error' => $validator->errors(),
        ], 400);
        throw new HttpResponseException($response);
    }
}
