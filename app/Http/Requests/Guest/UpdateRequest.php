<?php

namespace App\Http\Requests\Guest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
        $guestId = $this->route('guest');
        $countryIds = DB::table('countries')->pluck('id')->toArray();

        return [
            'name' => ['required', 'string', 'alpha', 'min:3', 'max:100'],
            'lastName' => ['required', 'string', 'alpha', 'min:3', 'max:100'],
            'phoneNumber' => [
                'required', 'string', 'regex:/^\+[0-9]{11}$/',
                Rule::unique('guests', 'phone_number')->ignore($guestId),
            ],
            'email' => [
                'nullable', 'string', 'email',
                Rule::unique('guests', 'email')->ignore($guestId),
            ],
            'countryId' => ['nullable', 'numeric', 'integer', Rule::in($countryIds)],
        ];
    }
}
