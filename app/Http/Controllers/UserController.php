<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Shop;
use Hossam\Licht\Controllers\LichtBaseController;
use Illuminate\Support\Facades\Hash;

class UserController extends LichtBaseController
{

    public function index()
    {
        $users = User::with('shop')->get();
        $shops = Shop::all();
        $users = UserResource::collection($users);
        return view('users', compact('users', 'shops'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        return $this->successResponse(UserResource::make($user));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();

        if (empty($validatedData['password'])) {
            unset($validatedData['password']);
        } else {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);
        return redirect()->route('users.index');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
