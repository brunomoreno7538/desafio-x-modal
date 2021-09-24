<?php

namespace App\Http\Controllers\Demands;

use App\Contracts\Repositories\DemandRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartsDemandRequest;
use App\Http\Resources\PartsDemandResource;
use App\Models\Address\Address;
use App\Models\PartsDemand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class DemandController extends Controller
{

    private $demand;

    public function __construct(DemandRepositoryInterface $demand) {
        $this->demand = $demand;
    }

    public function index()
    {
        return $this->demand->index();
    }

    public function store(PartsDemandRequest $request)
    {
        return $this->demand->store($request);
    }

    public function update(int $id, PartsDemandRequest $request)
    {
        return $this->demand->update($id, $request);
    }

    public function delete(int $id)
    {
        return $this->demand->delete($id);
    }

    public function changeStatus(int $id)
    {
        return $this->demand->changeStatus($id);
    }
}
