<?php

declare(strict_types=1);

if (!function_exists('vr_verify_recaptcha_v3')) {
    function vr_verify_recaptcha_v3(
        string $token,
        string $secretKey,
        string $expectedAction,
        float $minimumScore = 0.5,
        ?string $remoteAddress = null
    ): bool {
        if ($token === '' || $secretKey === '') {
            return false;
        }

        $payload = [
            'secret' => $secretKey,
            'response' => $token,
        ];
        if ($remoteAddress !== null && filter_var($remoteAddress, FILTER_VALIDATE_IP)) {
            $payload['remoteip'] = $remoteAddress;
        }

        $responseBody = false;
        if (function_exists('curl_init')) {
            $request = curl_init('https://www.google.com/recaptcha/api/siteverify');
            if ($request !== false) {
                curl_setopt_array($request, [
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => http_build_query($payload),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CONNECTTIMEOUT => 5,
                    CURLOPT_TIMEOUT => 10,
                    CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
                ]);
                $responseBody = curl_exec($request);
                $statusCode = (int) curl_getinfo($request, CURLINFO_HTTP_CODE);
                curl_close($request);
                if ($statusCode !== 200) {
                    $responseBody = false;
                }
            }
        } elseif (filter_var(ini_get('allow_url_fopen'), FILTER_VALIDATE_BOOL)) {
            $context = stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
                    'content' => http_build_query($payload),
                    'timeout' => 10,
                    'ignore_errors' => true,
                ],
            ]);
            $responseBody = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        }

        if (!is_string($responseBody) || $responseBody === '') {
            return false;
        }

        $result = json_decode($responseBody, true);
        if (!is_array($result)) {
            return false;
        }

        $errorCodes = $result['error-codes'] ?? [];
        if (is_array($errorCodes) && $errorCodes !== []) {
            return false;
        }

        $score = isset($result['score']) && is_numeric($result['score']) ? (float) $result['score'] : -1.0;
        return ($result['success'] ?? false) === true
            && hash_equals($expectedAction, (string) ($result['action'] ?? ''))
            && $score >= max(0.0, min(1.0, $minimumScore));
    }
}
