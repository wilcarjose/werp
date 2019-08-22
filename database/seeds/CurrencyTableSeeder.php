<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Werp\Modules\Core\Maintenance\Models\Currency;
use Werp\Modules\Core\Maintenance\Models\Company;

class CurrencyTableSeeder extends Seeder
{
    protected function getCurrencies()
    {
        return [
            [
                'abbr' => 'USD',
                'name' => 'Dólares',
                'numeric_code' => 840,
                'symbol' => '$'
            ],
            [
                'abbr' => 'VEF',
                'name' => 'Bolívares',
                'numeric_code' => 937,
                'symbol' => 'Bs'
            ],
            [
                'abbr' => 'COP',
                'name' => 'Pesos Colombianos',
                'numeric_code' => 170,
                'symbol' => '$'
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
        $company_id = Company::first()->id;
        foreach ($this->getCurrencies() as $currency) {
            $currency['company_id'] = $company_id;
            Currency::create($currency);
        }
    }
}
