<?php

use App\Repositories\UserRoleRepository;
use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new UserRoleRepository())->create([
            'name' => 'admin'
        ]);
    }
}
