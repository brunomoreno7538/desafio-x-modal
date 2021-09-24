<?php

namespace App\Contracts\Repositories;

use App\Http\Requests\User\ContactInformationRequest;

interface ContactInformationRepositoryInterface
{
    public function index();
    public function update(int $id, ContactInformationRequest $request);
}
