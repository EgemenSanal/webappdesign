<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
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
                'name' => ['required'],
                'description' => ['required'],
                'location' => ['required'],
                'starting_date' => ['required'],
                'ending_date' => ['required'],
                'organizer_id' => ['required'],
                'capacity' => ['required'],
                'status' => ['required',Rule::in(['Active','Cancelled','Completed'])],
            ];
        }else{
            return [
                'name' => ['sometimes','required'],
                'description' => ['sometimes','required'],
                'location' => ['sometimes','required'],
                'starting_date' => ['sometimes','required'],
                'ending_date' => ['sometimes','required'],
                'organizer_id' => ['sometimes','required'],
                'capacity' => ['sometimes','required'],
                'status' => ['sometimes','required'],
            ];
        }

    }
}
