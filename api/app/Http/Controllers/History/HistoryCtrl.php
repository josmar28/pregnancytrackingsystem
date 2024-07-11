<?php

namespace App\Http\Controllers\History;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Facades\Responder;
use App\Http\Requests\Patient\SearchPatientRequest;
use App\Http\Requests\Patient\UpsertPatientRequest;
use App\Http\Requests\Patient\PatientRequest;
use App\Services\Patient\PatientServices;
use App\Http\Resources\Patient\PatientResource;
use App\Repositories\PatientRepository;
use Illuminate\Http\Response;

class HistoryCtrl extends Controller
{
    private PatientServices $PatientServices;
	private PatientRepository $patientRepository;


    public function __construct(PatientServices $PatientServices, PatientRepository $patientRepository)
	{
		$this->PatientServices = $PatientServices;
		$this->patientRepository = $patientRepository;

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

	public function show(Patient $patient)
	{
		return Responder::setData(
			new PatientResource($patient)
		)->respond();
	}

	public function update(Patient $patient, UpsertPatientRequest $request)
	{
		$this->PatientServices->updatePatient(
			$patient,
			$request->only(['first_name', 'last_name', 'gender', 'contact','status'])
		);

		return Responder::setData(new PatientServices($patient))
			->setMessage(trans('dashboard.updated_successfully'))
			->respond();
	}

	public function store(UpsertPatientRequest $request)
	{
		$patient = $this->PatientServices->createPatient(
			$request->only(['first_name', 'last_name', 'gender', 'contact','status'])
		);

		return Responder::setData(new PatientServices($patient))
			->setMessage(trans('dashboard.created_successfully'))
			->setStatusCode(Response::HTTP_CREATED)
			->respond();
	}

	public function destroy(Patient $patient)
	{
		$this->PatientServices->deletePatient($patient);

		return Responder::setMessage(trans('dashboard.deleted_successfully'))
			->respond();
	}
}
