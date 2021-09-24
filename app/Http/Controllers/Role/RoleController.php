<?php

namespace App\Http\Controllers\Role;

use App\Contracts\Repositories\ContactInformationRepositoryInterface;
use App\Contracts\Repositories\RoleRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    private $role;

    public function __construct(RoleRepositoryInterface $role) {
        $this->role = $role;
    }

    /*
     * Show all roles in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->role->index();
    }

    /*
     * Store a newly created role in storage.
     *
     * @param  \App\Http\Requests\RoleRequest   $request
     * @return \App\Http\Resources\RoleResource
     */
    public function store(RoleRequest $request)
    {
        return $this->role->store($request);
    }

    /*
     * Updates an existing role.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\RoleRequest   $request
      * @return \App\Http\Resources\RoleResource
     */
    public function update(int $id, RoleRequest $request)
    {
       return $this->role->update($id, $request);
    }

    /*
     * Delete an existing role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        return $this->role->delete($id);
    }
}
