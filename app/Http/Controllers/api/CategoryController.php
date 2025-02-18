<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Wix\WixStore;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        // Get only active categories
        $activeCategories = Category::getActiveTree();

        if (!$activeCategories) {
            return response()->json(['success' => false, 'message' => 'No categories found'], 404);
        }

        $activeCategories->transform(function ($category) {
            if (!$category->image) {
                $category->image = url('assets/images/all-categories.png');
            }
            if (!$category->icon) {
                $category->icon = url('assets/images/all-categories-icon.png');
            }
            return $category;
        });

        return response()->json($activeCategories, 200);
    }

    public function show(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 404);
        }

        if (!$category->image) {
            $category->image = url('assets/images/all-categories.png');
        }
        if (!$category->icon) {
            $category->icon = url('assets/images/all-categories-icon.png');
        }

        $limit = $request->query('limit') ?: 20;
        $offset = $request->query('offset') ?: 1;

        $wixStore = new WixStore($limit, $offset, $category->collection_id);
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
