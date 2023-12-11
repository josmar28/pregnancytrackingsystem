<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Facades\Responder;
use App\Http\Requests\Patient\SearchPatientRequest;
use App\Http\Requests\Patient\UpsertPatientRequest;
use App\Http\Requests\Patient\PatientRequest;
use App\Services\Patient\PatientServices;
use App\Http\Resources\Patient\PatientResource;
use App\Repositories\PermissionRepository;

class PatientCtrl extends Controller
{
    private PatientServices $PatientServices;
	private PermissionRepository $permissionRepository;


    public function __construct(PatientServices $PatientServices, PermissionRepository $permissionRepository)
	{
		$this->PatientServices = $PatientServices;
		$this->permissionRepository = $permissionRepository;

		$this->authorizeResource(Patient::class);
	}

    public function index(SearchPatientRequest $request)
	{
		$patients = $this->PatientServices->getPatients(
			[
				'column' => $request->sort,
				'direction' => $request->sort_dir,
			],
			$request->only(['page', 'per_page']),
			$request->only(['name', 'from_date', 'to_date']),
		);

		return Responder::setPaginatedData(
			PatientResource::collection($patients)
		)->respond();
	}

	public function show(Patient $role)
	{
		$patients->load('permissions');

		return Responder::setData(
			new PatientResource($patients)
		)->respond();
	}

	public function store(UpsertPatientRequest $request)
	{
		$patient = $this->PatientServices->createPatient(
			$request->only(['first_name', 'last_name', 'gender', 'contact'])
		);

		return Responder::setData(new PatientServices($patient))
			->setMessage(trans('dashboard.created_successfully'))
			->setStatusCode(Response::HTTP_CREATED)
			->respond();
	}
}
