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
        $collections = Category::all();
        return response()->json($collections, 200);
    }

    public function show(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 404);
        }

        $limit = $request->query('limit', 100) ?: 100;
        $offset = $request->query('offset', 1) ?: 1;

        $wixStore = new WixStore($limit, $offset);
        $products = $wixStore->getWixProducts();

        $data = [
            'success' => true,
            'message' => 'Category retrieved successfully',
            'info' => $category,
            'data' => $products
        ];

        return response()->json($data, 200);
    }

    public function wixCollection(Request $request)
    {
        $limit = $request->query('limit', 100) ?: 100;
        $offset = $request->query('offset', 1) ?: 1;

        $wixStore = new WixStore($limit, $offset);
        $collections = $wixStore->getWixCollections();

        return response()->json($collections, 200);
    }
}
