<?php

// app/Http/Controllers/VendorController.php
namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();
        return view('vendrs.index', compact('vendors'));
    }

    public function create()
    {
        return view('vendrs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|string|email',
        ]);

        Vendor::create($request->all());
        return redirect()->route('vendrs.index')->with('success', 'Vendor created successfully.');
    }

    public function show($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('vendrs.show', compact('vendor'));
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('vendrs.edit', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        // Update vendor logic here...
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();
        return redirect()->route('vendrs.index')->with('success', 'Vendor deleted successfully.');
    }
}

