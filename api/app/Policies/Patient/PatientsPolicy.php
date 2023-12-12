<?php

namespace App\Policies;

use App\Models\Patients;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Access\Authorizable;

class PatientsPolicy
{
	public function viewAny(Authorizable $user)
	{
		return $user->can('viewAny role');
	}

	public function view(Authorizable $user, Role $model)
	{
		return $user->can('view role');
	}

	public function create(Authorizable $user)
	{
		return $user->can('create role');
	}

	public function update(Authorizable $user, Role $model)
	{
		return $user->can('update role') && $model->getKey() !== 1;
	}

	public function delete(Authorizable $user, Role $model)
	{
		return $user->can('delete role') && $model->getKey() !== 1;
	}

	public function history(Authorizable $user, Role $model)
	{
		return $user->can('view history') && $model->getKey() !== 1;
	}
}
