<?php

namespace App\Http\Requests\users;

use Illuminate\Foundation\Http\FormRequest;

class PengaduanUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kategori_id' => [
                'required',
                'exists:category_reports,id'
            ],
            'judul' => [
                'required',
                'string',
                'max:255'
            ],
            'isi_pengaduan' => [
                'required',
                'string',
                'max:1000'
            ],
            
        ];
    }
}
