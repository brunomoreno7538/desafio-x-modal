<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ContactInformationRequest;
use App\Http\Resources\ContactInformationResource;
use App\Models\ContactInformation;
use Illuminate\Support\Facades\Auth;

class ContactInformationController extends Controller
{

    /*
     * Show all contact information in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactInformation = Auth::user()->contactInformation;
        return response()->json([
            'success' => true,
            'contactInformationDetails' => $contactInformation,
        ]);
    }

    /*
     * Updates an contact information.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\ContactInformationRequest   $request
      * @return \App\Http\Resources\ContactInformationResource
     */
    public function update(int $id, ContactInformationRequest $request)
    {
        $user = Auth::user();
        $integrity = check_integrity(ContactInformation::class, $id, $user);
        if ($integrity) {
            return $integrity;
        }
        $contactInformation = ContactInformation::find($id);
        $contactInformation->cellphone_number = $request->input('cellphoneNumber');
        $contactInformation->phone_number = $request->input('phoneNumber');
        $contactInformation->extra_email = $request->input('extraEmail');
        $contactInformation->save();
        return new ContactInformationResource($contactInformation);
    }
}
