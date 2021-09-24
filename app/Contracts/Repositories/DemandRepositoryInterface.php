<?php

namespace App\Contracts\Repositories;


use App\Http\Requests\PartsDemandRequest;

interface DemandRepositoryInterface
{

    public function index();
    public function store(PartsDemandRequest $request);
    public function update(int $id, PartsDemandRequest $request);
    public function delete(int $id);
    public function changeStatus(int $id);

}
