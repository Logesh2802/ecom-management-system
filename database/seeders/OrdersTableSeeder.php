<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;  

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
                'created_at'  => Carbon::create(2025, 3, 14, 9, 25, 8),
                'updated_at'  => Carbon::create(2025, 3, 16, 9, 25, 8),
            ],
            [
                'product_id'  => 1,
                'quantity'    => 1,
                'total_price' => 250.50,
                'status'      => 'pending',
                'created_at'  => Carbon::create(2025, 3, 16, 9, 25, 8),
                'updated_at'  => Carbon::create(2025, 3, 16, 9, 25, 8),
            ],
            [
                'product_id'  => 1,
                'quantity'    => 3,
                'total_price' => 900.75,
                'status'      => 'cancelled',
                'created_at'  => Carbon::create(2025, 3, 16, 9, 25, 8),
                'updated_at'  => Carbon::create(2025, 3, 16, 9, 25, 8),
            ],
            [
                'product_id'  => 1,
                'quantity'    => 3,
                'total_price' => 5000.00,
                'status'      => 'completed',
                'created_at'  => Carbon::create(2025, 3, 8, 4, 23, 36),
                'updated_at'  => Carbon::create(2025, 3, 17, 4, 23, 36),
            ],
            [
                'product_id'  => 1,
                'quantity'    => 3,
                'total_price' => 4000.00,
                'status'      => 'completed',
                'created_at'  => Carbon::create(2025, 3, 17, 4, 23, 53),
                'updated_at'  => Carbon::create(2025, 3, 17, 4, 23, 53),
            ],
        ]);
    }
}
