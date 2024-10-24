<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateInvoiceRequest extends FormRequest
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
        $method  = $this->method();
        if($method == 'PUT'){
            return [
                'status' => ['required',Rule::in(['B','P','V'])],
                'memberID' => ['required'],
                'billedDate' => ['required'],
                'paidDate' => ['sometimes','required'],
            ];
        }else{
            return [
                'status' => ['sometimes','required'],
                'memberID' => ['sometimes','required',Rule::in(['B','P','V'])],
                'billedDate' => ['sometimes','required'],
                'paidDate' => ['sometimes','required'],
            ];
        }
    }
}
