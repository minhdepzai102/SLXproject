<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopDetail;
class ShopDetailController extends Controller
{
    public function edit()
    {
        $shopDetail = ShopDetail::first(); // Fetch the first or existing shop detail
        return view('shop_details.edit', compact('shopDetail'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'facebook' => 'nullable|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        $shopDetail = ShopDetail::first();
        if (!$shopDetail) {
            $shopDetail = new ShopDetail();
        }

        $shopDetail->fill($validatedData);
        $shopDetail->save();

        return redirect()->back()->with('success', 'Shop details updated successfully.');
    }
}
