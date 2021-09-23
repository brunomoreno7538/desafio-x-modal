<?php

namespace App\Http\Controllers\User\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /*
     * Show all addresses in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::where([
            'user_id' => Auth::id(),
            'active' => true,
        ])->get();
        return response()->json([
            'success' => true,
            'addressesCount' => $addresses->count(),
            'addresses' => $addresses,
        ]);
    }

    /*
     * Store a newly created address in storage.
     *
     * @param  \App\Http\Requests\User\AddressRequest   $request
     * @return \App\Http\Resources\AddressResource
     */
    public function store(AddressRequest $request)
    {
        $address = Address::create([
            'user_id' => Auth::id(),
            'address_line_1' => $request->input('firstAddressLine'),
            'address_line_2' => $request->input('secondAddressLine'),
            'postal_code' => $request->input('postalCode'),
            'city' => $request->input('city'),
            'state_id' => $request->input('stateId'),
        ]);
        return new AddressResource($address);
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
        $user = Auth::user();
        $integrity = check_integrity(Address::class, $id, $user);
        if ($integrity) {
            return $integrity;
        }
        $address = Address::find($id);
        $address->address_line_1 = $request->input('firstAddressLine');
        $address->address_line_2 = $request->input('secondAddressLine');
        $address->postal_code = $request->input('postalCode');
        $address->city = $request->input('city');
        $address->state_id = $request->input('stateId');
        $address->save();
        return new AddressResource($address);
    }

    /*
     * Delete an existing address.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = Auth::user();
        $integrity = check_integrity(Address::class, $id, $user);
        if ($integrity) {
            return $integrity;
        }
        $address = Address::find($id);
        $address->active = false;
        $address->save();
        return response()->json([
            'success' => true,
            'message' => 'Address successfully deleted.'
        ], 200);
    }
}
