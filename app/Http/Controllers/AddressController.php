<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $adresses = auth()->user()->addresses;
        return response()->json($adresses);
    }

    public function show($id)
    {
        $address = auth()->user()->addresses()->find($id);
        return response()->json($address);
    }

    public function store(Request $request)
    {
        $request->validate([
            'county' => 'required',
            'state' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'phone' => 'required',
            'street' => 'required',
            'floor' => 'required',
            'block' => 'required',
            'building' => 'required',
            'apartment' => 'required',
        ]);

        try {
            $address = auth()->user()->addresses()->create([
                'county' => $request->county,
                'state' => $request->state,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'building' => $request->building,
                'apartment' => $request->apartment,
                'floor' => $request->floor ?? null,
                'street' => $request->street ?? null,
                'block' => $request->block ?? null,
                'way' => $request->way ?? null,
                'phone' => $request->phone ?? null,
                'is_house' => $request->is_house ?? null,
                'is_apartment' => $request->is_apartment ?? null,
            ]);
            return response()->json($address);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $address = auth()->user()->addresses()->find($id);
        $address->update($request->all());
        return response()->json($address);
    }

    public function destroy($id)
    {
        $address = auth()->user()->addresses()->find($id);
        $address->delete();
        return response()->json(['message' => 'Address deleted successfully']);
    }
}
