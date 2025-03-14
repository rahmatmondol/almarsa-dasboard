<?php

// app/Wix/WixStore.php
namespace App\Wix;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class WixStore
{
    public $limit;
    public $offset;
    public $collectionId;
    public $productId;

    /**
     * Constructor for the WixStore class
     *
     * @param int $limit The maximum number of items to retrieve
     * @param int $offset The starting point for item retrieval
     */

    public function __construct($limit, $offset, $collectionId = null, $productId = null)
    {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->collectionId = $collectionId;
        $this->productId = $productId;
    }

    /**
     * Get collections from Wix Store
     *
     * @return array
     * @throws Exception
     */
    public function getWixCollections(): array
    {
        try {
            $accessToken = Auth::getAccessToken();
            if (!$accessToken) {
                throw new Exception('Failed to obtain valid Wix access token');
            }

            $response = Http::withOptions([
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                ],
                'timeout' => 30,
            ])
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ])
                ->post(config('services.wix.base_url') . '/stores/v1/collections/query', [
                    "query" => [
                        "paging" => [
                            "limit" => $this->limit,
                            "offset" => $this->offset
                        ]
                    ],
                    "includeNumberOfProducts" => true,
                    "includeDescription" => true
                ]);

            if (!$response->successful()) {
                Log::error('Wix API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new Exception('API request failed: ' . $response->status());
            }
            $data = $response->json();

            if (!isset($data['collections'])) {
                throw new Exception('Invalid response structure from Wix API');
            }

            // Return just the collections array
            return $data;
        } catch (Exception $e) {
            Log::error('Wix Collections Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Get products from Wix Store
     *
     * @return array
     * @throws Exception
     */
    public function getWixProducts(): array
    {
        try {
            $accessToken = Auth::getAccessToken();
            if (!$accessToken) {
                throw new Exception('Failed to obtain valid Wix access token');
            }

            $filter = json_encode([
                "collections.id" => [
                    "\$hasSome" => [$this->collectionId]
                ]
            ]);

            $response = Http::withOptions([
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                ],
                'timeout' => 30,
            ])
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ])
                ->post(config('services.wix.base_url') . '/stores/v1/products/query', [
                    "query" => [
                        "paging" => [
                            "limit" => $this->limit,
                            "offset" => $this->offset,
                        ],
                        "filter" => $this->collectionId ? $filter : null,
                        "includeNumberOfProducts" => true,
                        "includeDescription" => true,
                        "includeVariants" => true,
                    ],
                ]);

            if (!$response->successful()) {
                Log::error('Wix API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new Exception('API request failed: ' . $response->status());
            }
            $data = $response->json();

            if (!isset($data['products'])) {
                throw new Exception('Invalid response structure from Wix API');
            }

            // Return just the collections array
            return $data;
        } catch (Exception $e) {
            Log::error('Wix Collections Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }


    /**
     * Get single product from Wix Store
     *
     * @return array
     * @throws Exception
     */
    public function getWixProduct()
    {
        try {
            $accessToken = Auth::getAccessToken();
            if (!$accessToken) {
                throw new Exception('Failed to obtain valid Wix access token');
            }

            $response = Http::withOptions([
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                ],
                'timeout' => 30,
            ])
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ])
                ->get(config('services.wix.base_url') . '/stores/v1/products/' . $this->productId);

            if (!$response->successful()) {
                Log::error('Wix API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return false;
            }
            $data = $response->json();

            if (!isset($data['product'])) {
                return false;
            }

            // Return just the collections array
            return $data['product'];
        } catch (Exception $e) {
            Log::error('Wix Collections Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * search single product from Wix Store
     *
     * @return array
     * @throws Exception
     */
    public function searchWixProducts($query)
    {
        try {
            $accessToken = Auth::getAccessToken();
            if (!$accessToken) {
                throw new Exception('Failed to obtain valid Wix access token');
            }

            $filter = json_encode([
                "name" => [
                    "\$contains" => [$query]
                ]
            ]);

            $response = Http::withOptions([
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                ],
                'timeout' => 30,
            ])
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ])
                ->post(config('services.wix.base_url') . '/stores/v1/products/query', [
                    "query" => [
                        "paging" => [
                            "limit" => $this->limit,
                            "offset" => $this->offset,
                        ],
                        "filter" => $filter,
                        "includeNumberOfProducts" => true,
                        "includeDescription" => true,
                        "includeVariants" => true,
                    ],
                ]);

            if (!$response->successful()) {
                Log::error('Wix API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new Exception('API request failed: ' . $response->status());
            }
            $data = $response->json();

            if (!isset($data['products'])) {
                throw new Exception('Invalid response structure from Wix API');
            }

            // Return just the collections array
            return $data;
        } catch (Exception $e) {
            Log::error('Wix Collections Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
