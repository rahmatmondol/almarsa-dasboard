<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FirebaseDatabase
{
    public $baseUrl;
    public $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('FIREBASE_DATABASE_URL');
        $this->apiKey = env('FIREBASE_API_KEY');
    }

    public function create($path, $data)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])->post("{$this->baseUrl}/{$path}.json?auth={$this->apiKey}", $data);
        return $response->json();
    }

    public function read($path)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])->get("{$this->baseUrl}/{$path}.json?auth={$this->apiKey}");
        return $response->json();
    }

    public function update($path, $data)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])->patch("{$this->baseUrl}/{$path}.json?auth={$this->apiKey}", $data);
        return $response->json();
    }

    public function delete($path)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])->delete("{$this->baseUrl}/{$path}.json?auth={$this->apiKey}");
        return $response->json();
    }
}