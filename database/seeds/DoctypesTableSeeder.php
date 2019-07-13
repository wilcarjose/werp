<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DoctypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('basedocs')->insert([
            [
                'id'          => 1,
				'name'        => 'Inventory',
				'type'        => 'inv',
				'description' => 'Inventory',
				'status'      => 'active',
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 2,
                'name'        => 'Price List',
                'type'        => 'pri',
                'description' => 'Price List',
                'status'      => 'active',
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);

        DB::table('doctypes')->insert([
            [
                'name'        => 'Inventario',
                'basedoc_id'  => 1,
                'prefix'      => 'INV',
                'increment_number' => 1,
                'last_number' => 0,
                'use_zeros' => 'y',
                'number_long' => 5,
                'status'      => 'active',
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Lista de precio',
                'basedoc_id'  => 2,
                'prefix'      => 'LP',
                'increment_number' => 1,
                'last_number' => 0,
                'use_zeros' => 'y',
                'number_long' => 6,
                'status'      => 'active',
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
