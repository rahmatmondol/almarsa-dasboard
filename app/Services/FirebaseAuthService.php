<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class FirebaseAuthService
{
    private string $apiKey;
    private string $baseUrl = 'https://identitytoolkit.googleapis.com/v1';
    private string $refreshTokenUrl = 'https://securetoken.googleapis.com/v1/token';

    public function __construct()
    {
        $this->apiKey = config('services.firebase.api_key');
    }

    /**
     * Sign up a new user
     *
     * @param string $email
     * @param string $password
     * @return array
     * @throws Exception
     */
    public function signUp(string $email, string $password): array
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->post("{$this->baseUrl}/accounts:signUp?key={$this->apiKey}", [
                'email' => $email,
                'password' => $password,
                'returnSecureToken' => true
            ]);

            if ($response->failed()) {
                throw new Exception($response['error']['message'] ?? 'Sign up failed');
            }

            return $response->json();
        } catch (Exception $e) {
            logger()->error('Firebase signup error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Sign in an existing user
     *
     * @param string $email
     * @param string $password
     */
    public function signIn(string $email, string $password)
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->post("{$this->baseUrl}/accounts:signInWithPassword?key={$this->apiKey}", [
                'email' => $email,
                'password' => $password,
                'returnSecureToken' => true
            ]);

            if ($response->failed()) {
                return false;
            }

            return $response->json();
        } catch (Exception $e) {
            logger()->error('Firebase signin error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get user profile information
     *
     * @param string $idToken
     * @return array
     * @throws Exception
     */
    public function getUserProfile(string $idToken): array
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->post("{$this->baseUrl}/accounts:lookup?key={$this->apiKey}", [
                'idToken' => $idToken
            ]);

            if ($response->failed()) {
                throw new Exception($response['error']['message'] ?? 'Profile lookup failed');
            }

            return $response->json()['users'][0] ?? [];
        } catch (Exception $e) {
            logger()->error('Firebase get profile error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Refresh authentication token
     *
     * @param string $refreshToken
     * @return array
     * @throws Exception
     */
    public function refreshToken(string $refreshToken): array
    {
        try {
            $response = Http::asForm()->post($this->refreshTokenUrl, [
                'key' => $this->apiKey,
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken
            ]);

            if ($response->failed()) {
                throw new Exception($response['error']['message'] ?? 'Token refresh failed');
            }

            return $response->json();
        } catch (Exception $e) {
            logger()->error('Firebase token refresh error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Send password reset email
     *
     * @param string $email
     * @return array
     * @throws Exception
     */
    public function sendPasswordResetEmail(string $email): array
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->post("{$this->baseUrl}/accounts:sendOobCode?key={$this->apiKey}", [
                'requestType' => 'PASSWORD_RESET',
                'email' => $email
            ]);

            if ($response->failed()) {
                throw new Exception($response['error']['message'] ?? 'Password reset failed');
            }

            return $response->json();
        } catch (Exception $e) {
            logger()->error('Firebase password reset error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update user profile
     *
     * @param string $idToken
     * @param array $profileData
     * @return array
     * @throws Exception
     */
    public function updateProfile(string $idToken, array $profileData): array
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->post("{$this->baseUrl}/accounts:update?key={$this->apiKey}", [
                'idToken' => $idToken,
                ...$profileData
            ]);

            if ($response->failed()) {
                throw new Exception($response['error']['message'] ?? 'Profile update failed');
            }

            return $response->json();
        } catch (Exception $e) {
            logger()->error('Firebase profile update error: ' . $e->getMessage());
            throw $e;
        }
    }
}