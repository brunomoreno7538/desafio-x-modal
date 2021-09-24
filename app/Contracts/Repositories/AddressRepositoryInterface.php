<?php

namespace App\Contracts\Repositories;

use App\Http\Requests\User\AddressRequest;

interface AddressRepositoryInterface
{

    public function index();
    public function store(AddressRequest $request);
    public function update(int $id, AddressRequest $request);
    public function delete(int $id);

}
