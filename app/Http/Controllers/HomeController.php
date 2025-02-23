<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Home;
use App\Models\homeList;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $home = Home::first();
        $categories = Category::all();
        return view('home.index', compact('home', 'categories'));
    }

    //homePage
    public function homePage()
    {
        $home = Home::get();
        return response()->json([
            'success' => true,
            'message' => 'List retrieved successfully',
            'data' => $home->load(['items' => function ($query) {
                $query->where('status', true);
            }, 'items.category']),
        ], 200);
    }


    //homelist
    public function homelist()
    {
        $list = homeList::with('category')->get();
        return response()->json([
            'success' => true,
            'message' => 'List retrieved successfully',
            'data' => $list->load('home', 'category'),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //check if home already exists
            $home = Home::first();
            if (!$home) {
                $home = new Home;
            }

            $home->title = $request->title;
            $home->description = $request->description;
            $home->save();

            if ($request->hasFile('image')) {

                if ($home->image) {
                    $relativePath = parse_url($home->image, PHP_URL_PATH);
                    if (file_exists(public_path($relativePath))) {
                        unlink(public_path($relativePath)); // Deletes the file
                    }
                }

                $imageFile = $request->file('image');
                $originalName = $imageFile->getClientOriginalName();
                $filename = time() . '_' . $originalName;
                $imageFile->move('uploads/home/', $filename);
                $home->image = url('uploads/home/' . $filename);
                $home->save();
            }

            if ($request->hasFile('icon')) {

                if ($home->icon) {
                    $relativePath = parse_url($home->icon, PHP_URL_PATH);
                    if (file_exists(public_path($relativePath))) {
                        unlink(public_path($relativePath)); // Deletes the file
                    }
                }
                $imageFile = $request->file('icon');
                $originalName = $imageFile->getClientOriginalName();
                $filename = time() . '_' . $originalName;
                $imageFile->move('uploads/home/', $filename);
                $home->icon = url('uploads/home/' . $filename);
                $home->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Home created successfully',
                'data' => $home,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }


    //list store
    public function listStore(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required',
            'icon' => 'image',
            'status' => 'required',
            'category_id' => 'required',
        ]);

        try {
            //check if home already exists
            $home = Home::first();
            if (!$home) {
                $home = Home::create([
                    'title' => 'home',
                    'description' => 'description',
                ]);
            }

            $item = $home->items()->create([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'status' => $request->status,
            ]);

            if ($request->hasFile('icon')) {
                $imageFile = $request->file('icon');
                $originalName = $imageFile->getClientOriginalName();
                $filename = time() . '_' . $originalName;
                $imageFile->move('uploads/home/', $filename);
                $item->icon = url('uploads/home/' . $filename);
                $item->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'List created successfully',
                'data' => $home,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    //list update
    public function listUpdate(Request $request)
    {
        $list = homeList::find($request->id);
        $list->title = $request->title;
        $list->category_id = $request->category_id;
        $list->status = $request->status;
        $list->save();

        if ($request->hasFile('icon')) {

            if ($list->icon) {
                $relativePath = parse_url($list->icon, PHP_URL_PATH);
                if (file_exists(public_path($relativePath))) {
                    unlink(public_path($relativePath)); // Deletes the file
                }
            }

            $imageFile = $request->file('icon');
            $originalName = $imageFile->getClientOriginalName();
            $filename = time() . '_' . $originalName;
            $imageFile->move('uploads/home/', $filename);
            $list->icon = url('uploads/home/' . $filename);
            $list->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'List updated successfully',
            'data' => $list,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Home $home) {}


    //list delete
    public function listDelete(Request $request)
    {
        $list = homeList::find($request->id);
        if ($list->icon) {
            $relativePath = parse_url($list->icon, PHP_URL_PATH);
            if (file_exists(public_path($relativePath))) {
                unlink(public_path($relativePath)); // Deletes the file
            }
        }
        $list->delete();
        return response()->json([
            'success' => true,
            'message' => 'List deleted successfully',
        ]);
    }
}
