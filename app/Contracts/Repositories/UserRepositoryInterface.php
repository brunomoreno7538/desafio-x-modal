<?php

namespace App\Contracts\Repositories;

use App\Http\Requests\User\AddressRequest;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{

    public function assignRole(int $id, Request $request);

}
