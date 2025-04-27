<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'name' => 'Basic Plan',
                'description' => 'Paket dasar untuk restoran kecil',
                'price' => 99000,
                'duration_days' => 30,
                'is_active' => true,
                'features' => [
                    'qr_code_generator',
                    'basic_menu_management',
                    'order_tracking'
                ]
            ],
            [
                'name' => 'Pro Plan',
                'description' => 'Paket lengkap untuk restoran menengah',
                'price' => 249000,
                'duration_days' => 30,
                'is_active' => true,
                'features' => [
                    'qr_code_generator',
                    'advanced_menu_management',
                    'order_tracking',
                    'analytics',
                    'multiple_outlet_support'
                ]
            ],
            [
                'name' => 'Enterprise Plan',
                'description' => 'Paket komprehensif untuk restoran besar',
                'price' => 499000,
                'duration_days' => 30,
                'is_active' => true,
                'features' => [
                    'qr_code_generator',
                    'advanced_menu_management',
                    'order_tracking',
                    'advanced_analytics',
                    'multiple_outlet_support',
                    'custom_branding',
                    'priority_support'
                ]
            ]
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(
                ['name' => $plan['name']],
                $plan
            );
        }
    }
}