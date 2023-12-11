<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Permission;
use Illuminate\Validation\Rule;

class UpsertPatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],

            'permissions' => ['required', 'array'],
			'permissions.*' => ['required', 'integer', Rule::exists(Permission::class, 'id')],
        ];
    }
}
