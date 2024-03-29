<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Repositories\IpRepositoryInterface;
use App\Entities\CommonResponseEntity;
use App\Enums\CacheKeys;
use App\Enums\HttpCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\IpAddRequest;
use App\Http\Requests\Api\IpUpdateRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Ip;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class IpController extends Controller
{
    use ApiResponseTrait;

    protected IpRepositoryInterface $ipRepository;

    public function __construct(IpRepositoryInterface $ipRepository)
    {
        $this->ipRepository = $ipRepository;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = new CommonResponseEntity();
        try {
            $ipList = $this->ipRepository->getAll();

            $response->data = $ipList;

            return $this->handleResponse($response, config('response.messages.ip_list'), true);
        } catch (\Exception $e) {
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return $this->invalidResponse(config('response.messages.exception'), HttpCodes::SERVER_ERR);
        }
    }

    public function store(IpAddRequest $request): JsonResponse
    {
        $response = new CommonResponseEntity();
        try {
            $this->ipRepository->add($request);

            Cache::forget(CacheKeys::IP_LIST_KEY);

            return $this->handleResponse($response, config('response.messages.ip_added'));
        } catch (\Exception $e) {
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return $this->invalidResponse(config('response.messages.exception'), HttpCodes::SERVER_ERR);
        }
    }

    public function update(IpUpdateRequest $request, Ip $ip): JsonResponse
    {
        $response = new CommonResponseEntity();
        try {
            $this->ipRepository->update($request, $ip);

            Cache::forget(CacheKeys::IP_LIST_KEY);

            return $this->handleResponse($response, config('response.messages.ip_updated'));
        } catch (\Exception $e) {
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return $this->invalidResponse(config('response.messages.exception'), HttpCodes::SERVER_ERR);
        }
    }
}
