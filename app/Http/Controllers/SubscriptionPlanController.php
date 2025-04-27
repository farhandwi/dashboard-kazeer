<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubscriptionPlanController extends Controller
{
    public function index(Request $request)
    {
        $plans = SubscriptionPlan::query()
            ->when($request->input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('SubscriptionPlans/Index', [
            'plans' => $plans,
            'filters' => $request->only(['search']),
            'auth' => [
                'user' => $request->user()
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('SubscriptionPlans/Create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:subscription_plans',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'features' => 'nullable|array'
        ]);

        $plan = SubscriptionPlan::create($validatedData);

        return redirect()->route('subscription-plans.index')
            ->with('success', 'Subscription Plan created successfully.');
    }

    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return Inertia::render('SubscriptionPlans/Edit', [
            'plan' => $subscriptionPlan
        ]);
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:subscription_plans,name,'.$subscriptionPlan->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'features' => 'nullable|array'
        ]);

        $subscriptionPlan->update($validatedData);

        return redirect()->route('subscription-plans.index')
            ->with('success', 'Subscription Plan updated successfully.');
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();

        return redirect()->route('subscription-plans.index')
            ->with('success', 'Subscription Plan deleted successfully.');
    }
}