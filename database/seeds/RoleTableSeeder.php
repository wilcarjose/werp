<?php

use Werp\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Werp\Modules\Core\Maintenance\Models\Company;

class RoleTableSeeder extends Seeder
{
    protected function getRoles()
    {
        return [
            [
                'name'       => 'developer',
                'label'      => 'Developer',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Admin',
                'label'      => 'Admin',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Super',
                'label'      => 'Super Admin',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
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
        $company_id = Company::first()->id;
        foreach ($this->getRoles() as $role) {
            $role['company_id'] = $company_id;
            Role::create($role);
        }
    }
}
