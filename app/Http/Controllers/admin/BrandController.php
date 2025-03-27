<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function create(){
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        dd($request);
        $request->validate([
            'name' => 'required|string',
            'Brand_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'Expiry_date' => 'required|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('Brand_image')) {
            $imagePath = $request->file('Brand_image')->store('brand_images', 'public');
        }

        $brand = Brand::create([
            'name' => $request->name,
            'brand_image' => $imagePath,
            'expiry_date' => $request->Expiry_date,
        ]);

        return response()->json(['message' => 'Brand created successfully', 'brand' => $brand]);
    }

    public function list(){
        return view('admin.brand.list');
    }
}
