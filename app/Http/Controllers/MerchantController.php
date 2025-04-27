<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\MerchantOutlet;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class MerchantController extends Controller
{
    public function index(Request $request)
    {
        $merchants = Merchant::query()
            ->when($request->input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('business_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->withCount('outlets')
            ->paginate(10)
            ->withQueryString();
        $temp = [
            'user' => $request->user()
        ];
        Log::info($merchants);
        Log::info($request->only(['search']));
        Log::info($request->user());
        Log::info($temp['user']);
    
        return Inertia::render('Merchants/Index', [
            'merchants' => $merchants,
            'filters' => $request->only(['search']),
            'auth' => [
                'user' => $request->user()
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Merchants/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:merchants',
            'phone_number' => 'required|string|unique:merchants',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'social_media' => 'nullable|array'
        ]);

        $merchant = Merchant::create([
            'name' => $request->name,
            'business_name' => $request->business_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'description' => $request->description,
            'website' => $request->website,
            'social_media' => $request->social_media,
            'status' => 'active'
        ]);

        return redirect()->route('merchants.index')->with('success', 'Merchant created successfully.');
    }

    public function edit(Merchant $merchant)
    {
        return Inertia::render('Merchants/Edit', [
            'merchant' => $merchant,
            'outlets' => $merchant->outlets
        ]);
    }

    public function update(Request $request, Merchant $merchant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:merchants,email,'.$merchant->id,
            'phone_number' => 'required|string|unique:merchants,phone_number,'.$merchant->id,
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'social_media' => 'nullable|array'
        ]);

        $merchant->update($request->only([
            'name', 'business_name', 'email', 'phone_number', 
            'address', 'city', 'province', 'postal_code', 
            'description', 'website', 'social_media'
        ]));

        return redirect()->route('merchants.index')->with('success', 'Merchant updated successfully.');
    }

    public function destroy(Merchant $merchant)
    {
        $merchant->delete();
        return redirect()->route('merchants.index')->with('success', 'Merchant deleted successfully.');
    }
}