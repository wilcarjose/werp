<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Werp\Modules\Core\Base\Models\BaseModel;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Models\Doctype;
use Werp\Modules\Base\Maintenance\Models\Company;

class DoctypesTableSeeder extends Seeder
{
    protected function getBasedocs()
    {
        return [
            [
                'name'        => 'Inventory',
                'type'        => Basedoc::IN_DOC,
                'description' => 'Inventory',
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Price List',
                'type'        => Basedoc::PL_DOC,
                'description' => 'Price List',
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Purchase Order',
                'type'        => Basedoc::PO_DOC,
                'description' => 'Purchase Order',
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Sale Order',
                'type'        => Basedoc::SO_DOC,
                'description' => 'Sale Order',
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Inventory Entry',
                'type'        => Basedoc::IE_DOC,
                'description' => 'Inventory entry',
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Inventory Output',
                'type'        => Basedoc::IO_DOC,
                'description' => 'Inventory output',
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Inventory Movement',
                'type'        => Basedoc::IM_DOC,
                'description' => 'Inventory movement',
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];
    }

    protected function getDoctypes()
    {
        return [
            [
                'name'        => 'Inventario',
                'basedoc_id'  => Basedoc::where('type', Basedoc::IN_DOC)->first()->id,
                'prefix'      => 'IN',
                'increment_number' => 1,
                'last_number' => 0,
                'use_zeros' => 'y',
                'number_long' => 5,
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Lista de precio',
                'basedoc_id'  => Basedoc::where('type', Basedoc::PL_DOC)->first()->id,
                'prefix'      => 'LP',
                'increment_number' => 1,
                'last_number' => 0,
                'use_zeros' => 'y',
                'number_long' => 5,
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Orden de Compra',
                'basedoc_id'  => Basedoc::where('type', Basedoc::PO_DOC)->first()->id,
                'prefix'      => 'OC',
                'increment_number' => 1,
                'last_number' => 0,
                'use_zeros' => 'y',
                'number_long' => 5,
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Orden de Venta',
                'basedoc_id'  => Basedoc::where('type', Basedoc::SO_DOC)->first()->id,
                'prefix'      => 'OV',
                'increment_number' => 1,
                'last_number' => 0,
                'use_zeros' => 'y',
                'number_long' => 5,
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Entrada de productos',
                'basedoc_id'  => Basedoc::where('type', Basedoc::IE_DOC)->first()->id,
                'prefix'      => 'EP',
                'increment_number' => 1,
                'last_number' => 0,
                'use_zeros' => 'y',
                'number_long' => 5,
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Salida de productos',
                'basedoc_id'  => Basedoc::where('type', Basedoc::IO_DOC)->first()->id,
                'prefix'      => 'SP',
                'increment_number' => 1,
                'last_number' => 0,
                'use_zeros' => 'y',
                'number_long' => 5,
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Movimiento de productos',
                'basedoc_id'  => Basedoc::where('type', Basedoc::IM_DOC)->first()->id,
                'prefix'      => 'MP',
                'increment_number' => 1,
                'last_number' => 0,
                'use_zeros' => 'y',
                'number_long' => 5,
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = Company::first();

        foreach ($this->getBasedocs() as $basedoc) {
            $basedoc['company_id']  = $company->id;
            Basedoc::create($basedoc);
        }

        foreach ($this->getDoctypes() as $doctype) {
            $doctype['company_id']  = $company->id;
            Doctype::create($doctype);
        }
    }
}
