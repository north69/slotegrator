<?php
namespace Core;

use Symfony\Component\HttpFoundation\JsonResponse;

trait ApiControllerTrait
{
    private function jsonResponse($data = null, int $http_code = JsonResponse::HTTP_OK): JsonResponse
    {
        return new JsonResponse($data, $http_code);
    }

    private function jsonErrorResponse(int $http_code = JsonResponse::HTTP_NOT_FOUND, array $errors = []): JsonResponse
    {
        $data = [
            'code' => $http_code,
            'message' => JsonResponse::$statusTexts[$http_code],
        ];
        if ($errors) {
            $data['errors'] = $errors;
        }
        return new JsonResponse($data, $http_code);
    }

}