<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Company;
use App\Models\User;

class AddressRepository
{
    public function __construct(private Address $model)
    {
    }

    public function updateUserAddress(array $data, User $user): bool
    {
        return $user->address->update($data);
    }

    public function updateCompanyAddress(array $data, Company $company): bool
    {
        return $company->address->update($data);
    }
}
