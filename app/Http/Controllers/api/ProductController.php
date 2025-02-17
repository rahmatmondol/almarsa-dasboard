<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\api\ProductCollection;
use App\Http\Resources\api\ProductResource;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Wix\WixStore;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit') ?: 20;
        $offset = $request->query('offset') ?: 1;
        $collection_id = $request->query('collection_id') ?: null;

        $wixStore = new WixStore($limit, $offset, $collection_id);
        $products = $wixStore->getWixProducts();

        $products_data = array_map(function ($product) {
            return [
                'id' => $product['id'],
                'name' => $product['name'],
                'stock' => $product['stock'],
                'price' => $product['price'],
                'discount' => $product['discount'],
                'ribbon' => $product['ribbon'],
                'media' => $product['media'],
            ];
        }, $products['products']);

        $data = [
            'success' => true,
            'message' => 'Products retrieved successfully',
            'products' => $products_data,
            'totalResults' => $products['totalResults'],
            'items' => $products['metadata']['items'],
            'offset' => $products['metadata']['offset'],
        ];

        return response()->json($data, 200);
    }

    public function show(Request $request)
    {
        $wixStore = new WixStore(null, null, null, $request->id);
        $product = $wixStore->getWixProduct();

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        $product_data = [
            'id' => $product['id'],
            'name' => $product['name'],
            'description' => $product['description'],
            'sku' => $product['sku'] ?? '',
            'weight' => $product['weight'] ?? '',
            'stock' => $product['stock'],
            'price' => $product['price'],
            'priceRange' => $product['priceRange'],
            'discount' => $product['discount'],
            'additionalInfoSections' => $product['additionalInfoSections'],
            'ribbons' => $product['ribbons'],
            'ribbon' => $product['ribbon'],
            'media' => $product['media'],
            'productOptions' => $product['productOptions'],
            'variants' => $product['variants'],
        ];

        $data = [
            'success' => true,
            'message' => 'Products retrieved successfully',
            'product' => $product_data,
        ];

        return response()->json($data, 200);
    }

    // search products
    public function search(Request $request)
    {
        $search = $request->query('search');
        $limit = $request->query('limit') ?: 20;
        $offset = $request->query('offset') ?: 1;
        
        if (!$search) {
            return response()->json(['success' => false, 'message' => 'Search term is required'], 400);
        }

        $wixStore = new WixStore($limit, $offset);
        $products = $wixStore->searchWixProducts($search);

        $products_data = array_map(function ($product) {
            return [
                'id' => $product['id'],
                'name' => $product['name'],
                'stock' => $product['stock'],
                'price' => $product['price'],
                'discount' => $product['discount'],
                'ribbon' => $product['ribbon'],
                'media' => $product['media'],
            ];
        }, $products['products']);

        $data = [
            'success' => true,
            'message' => 'Products retrieved successfully',
            'products' => $products_data,
            'totalResults' => $products['totalResults'],
            'items' => $products['metadata']['items'],
            'offset' => $products['metadata']['offset'],
        ];

        return response()->json($data, 200);
    }
}
