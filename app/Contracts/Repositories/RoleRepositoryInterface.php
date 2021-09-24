<?php

namespace App\Contracts\Repositories;

use App\Http\Requests\RoleRequest;
use App\Models\Role;

interface RoleRepositoryInterface
{

    public function index();
    public function store(RoleRequest $request);
    public function update(int $id, RoleRequest $request);
    public function delete(int $id);
}
