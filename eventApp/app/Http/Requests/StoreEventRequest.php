<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
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
            'name' => ['required'],
            'description' => ['required'],
            'location' => ['required'],
            'starting_date' => ['required'],
            'ending_date' => ['required'],
            'organizer_id' => ['required'],
            'capacity' => ['required'],
            'status' => ['required',Rule::in(['Active','Cancelled','Completed'])],
        ];
    }
}
