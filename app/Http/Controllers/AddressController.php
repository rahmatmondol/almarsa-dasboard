<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $adresses = auth()->user()->addresses;
        return response()->json(['success' => true, 'addresses' => $adresses]);
    }

    public function show($id)
    {
        $address = auth()->user()->addresses()->find($id);
        return response()->json(['success' => true, 'address' => $address]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'street' => 'required',
            'block' => 'required',
            'phone' => 'required',
        ]); 

        try {
            if ($request->is_default) {
                $addresses = auth()->user()->addresses;
                foreach ($addresses as $address) {
                    $address->update(['is_default' => false]);
                }
            }

            $address = auth()->user()->addresses()->create([
                'address' => $request->address ?? null,
                'building_name' => $request->building_name ?? null,
                'apartment_number' => $request->apartment_number ?? null,
                'house_number' => $request->house_number ?? null,
                'floor' => $request->floor ?? null,
                'street' => $request->street ?? null,
                'block' => $request->block ?? null,
                'way' => $request->way ?? null,
                'phone' => $request->phone ?? null,
                'is_house' => $request->is_house ?? null,
                'is_apartment' => $request->is_apartment ?? null,
                'is_default' => $request->is_default ?? null,
            ]);



            return response()->json(['success' => true, 'message' => 'Address created successfully', 'address' => $address]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $address = auth()->user()->addresses()->find($id);

        if (!$address) {
            return response()->json(['error' => 'Address not found'], 404);
        }

        try {
            if ($request->is_default) {
                $addresses = auth()->user()->addresses;
                foreach ($addresses as $addr) {
                    $addr->update(['is_default' => false]);
                }
            }

            $address->update([
                'address' => $request->address ?? null,
                'building_name' => $request->building_name ?? null,
                'apartment_number' => $request->apartment_number ?? null,
                'house_number' => $request->house_number ?? null,
                'floor' => $request->floor ?? null,
                'street' => $request->street ?? null,
                'block' => $request->block ?? null,
                'way' => $request->way ?? null,
                'phone' => $request->phone ?? null,
                'is_house' => $request->is_house ?? null,
                'is_apartment' => $request->is_apartment ?? null,
                'is_default' => $request->is_default ?? null,
            ]);

            return response()->json(['success' => true, 'message' => 'Address updated successfully', 'address' => $address]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $address = auth()->user()->addresses()->find($id);
        $address->delete();
        return response()->json(['success' => true, 'message' => 'Address deleted successfully']);
    }
}
