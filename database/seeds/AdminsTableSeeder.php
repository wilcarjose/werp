<?php

use Werp\Admin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
			'name'       => 'admin',
			'email'      => 'admin@mail.com',
			'password'   => bcrypt('123456'),
			'status'     => 'active',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
