<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CompanyTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(RolePermissionTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(AdminRoleTableSeeder::class);
        $this->call(DoctypesTableSeeder::class);
        $this->call(UomTableSeeder::class);
        $this->call(ConfigTableSeeder::class);
        $this->call(CurrencyTableSeeder::class);
        $this->call(InvoiceDoctypeTableSeeder::class);
    }
}
