<?php

namespace App\Repositories;

use App\Contracts\Repositories\DemandRepositoryInterface;
use App\Http\Requests\PartsDemandRequest;
use App\Http\Resources\PartsDemandResource;
use App\Models\Address\Address;
use App\Models\PartsDemand;
use Illuminate\Support\Facades\Auth;

class DemandRepository implements DemandRepositoryInterface
{

    private $model;

    public function __construct(PartsDemand $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('ADMINISTRATOR')) {
            $demands = $this->model->all();
        } else {
            $demands = $user->demands;
        }
        return response()->json([
            'success' => true,
            'demandsCount' => $demands->count(),
            'demands' => $demands,
        ]);
    }

    public function store(PartsDemandRequest $request)
    {
        $user = Auth::user();
        $integrity = check_integrity(Address::class, $request->input('addressId'), $user);
        if ($integrity) {
            return $integrity;
        }
        $address = Address::find($request->input('addressId'));
        $partsDemand = $this->model->create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'contact_info_id' => $user->contactInformation->id,
            'part_description' => $request->input('partDescription'),
            'demand_status' => 'OPEN'
        ]);
        return new PartsDemandResource($partsDemand);
    }

    public function update(int $id, PartsDemandRequest $request)
    {
        $user = Auth::user();
        $integrity = check_integrity(PartsDemand::class, $id, $user);
        if ($integrity) {
            return $integrity;
        }
        $demand = $this->model->find($id);
        $integrityAddress = check_integrity(Address::class, $request->input('addressId'), $user);
        if ($integrityAddress) {
            return $integrityAddress;
        }
        $demand->address_id = $request->input('addressId');
        $demand->parts_description = $request->input('partsDescription');
        return new PartsDemandResource($demand);
    }

    public function delete(int $id)
    {
        $user = Auth::user();
        $integrity = check_integrity(PartsDemand::class, $id, $user);
        if ($integrity) {
            return $integrity;
        }
        $demand = PartsDemand::find($id);
        $demand->delete();
        return response()->json([
            'success' => true,
            'message' => 'Demand deleted successfully.'
        ], 200);
    }

    public function changeStatus(int $id)
    {
        $user = Auth::user();
        $integrity = check_integrity(PartsDemand::class, $id, $user);
        if ($integrity) {
            return $integrity;
        }
        $demand = $this->model->find($id);
        if ($demand->demand_status == 'FINISHED') {
            return response()->json([
                'success' => false,
                'message' => 'Demand is already finished.'
            ]);
        }
        $demand->demand_status = 'FINISHED';
        $demand->save();
        return new PartsDemandResource($demand);
    }
}
