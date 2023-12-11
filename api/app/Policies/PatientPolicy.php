<?php

namespace App\Policies;

use App\Models\Patient;
use Illuminate\Contracts\Auth\Access\Authorizable;

class PatientPolicy
{
	public function viewAny(Authorizable $user)
	{
		return $user->can('viewAny patient');
	}

	public function view(Authorizable $user, Patient $model)
	{
		return $user->can('view patient');
	}

	public function create(Authorizable $user)
	{
		return $user->can('create patient');
	}

	public function update(Authorizable $user, Patient $model)
	{
		return $user->can('update patient') && $model->getKey() !== 1;
	}

	public function delete(Authorizable $user, Patient $model)
	{
		return $user->can('delete patient') && $model->getKey() !== 1;
	}

	public function changeStatus(Authorizable $user, Patient $model)
	{
		return $user->can('changeStatus patient') && $model->getKey() !== 1;
	}
}
