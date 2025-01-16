<?php

namespace App\Wix;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class Auth
{
    private const TOKEN_CACHE_KEY = '';
    private const CACHE_REFRESH_KEY = '';
    private const TOKEN_CACHE_DURATION = 14400;
    
    /**
     * Get a valid access token, either from cache or by generating a new one
     *
     * @return string|null
     */
    public static function getAccessToken(): ?string
    {
        try {
            // Check if we have a valid cached token
            $cachedToken = self::getValidCachedToken();
            if ($cachedToken) {
                return $cachedToken;
            }

            // If no valid cached token, generate a new one
            return self::generateNewToken();
        } catch (Exception $e) {
            Log::error('Failed to get Wix access token: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return null;
        }
    }

    /**
     * Get cached token if it exists and is valid
     *
     * @return string|null
     */
    private static function getValidCachedToken(): ?string
    {
        $token = Cache::get(self::TOKEN_CACHE_KEY);
        return $token ?? null;
    }

    /**
     * Generate a new access token from Wix API
     *
     * @return string|null
     * @throws Exception
     */
    private static function generateNewToken(): ?string
    {
        $response = Http::withOptions([
            'verify' => false,
        ])->post(config('services.wix.base_url').'/oauth2/token', [
            "clientId" => config('services.wix.client_id'),
            "grantType" => "anonymous"
        ]);

        if (!$response->successful()) {
            throw new Exception('Failed to get Wix token: ' . $response->body());
        }

        $data = $response->json();
        $token = $data['access_token'] ?? null;
        $refresh = $data['refresh_token'] ?? null;

        if (!$token) {
            throw new Exception('No access token in Wix response');
        }

        // Store the new token in cache
        Cache::put(self::TOKEN_CACHE_KEY, $token, self::TOKEN_CACHE_DURATION, self::CACHE_REFRESH_KEY, $refresh);

        return $token;
    }
}