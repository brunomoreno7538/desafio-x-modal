<?php

namespace App\Repositories;

use App\Contracts\Repositories\AddressRepositoryInterface;
use App\Http\Requests\User\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Psy\Util\Json;

class AddressRepository implements AddressRepositoryInterface
{

    private $model;

    public function __construct(Address $model)
    {
        $this->model = $model;
    }

    public function index(): JsonResponse
    {
        $addresses = $this->model->where([
        'user_id' => Auth::id(),
        'active' => true,
    ])->get();
        return response()->json([
            'success' => true,
            'addressesCount' => $addresses->count(),
            'addresses' => $addresses,
        ]);
    }

    public function store(AddressRequest $request): AddressResource
    {
        $address =  $this->model->create([
            'user_id' => Auth::id(),
            'address_line_1' => $request->input('firstAddressLine'),
            'address_line_2' => $request->input('secondAddressLine'),
            'postal_code' => $request->input('postalCode'),
            'city' => $request->input('city'),
            'state_id' => $request->input('stateId'),
        ]);
        return new AddressResource($address);
    }

    public function update(int $id, AddressRequest $request)
    {
        $user = Auth::user();
        $integrity = check_integrity(Address::class, $id, $user);
        if ($integrity) {
            return $integrity;
        }
        $address =  $this->model->find($id);
        $address->address_line_1 = $request->input('firstAddressLine');
        $address->address_line_2 = $request->input('secondAddressLine');
        $address->postal_code = $request->input('postalCode');
        $address->city = $request->input('city');
        $address->state_id = $request->input('stateId');
        $address->save();
        return new AddressResource($address);
    }

    public function delete(int $id): JsonResponse
    {
        $user = Auth::user();
        $integrity = check_integrity(Address::class, $id, $user);
        if ($integrity) {
            return $integrity;
        }
        $address =  $this->model->find($id);
        $address->active = false;
        $address->save();
        return response()->json([
            'success' => true,
            'message' => 'Address successfully deleted.'
        ], 200);
    }
}
