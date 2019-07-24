<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

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
				'type'        => Basedoc::IN_DOC,
				'description' => 'Inventory',
				'status'      => 'active',
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 2,
                'name'        => 'Price List',
                'type'        => Basedoc::PL_DOC,
                'description' => 'Price List',
                'status'      => 'active',
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 3,
                'name'        => 'Purchase Order',
                'type'        => Basedoc::PO_DOC,
                'description' => 'Purchase Order',
                'status'      => 'active',
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 4,
                'name'        => 'Sale Order',
                'type'        => Basedoc::SO_DOC,
                'description' => 'Sale Order',
                'status'      => 'active',
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 5,
                'name'        => 'Inventory Entry',
                'type'        => Basedoc::IE_DOC,
                'description' => 'Inventory entry',
                'status'      => 'active',
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 6,
                'name'        => 'Inventory Output',
                'type'        => Basedoc::IO_DOC,
                'description' => 'Inventory output',
                'status'      => 'active',
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 7,
                'name'        => 'Inventory Movement',
                'type'        => Basedoc::IM_DOC,
                'description' => 'Inventory movement',
                'status'      => 'active',
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);

        DB::table('doctypes')->insert([
            [
                'name'        => 'Inventario',
                'basedoc_id'  => 1,
                'prefix'      => 'IN',
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
            ],
            [
                'name'        => 'Orden de Compra',
                'basedoc_id'  => 3,
                'prefix'      => 'OC',
                'increment_number' => 1,
                'last_number' => 0,
                'use_zeros' => 'y',
                'number_long' => 6,
                'status'      => 'active',
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Orden de Venta',
                'basedoc_id'  => 4,
                'prefix'      => 'OV',
                'increment_number' => 1,
                'last_number' => 0,
                'use_zeros' => 'y',
                'number_long' => 6,
                'status'      => 'active',
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Entrada de productos',
                'basedoc_id'  => 5,
                'prefix'      => 'EP',
                'increment_number' => 1,
                'last_number' => 0,
                'use_zeros' => 'y',
                'number_long' => 6,
                'status'      => 'active',
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Salida de productos',
                'basedoc_id'  => 6,
                'prefix'      => 'SP',
                'increment_number' => 1,
                'last_number' => 0,
                'use_zeros' => 'y',
                'number_long' => 6,
                'status'      => 'active',
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Movimiento de productos',
                'basedoc_id'  => 7,
                'prefix'      => 'MP',
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
