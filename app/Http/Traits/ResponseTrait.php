<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
    /**
     * @param string $message
     * @param null $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public function successResponse(string $message = '', $data = null, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return $this->jsonResponse($message, $statusCode, $data);
    }

    /**
     * @param mixed $data
     * @param inT $statusCode
     * @return JsonResponse
     */
    public function createdResponse(mixed $data, inT $statusCode = Response::HTTP_CREATED): JsonResponse
    {
        return new JsonResponse($data, $statusCode);
    }

    /**
     * @return JsonResponse
     */
    public function noContentResponse(): JsonResponse
    {
        return $this->successResponse('No Data found', Response::HTTP_NO_CONTENT);
    }

    /**
     * @param mixed|null $data
     * @param string $message
     * @return JsonResponse
     */
    public function badRequestResponse(string $message = '', mixed $data = null): JsonResponse
    {
        return $this->errorResponse($data, $message, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function errorResponse(mixed $data, string $message = '', int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        if (!$message) {
            $message = Response::$statusTexts[$statusCode];
        }

        $data = [
            'message' => $message,
            'errors' => $data,
        ];

        return $this->jsonResponse($message, $statusCode, $data);
    }

    public function jsonResponse(string $message, int $status, $data = null): JsonResponse
    {
        $is_successful = $status >= 200 && $status < 300;

        $response = [
            'status' => $is_successful,
            'message' => $message,
        ];

        if (! is_null($data)) {
            $response[$is_successful ? 'data' : 'error'] = $data;
        }

        return response()->json($response, $status);
    }
}
