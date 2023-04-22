<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    public function __construct(private Company $model)
    {
    }

    public function updateUserCompany(array $data, Company $company): bool
    {
        return $company->update($data);
    }
}
