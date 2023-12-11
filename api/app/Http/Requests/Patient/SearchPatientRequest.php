<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Dashboard\BaseDashboardRequest;

class SearchPatientRequest extends BaseDashboardRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			...$this->getPaginationRules(allowedSortColumns: 
            [
                'id', 'first_name','last_name','created_at','contact','gender',
            ]),

			'name' => ['nullable', 'string', 'max:255'],
			'from_date' => ['nullable', 'date', 'date_format:Y-m-d'],
			'to_date' => ['nullable', 'date', 'date_format:Y-m-d'],
		];
    }
}
