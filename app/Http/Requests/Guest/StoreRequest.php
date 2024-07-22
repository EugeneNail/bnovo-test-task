<?php

namespace App\Http\Requests\Guest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
        $countryIds = DB::table('countries')->pluck('id')->toArray();

        return [
            'name' => ['required', 'string', 'alpha', 'min:3', 'max:100'],
            'lastName' => ['required', 'string', 'alpha', 'min:3', 'max:100', ],
            'phoneNumber' => ['required', 'string', 'unique:guests,phone_number', 'regex:/^\+[0-9]{11}$/'],
            'email' => ['nullable', 'string', 'email', 'unique:guests,email'],
            'countryId' => ['nullable', 'numeric', 'integer', Rule::in($countryIds)],
        ];
    }
}
