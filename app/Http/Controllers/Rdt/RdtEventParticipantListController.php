<?php

namespace App\Http\Controllers\Rdt;

use App\Entities\RdtEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\RdtInvitationResource;
use Illuminate\Http\Request;

class RdtEventParticipantListController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function __invoke(Request $request, RdtEvent $rdtEvent)
    {
        $perPage   = $request->input('per_page', 15);
        $sortBy    = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $search    = $request->input('search');

        $records = $rdtEvent->invitations();

        if ($search) {
            $records->whereHas('applicant', function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('registration_code', 'like', '%'.$search.'%');
            });
        }

        $records->orderBy($sortBy, $sortOrder);
        $records->with(['applicant', 'schedule']);

        return RdtInvitationResource::collection($records->paginate($perPage));
    }
}
