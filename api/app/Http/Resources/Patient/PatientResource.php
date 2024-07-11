<?php

namespace App\Http\Resources\Patient;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Dashboard\ResourcePolicyTrait;
use Illuminate\Support\Facades\Auth;
use App\Policies\PatientPolicy;

class PatientResource extends JsonResource
{
    use ResourcePolicyTrait;

	/**
	 * @var PatientPolicy
	 */
	protected static $policy;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
			'id' => $this->id,
			'first_name' => $this->first_name,
			'last_name' => $this->last_name,
			'gender' => $this->gender,
            'contact' => $this->contact,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'actions' => [
				'can_view' => self::$policy->view(Auth::user(), $this->resource),
				'can_update' => self::$policy->update(Auth::user(), $this->resource),
				'can_delete' => self::$policy->delete(Auth::user(), $this->resource),
			]
		];
    }
}
