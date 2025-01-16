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
        $collections = WixStore::getWixProducts();
        return response()->json($collections, 200);
       
    }

    public function show(Request $request, Category $category): Response
    {
        return new CategoryResource($category);
    }
}
