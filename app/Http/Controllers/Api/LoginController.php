<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Repositories\AuditTrailRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Entities\CommonResponseEntity;
use App\Enums\AuditTrailActions;
use App\Enums\HttpCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Jobs\AddAuditTrailEntry;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use ApiResponseTrait;

    protected UserRepositoryInterface $userRepository;
    protected AuditTrailRepositoryInterface $auditTrailRepository;

    public function __construct(UserRepositoryInterface $userRepository, AuditTrailRepositoryInterface $auditTrailRepository)
    {
        $this->userRepository       = $userRepository;
        $this->auditTrailRepository = $auditTrailRepository;
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
                $response->status       = HttpCodes::UNAUTHORIZED;
                $response->errorMessage = config('response.messages.credentials_mismatch');

                return $this->handleResponse($response);
            }

            $user->tokens()->delete();

            $token = $user->createToken('api-token')->plainTextToken;

            $response->data = ['token' => $token];

            //$this->auditTrailRepository->add($user, AuditTrailActions::LOGIN);
            AddAuditTrailEntry::dispatch($user, AuditTrailActions::LOGIN);

            return $this->handleResponse($response, config('response.messages.logged_in'), true);
        } catch (\Exception $e) {
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return $this->invalidResponse(config('response.messages.exception'), HttpCodes::SERVER_ERR);
        }
    }
}
