<?php

namespace App\Repositories;

use App\Models\Patient;

class PatientRepository
{
	private Patient $patient;

	public function __construct(Patient $patient)
	{
		$this->patient = $patient;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getAllPatient()
	{
		return $this->patient::query()->oldest()->get();
	}
}