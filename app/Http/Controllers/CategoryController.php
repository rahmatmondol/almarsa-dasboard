<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Wix\WixStore;
use Illuminate\Support\Str;
use App\Http\Resources\api\CategoryResource;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    public function create(Request $request)
    {
        $categories = Category::all();
        return view('category.create', compact('categories'));
    }

    public function store(CategoryStoreRequest $request)
    {
        try {
            $category = new Category;
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->description = $request->description;
            $category->parent_id = $request->parent_id;
            $category->product_count = $request->product_count;
            $category->collection_id = $request->collection_id;
            $category->status = $request->status;
            $category->save();

            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $originalName = $imageFile->getClientOriginalName();
                $filename = time() . '_' . $originalName;
                $imageFile->move('uploads/categories/', $filename);
                $category->image = url('uploads/categories/' . $filename);
                $category->save();
            }

            if ($request->hasFile('icon')) {
                $imageFile = $request->file('icon');
                $originalName = $imageFile->getClientOriginalName();
                $filename = time() . '_' . $originalName;
                $imageFile->move('uploads/categories/', $filename);
                $category->icon = url('uploads/categories/' . $filename);
                $category->save();
            }

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Category created successfully',
                    'data' => new CategoryResource($category)
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(Request $request, Category $category): View
    {
        $categories = Category::all();
        return view('category.show', compact('category', 'categories'));
    }

    public function edit(Request $request, Category $category): View
    {
        $categories = Category::all();
        return view('category.edit', compact('category', 'categories'));
    }
    public function update(CategoryUpdateRequest $request, Category $category)
    {

        try {
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->description = $request->description;
            $category->parent_id = $request->parent_id;
            $category->product_count = $request->product_count;
            $category->collection_id = $request->collection_id;
            $category->status = $request->status;
            $category->save();

            // update image
            if ($request->hasFile('image')) {

                $relativePath = parse_url($category->image, PHP_URL_PATH);
                if (file_exists(public_path($relativePath))) {
                    unlink(public_path($relativePath)); // Deletes the file
                }

                $imageFile = $request->file('image');
                $originalName = $imageFile->getClientOriginalName();
                $filename = time() . '_' . $originalName;
                $imageFile->move('uploads/categories/', $filename);
                $category->image = url('uploads/categories/' . $filename);
                $category->save();
            }

            // update icon
            if ($request->hasFile('icon')) {

                $relativePath = parse_url($category->icon, PHP_URL_PATH);
                if (file_exists(public_path($relativePath))) {
                    unlink(public_path($relativePath)); // Deletes the file
                }

                $imageFile = $request->file('icon');
                $originalName = $imageFile->getClientOriginalName();
                $filename = time() . '_' . $originalName;
                $imageFile->move('uploads/categories/', $filename);
                $category->icon = url('uploads/categories/' . $filename);
                $category->save();
            }

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Category updated successfully',
                    'data' => new CategoryResource($category)
                ],
                200
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {

        if ($category->image) {
            $relativePath = parse_url($category->image, PHP_URL_PATH);
            if (file_exists(public_path($relativePath))) {
                unlink(public_path($relativePath)); // Deletes the file
            }
        }

        if ($category->icon) {
            $relativePath = parse_url($category->icon, PHP_URL_PATH);
            if (file_exists(public_path($relativePath))) {
                unlink(public_path($relativePath)); // Deletes the file
            }
        }
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully');
    }
}
