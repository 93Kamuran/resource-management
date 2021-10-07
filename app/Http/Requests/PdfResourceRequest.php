<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class PdfResourceRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'file' => 'sometimes|mimes:pdf'
        ];
    }
}