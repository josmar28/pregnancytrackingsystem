<?php

namespace App\Services\Patient;

use App\Models\Patient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
/**
 * Class Patient.
 */


class PatientServices
{
    private Patient $model;

    public function __construct(Patient $model)
	{
		$this->model = $model;
	}

    public function getPatients(array $sort = [], array $pagination = [], array $filters = []): LengthAwarePaginator
	{
		return $this->model
			->select(['*'])
			->orderBy($sort['column'] ?? 'id', $sort['direction'] ?? 'desc')
			->presentWhereLike('first_name', Arr::get($filters, 'name'))
            ->presentWhereLike('last_name', Arr::get($filters, 'name'))
			->presentWhereDate('created_at', '>=', Arr::get($filters, 'from_date'))
			->presentWhereDate('created_at', '<=', Arr::get($filters, 'to_date'))
			->paginate(
				perPage: $pagination['per_page'] ?? config('app.per_page'), page: $pagination['page'] ?? 1
			);
	}

	public function createPatient(array $attributes): Role
	{
		try {
			DB::beginTransaction();

			$patient = $this->model->newModelInstance(
				Arr::only($attributes, ['first_name', 'last_name', 'gender', 'contact'])
			);
			$patient->save();

			DB::commit();
		} catch (\Exception $exception) {
			DB::rollBack();

			throw $exception;
		}

		return $patient;
	}
}
