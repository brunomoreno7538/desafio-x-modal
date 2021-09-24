<?php

namespace App\Http\Controllers\User;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $user;

    public function __construct(UserRepositoryInterface $user) {
        $this->user = $user;
    }

    public function assignRole(int $id, Request $request)
    {
        return $this->user->assignRole($id, $request);
    }
}
