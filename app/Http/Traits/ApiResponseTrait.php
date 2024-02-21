<?php

namespace App\Http\Traits;

use App\Enums\HttpCodes;
use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * @param             $responseObj
     * @param string|null $message
     * @param bool|null   $data
     *
     * @return JsonResponse
     */
    public function handleResponse($responseObj, ?string $message = null, ?bool $data = false): JsonResponse
    {
        if ($responseObj->status != HttpCodes::SUCCESS)
            return $this->invalidResponse($responseObj->errorMessage, $responseObj->status ?? HttpCodes::UNPROCESSABLE);

        return $this->successResponse($message, $data ? $responseObj : null);
    }

    /**
     * Invalid Request Response / Custom Validation Response
     *
     * @param string $message
     * @param int    $code
     *
     * @return JsonResponse
     */
    public function invalidResponse(string $message, int $code = HttpCodes::UNPROCESSABLE): JsonResponse
    {
        return response()->json([
            'code'    => $code,
            'message' => $message,
            'data'    => null
        ], 200);
    }

    /**
     * @param string $message
     * @param        $data
     *
     * @return JsonResponse
     */
    public function successResponse(string $message, $data): JsonResponse
    {
        return response()->json([
            'code'    => HttpCodes::SUCCESS,
            'message' => $message,
            'data'    => $data
        ], 200);
    }
}
