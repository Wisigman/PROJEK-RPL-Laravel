<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\User;

class PurchaseSeeder extends Seeder
{
    public function run()
    {
        $user = User::find(1); // Misalnya, pengguna dengan ID 1

        $user->purchases()->create([
            'product_name' => 'Test Product',
            'price' => 100000,
            'total_amount' => 100000,
            'status' => 'completed',
        ]);
    }
}

