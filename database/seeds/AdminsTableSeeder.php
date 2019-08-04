<?php

use Werp\Admin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Werp\Modules\Core\Base\Models\BaseModel;
use Werp\Modules\Core\Maintenance\Models\Company;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([
			'name'       => 'admin',
			'email'      => 'admin@mail.com',
			'password'   => bcrypt('123456'),
			'active'     => BaseModel::STATUS_ACTIVE,
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $admin->companies()->attach(Company::first()->id);
    }
}
