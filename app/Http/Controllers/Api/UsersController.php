<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UsersController extends Controller
{
    public function index(SearchUserRequest $request)
    {
        $data = $request->validated();
        $query = User::SearchApi(collect($data));

        return UserResource::collection($query->get());
    }
}
