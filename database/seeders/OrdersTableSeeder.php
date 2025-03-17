<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'product_id'  => 1, 
                'quantity'    => 2,
                'total_price' => 500.00,
                'status'      => 'completed',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'product_id'  => 1,
                'quantity'    => 1,
                'total_price' => 250.50,
                'status'      => 'pending',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'product_id'  => 1,
                'quantity'    => 3,
                'total_price' => 900.75,
                'status'      => 'cancelled',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
