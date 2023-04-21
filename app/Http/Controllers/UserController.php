<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updatePassword(UpdatePasswordRequest $request, User $user): JsonResponse
    {
        /** @var array $validated */
        $validated = $request->validated();

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'Password updated successfully',
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        /** @var array $validated */
        $validated = $request->validated();

        $user->update([
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
        ]);

        $user->address->update([
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip' => $validated['zip'],
        ]);

        return response()->json([
            'message' => 'User updated successfully',
        ]);
    }
}
