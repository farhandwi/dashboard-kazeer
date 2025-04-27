<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\MerchantOutlet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MerchantOutletController extends Controller
{
    public function index(Merchant $merchant)
    {
        $outlets = $merchant->outlets()->paginate(10);

        return Inertia::render('Merchants/Outlets/Index', [
            'merchant' => $merchant,
            'outlets' => $outlets
        ]);
    }

    public function create(Merchant $merchant)
    {
        return Inertia::render('Merchants/Outlets/Create', [
            'merchant' => $merchant
        ]);
    }

    public function store(Request $request, Merchant $merchant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'in:active,inactive'
        ]);

        $outlet = $merchant->outlets()->create([
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'phone_number' => $request->phone_number,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => $request->status ?? 'active'
        ]);

        return redirect()->route('merchants.outlets.index', $merchant)
            ->with('success', 'Outlet created successfully.');
    }

    public function edit(Merchant $merchant, MerchantOutlet $outlet)
    {
        return Inertia::render('Merchants/Outlets/Edit', [
            'merchant' => $merchant,
            'outlet' => $outlet
        ]);
    }

    public function update(Request $request, Merchant $merchant, MerchantOutlet $outlet)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'in:active,inactive'
        ]);

        $outlet->update($request->only([
            'name', 'address', 'city', 'province', 
            'postal_code', 'phone_number', 
            'latitude', 'longitude', 'status'
        ]));

        return redirect()->route('merchants.outlets.index', $merchant)
            ->with('success', 'Outlet updated successfully.');
    }

    public function destroy(Merchant $merchant, MerchantOutlet $outlet)
    {
        $outlet->delete();

        return redirect()->route('merchants.outlets.index', $merchant)
            ->with('success', 'Outlet deleted successfully.');
    }
}