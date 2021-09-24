<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ContactInformationRequest;
use App\Repositories\ContactInformationRepository;

class ContactInformationController extends Controller
{

    private $contactInformation;

    public function __construct(ContactInformationRepository $contactInformation) {
        $this->contactInformation = $contactInformation;
    }

    /*
     * Show all contact information in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->contactInformation->index();
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
        return $this->contactInformation->update($id, $request);
    }
}
