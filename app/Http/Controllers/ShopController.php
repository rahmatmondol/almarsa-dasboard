<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Shop;
use App\Models\ShopItem;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $shop = Shop::first();
        $categories = Category::all();
        return view('shop.index', compact('shop', 'categories'));
    }

    //shopPage
    public function shopPage()
    {
        $shop = Shop::get();
        return response()->json([
            'success' => true,
            'message' => 'List retrieved successfully',
            'data' => $shop->load(['items' => function ($query) {
                $query->where('status', true);
            }, 'items.category']),
        ], 200);
    }


    //shoplist
    public function shoplist()
    {
        $list = ShopItem::with('category')->get();
        return response()->json([
            'success' => true,
            'message' => 'List retrieved successfully',
            'data' => $list->load('shop', 'category'),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'image',
            'icon' => 'image',
        ]);

        try {
            //check if shop already exists
            $shop = Shop::first();
            if (!$shop) {
                $shop = new Shop;
            }

            $shop->title = $request->title;
            $shop->description = $request->description;
            $shop->save();

            if ($request->hasFile('image')) {

                if ($shop->image) {
                    $relativePath = parse_url($shop->image, PHP_URL_PATH);
                    if (file_exists(public_path($relativePath))) {
                        unlink(public_path($relativePath)); // Deletes the file
                    }
                }

                $imageFile = $request->file('image');
                $originalName = $imageFile->getClientOriginalName();
                $filename = time() . '_' . $originalName;
                $imageFile->move('uploads/shop/', $filename);
                $shop->image = url('uploads/shop/' . $filename);
                $shop->save();
            }

            if ($request->hasFile('icon')) {

                if ($shop->icon) {
                    $relativePath = parse_url($shop->icon, PHP_URL_PATH);
                    if (file_exists(public_path($relativePath))) {
                        unlink(public_path($relativePath)); // Deletes the file
                    }
                }
                $imageFile = $request->file('icon');
                $originalName = $imageFile->getClientOriginalName();
                $filename = time() . '_' . $originalName;
                $imageFile->move('uploads/shop/', $filename);
                $shop->icon = url('uploads/shop/' . $filename);
                $shop->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Shop created successfully',
                'data' => $shop,
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
            //check if shop already exists
            $shop = Shop::first();
            if (!$shop) {
                $shop = Shop::create([
                    'title' => 'shop',
                    'description' => 'description',
                ]);
            }

            $item = $shop->items()->create([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'status' => $request->status,
            ]);

            if ($request->hasFile('icon')) {
                $imageFile = $request->file('icon');
                $originalName = $imageFile->getClientOriginalName();
                $filename = time() . '_' . $originalName;
                $imageFile->move('uploads/shop/', $filename);
                $item->icon = url('uploads/shop/' . $filename);
                $item->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'List created successfully',
                'data' => $shop,
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
        $list = ShopItem::find($request->id);
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
            $imageFile->move('uploads/shop/', $filename);
            $list->icon = url('uploads/shop/' . $filename);
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
    public function update(Request $request, Shop $shop) {}


    //list delete
    public function listDelete(Request $request)
    {
        $list = ShopItem::find($request->id);
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
