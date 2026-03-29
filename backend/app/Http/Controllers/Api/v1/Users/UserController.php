<?php

namespace App\Http\Controllers\Api\v1\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\Users\UserAccountResource;
use App\Services\Api\v1\Users\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UserController extends Controller
{
    public function __construct(
        private readonly UserService $service,
    ) {
    }

    public function getAccount(Request $request): JsonResponse
    {
        $user = $request->user();

        $dto = $this->service->getAccount($user, $user->role);

        return $this->successResponse(
            data: [
                'data' => UserAccountResource::make($dto),
            ],
        );
    }
}
