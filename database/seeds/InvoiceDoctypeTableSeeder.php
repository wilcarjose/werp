<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Werp\Modules\Core\Base\Models\BaseModel;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Models\Doctype;
use Werp\Modules\Core\Maintenance\Models\Company;

class InvoiceDoctypeTableSeeder extends Seeder
{
    protected $configs = [
        ['view.purchases.default_pi_doc', Config::PUR_DEFAULT_PI_DOC, null, 'pur', 'view.purchases.default_pi_doc', 'doctype'],
        ['view.sales.default_si_doc', Config::SAL_DEFAULT_SI_DOC, null, 'sal', 'view.sales.default_si_doc', 'doctype'],
    ];

    protected function getBasedocs()
    {
        return [
            [
                'name'        => 'Purchase Invoice',
                'type'        => Basedoc::PI_DOC,
                'description' => 'Purchase Invoice',
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Sale Invoice',
                'type'        => Basedoc::SI_DOC,
                'description' => 'Sale Invoice',
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ];
    }

    protected function getDoctypes()
    {
        return [
            [
                'name'        => 'Factura de Compra',
                'basedoc_id'  => Basedoc::where('type', Basedoc::PI_DOC)->first()->id,
                'prefix'      => 'FC',
                'increment_number' => 1,
                'last_number' => 0,
                'use_zeros' => 'y',
                'number_long' => 5,
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Factura de Venta',
                'basedoc_id'  => Basedoc::where('type', Basedoc::SI_DOC)->first()->id,
                'prefix'      => '',
                'increment_number' => 1,
                'last_number' => 0,
                'use_zeros' => 'y',
                'number_long' => 6,
                'active'      => BaseModel::STATUS_ACTIVE,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
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

        foreach ($this->configs as $config) {
            Config::create(
                [
                    'name'          => $config[0],
                    'key'           => $config[1],
                    'value'         => $config[2],
                    'module'        => $config[3],
                    'translate_key' => $config[4],
                    'type'          => $config[5],
                    'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                    'company_id'    => $company->id,
                ]
            );
        }
    }
}
