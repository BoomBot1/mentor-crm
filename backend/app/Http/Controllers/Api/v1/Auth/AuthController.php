<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Enums\VerificationCode\CodePurposeType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\RefreshRequest;
use App\Http\Requests\Api\v1\Auth\SendCodeRequest;
use App\Http\Requests\Api\v1\Auth\UserAuthRequest;
use App\Http\Resources\Api\v1\Auth\TokensResource;
use App\Services\Api\v1\Auth\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $service,
    ) {
    }

    /**
     * Отправка кода подтверждения
     *
     * @unauthenticated
     */

    public function sendCode(SendCodeRequest $request): JsonResponse
    {
        $this->service->sendCode(
            $request->getData(),
            CodePurposeType::Auth
        );

        return $this->successResponse();
    }

    /**
     * Аутентификация
     *
     * @reponse {
     *     message: string,
     *     data: array{
     *         token: TokenResource
     *     }
     * }
     *
     * @unauthenticated
     */
    public function login(UserAuthRequest $request): JsonResponse
    {
        $tokensDTO = $this->service->auth(
            $request->getData(),
            CodePurposeType::Auth,
        );

        return $this->successResponse(
            data: [
                'token' => TokensResource::make($tokensDTO),
            ],
        );
    }

    /**
     * Выход
     */
    public function logout(Request $request): JsonResponse
    {
        $this
            ->service
            ->logout(
                $request->user()
            );

        return $this->successResponse();
    }

    /**
     * Обновление токенов
     *
     * @response array{
     *     message: string,
     *     data: {
     *         token: TokenResource
     *     }
     * }
     *
     * @unauthenticated
     * @throws AuthenticationException
     */
    public function refresh(RefreshRequest $request): JsonResponse
    {
        return $this->successResponse(
            data: [
                'token' => TokensResource::make(
                    $this
                        ->service
                        ->refresh($request->getData()),
                ),
            ]
        );
    }
}
