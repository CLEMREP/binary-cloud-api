<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccountCompanyRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\User;
use App\Repositories\AddressRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\ImageRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly AddressRepository $addressRepository,
        private readonly CompanyRepository $companyRepository,
        private readonly ImageRepository $imageRepository,
    ) {
    }

    public function updatePassword(UpdatePasswordRequest $request, User $user): JsonResponse
    {
        /** @var array $validated */
        $validated = $request->validated();

        $this->userRepository->updatePassword($validated, $user);

        return response()->json([
            'message' => 'Password updated successfully',
        ]);
    }

    public function update(UpdateAccountRequest $request, User $user): JsonResponse
    {
        /** @var array $validated */
        $validated = $request->validated();

        $this->userRepository->update($validated, $user);

        $this->addressRepository->updateUserAddress($validated, $user);

        return response()->json([
            'message' => 'User updated successfully',
        ]);
    }

    public function updateCompany(UpdateAccountCompanyRequest $request, User $user): JsonResponse
    {
        /** @var array $validated */
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            /** @var UploadedFile $uploadPicture */
            $uploadPicture = $request->file('image');

            /** @var string $path */
            $path = $uploadPicture->storeAs('company_identity', time() . '.' . $uploadPicture->extension(), 'public');

            /** @var string|null $oldPath */
            $oldPath = $user->company->image?->path;

            if (isset($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            $this->imageRepository->updateOrCreateCompanyImage($path, $user->company);
        }

        $this->addressRepository->updateCompanyAddress($validated, $user->company);

        $this->companyRepository->updateUserCompany($validated, $user->company);

        return response()->json([
            'message' => 'Company updated successfully',
        ]);
    }
}
