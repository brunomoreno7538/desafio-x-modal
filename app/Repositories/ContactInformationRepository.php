<?php

namespace App\Repositories;

use App\Contracts\Repositories\ContactInformationRepositoryInterface;
use App\Http\Requests\User\ContactInformationRequest;
use App\Http\Resources\ContactInformationResource;
use App\Models\ContactInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class ContactInformationRepository implements ContactInformationRepositoryInterface
{

    private $model;

    public function __construct(ContactInformation $model)
    {
        $this->model = $model;
    }

    public function index(): JsonResponse
    {
        $contactInformation = Auth::user()->contactInformation;
        return response()->json([
            'success' => true,
            'contactInformationDetails' => $contactInformation,
        ]);
    }

    public function update(int $id, ContactInformationRequest $request)
    {
        $user = Auth::user();
        $integrity = check_integrity(ContactInformation::class, $id, $user);
        if ($integrity) {
            return $integrity;
        }
        $contactInformation = $this->model->find($id);
        $contactInformation->cellphone_number = $request->input('cellphoneNumber');
        $contactInformation->phone_number = $request->input('phoneNumber');
        $contactInformation->extra_email = $request->input('extraEmail');
        $contactInformation->save();
        return new ContactInformationResource($contactInformation);
    }

}
