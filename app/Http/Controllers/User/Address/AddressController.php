<?php

namespace App\Http\Controllers\User\Address;

use App\Contracts\Repositories\AddressRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    private $address;

    public function __construct(AddressRepositoryInterface $address) {
        $this->address = $address;
    }
    /*
     * Show all addresses in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->address->index();
    }

    /*
     * Store a newly created address in storage.
     *
     * @param  \App\Http\Requests\User\AddressRequest   $request
     * @return \App\Http\Resources\AddressResource
     */
    public function store(AddressRequest $request)
    {
        return $this->address->store($request);
    }

    /*
     * Updates an existing address.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\AddressRequest   $request
      * @return \App\Http\Resources\AddressResource
     */
    public function update(int $id, AddressRequest $request)
    {
        return $this->address->update($id, $request);
    }

    /*
     * Delete an existing address.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        return $this->address->delete($id);
    }
}
