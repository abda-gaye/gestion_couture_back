<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class ApiResponseMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            return $response;
        }

        $originalData = $response->getOriginalContent();

        $success = $originalData['success'] ?? false;
        $message = $originalData['message'] ?? 'Opération effectuée.';
        $data = $originalData['response'] ?? null;

        $formattedResponse = [
            'success' => $success,
            'message' => $message,
            'response' => $data,
        ];

        $response->setContent(json_encode($formattedResponse));

        return $response;
    }
}
