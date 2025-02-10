<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\api\CategoryCollection;
use App\Http\Resources\api\CategoryResource;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use App\Wix\WixStore;


class CategoryController extends Controller
{

    public function index(Request $request)
    {
        // Get only active categories
        $activeCategories = Category::getActiveTree();

        return response()->json($activeCategories, 200);
    }

    public function show(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 404);
        }

        $limit = $request->query('limit') ?: 20;
        $offset = $request->query('offset') ?: 1;

        $wixStore = new WixStore($limit, $offset, $category->collection_id);
        $products = $wixStore->getWixProducts();

        $products_data = array_map(function ($product) {
            return [
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
                'collectionIds' => $product['collectionIds'],
            ];
        }, $products['products']);

        $data = [
            'success' => true,
            'message' => 'Category retrieved successfully',
            'category' => $category,
            'products' => $products_data,
            'totalResults' => $products['totalResults'],
            'items' => $products['metadata']['items'],
            'offset' => $products['metadata']['offset'],
        ];

        return response()->json($data, 200);
    }

    public function wixCollection(Request $request)
    {
        $limit = $request->query('limit') ?: 100;
        $offset = $request->query('offset') ?: 1;

        $wixStore = new WixStore($limit, $offset);
        $collections = $wixStore->getWixCollections();

        return response()->json($collections, 200);
    }
}
