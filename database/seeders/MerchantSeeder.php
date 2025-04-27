<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Merchant;
use App\Models\MerchantOutlet;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class MerchantSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Buat beberapa merchant contoh
        $merchants = [
            [
                'name' => 'John Doe',
                'business_name' => 'Warung Makan Bude John',
                'email' => 'john.doe@example.com',
                'phone_number' => '081234567890',
                'password' => Hash::make('password123'),
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'description' => 'Warung makan dengan masakan tradisional',
                'social_media' => [
                    'instagram' => '@warungbudeJohn',
                    'facebook' => 'Warung Bude John'
                ]
            ],
            [
                'name' => 'Jane Smith',
                'business_name' => 'Cafe Sejahtera',
                'email' => 'jane.smith@example.com',
                'phone_number' => '087654321098',
                'password' => Hash::make('password123'),
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'description' => 'Cafe modern dengan suasana nyaman',
                'social_media' => [
                    'instagram' => '@cafesejahtera',
                    'twitter' => '@cafesejahtera'
                ]
            ]
        ];

        foreach ($merchants as $merchantData) {
            // Buat merchant
            $merchant = Merchant::updateOrCreate(
                ['email' => $merchantData['email']],
                $merchantData
            );

            // Buat outlet untuk merchant
            $this->createOutletsForMerchant($merchant, $faker);
        }
    }

    private function createOutletsForMerchant(Merchant $merchant, $faker)
    {
        // Buat 1-2 outlet untuk setiap merchant
        $outletCount = $faker->numberBetween(1, 2);

        for ($i = 0; $i < $outletCount; $i++) {
            MerchantOutlet::updateOrCreate(
                [
                    'merchant_id' => $merchant->id,
                    'name' => $merchant->business_name . ' - Outlet ' . ($i + 1)
                ],
                [
                    'address' => $faker->address,
                    'city' => $merchant->city,
                    'province' => $merchant->province,
                    'postal_code' => $faker->postcode,
                    'phone_number' => $faker->phoneNumber,
                    'latitude' => $faker->latitude,
                    'longitude' => $faker->longitude,
                    'status' => 'active'
                ]
            );
        }
    }
}