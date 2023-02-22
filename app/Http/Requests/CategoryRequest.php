<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'code' => 'required|min:3|max:255|unique:categories,code',
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:5',
        ];

        if ($this->route()->named('categories.update')) { // Если категория создается, то проверяем на уникальность поле code. Если категория изменяется (update), то проверять не надо. Найдет, что такое значение уже есть и выдаст ошибку.

            $rules['code'] .= ',' . $this->route()->parameter('category')->id; // .= добавит к тому, что было.

        }
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'Поле :attribute обязательно для заполнения', // :attribute автоматом подставит имя поля.
            'min' => 'Поле :attribute должно иметь минимум :min символов',
            'code.min' => 'Поле код должно иметь минимум :min символов', // Применится только для поля code.
            'max' => 'Поле :attribute должно иметь максимум :max символов',

        ];
    }
}
