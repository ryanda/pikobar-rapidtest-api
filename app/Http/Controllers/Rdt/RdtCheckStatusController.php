<?php

namespace App\Http\Controllers\Rdt;

use App\Entities\RdtApplicant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rdt\RdtCheckStatusRequest;
use App\Http\Resources\RdtApplicantResource;
use Illuminate\Support\Facades\Log;

class RdtCheckStatusController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Rdt\RdtCheckStatusRequest  $request
     * @return \App\Http\Resources\RdtApplicantResource
     */
    public function __invoke(RdtCheckStatusRequest $request)
    {
        Log::info('APPLICANT_STATUS_CHECK_REQUEST', $request->all());

        $registrationCode = $request->input('registration_code');

        $applicant = RdtApplicant::where('registration_code', $registrationCode)
            ->with(['invitations' => function ($query) {
                $query->orderBy('id', 'asc');
            }, 'invitations.event', 'invitations.schedule'])
            ->firstOrFail();

        Log::info('APPLICANT_STATUS_CHECK', [
            'id'                => $applicant->id,
            'registration_code' => $applicant->registration_code,
        ]);

        return new RdtApplicantResource($applicant);
    }
}
