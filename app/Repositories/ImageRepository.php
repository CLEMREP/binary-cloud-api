<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Image;

class ImageRepository
{
    public function __construct(private Image $model)
    {
    }

    public function updateOrCreateCompanyImage(string $path, Company $company) : void
    {
        $image = $company->image ?? new Image();
        $image->path = $path;
        $image->save();

        $company->image_id = $image->getKey();
        $company->save();
    }
}
