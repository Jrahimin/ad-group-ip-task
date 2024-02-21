<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Entities\CommonResponseEntity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use ApiResponseTrait;

    protected string $exceptionMessage;
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->exceptionMessage = "Something went wrong. Please try again later.";
    }

    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $response = new CommonResponseEntity();
        try {
            $user = $this->userRepository->getUserByEmail($request->email);

            if (!$user || !Hash::check($request->password, $user->password)) {
                $response->status       = 422;
                $response->errorMessage = "User credentials did not match";

                return $this->handleResponse($response);
            }

            $user->tokens()->delete();

            $token = $user->createToken('api-token')->plainTextToken;

            $response->data = ['token' => $token];

            return $this->handleResponse($response, "Successfully logged in", true);
        } catch (\Exception $e) {
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return $this->invalidResponse($this->exceptionMessage, 500);
        }
    }
}
