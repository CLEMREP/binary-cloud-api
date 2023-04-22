<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function __construct(private User $model)
    {
    }

    public function updatePassword(array $data, User $user): bool
    {
        return $user->update([
            'password' => Hash::make($data['password']),
        ]);
    }

    public function update(array $data, User $user): bool
    {
        return $user->update($data);
    }
}
