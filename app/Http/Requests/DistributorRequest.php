<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DistributorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_distributor' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'nama tidak boleh kosong'
        ];
    }
}
