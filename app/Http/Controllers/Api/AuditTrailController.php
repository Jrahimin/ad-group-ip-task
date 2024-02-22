<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Repositories\AuditTrailRepositoryInterface;
use App\Entities\CommonResponseEntity;
use App\Enums\HttpCodes;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AuditTrailController extends Controller
{
    use ApiResponseTrait;

    protected AuditTrailRepositoryInterface $auditTrailRepository;

    public function __construct(AuditTrailRepositoryInterface $auditTrailRepository)
    {
        $this->auditTrailRepository = $auditTrailRepository;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = new CommonResponseEntity();
        try {
            $auditTrail = $this->auditTrailRepository->getAll();

            $response->data = $auditTrail;

            return $this->handleResponse($response, config('response.messages.audit_trail'), true);
        } catch (\Exception $e) {
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return $this->invalidResponse(config('response.messages.exception'), HttpCodes::SERVER_ERR);
        }
    }
}
