<?php

use App\Models\User;
use App\Models\UserRole;
use App\Repositories\UserRepository;
use App\Repositories\UserRoleRepository;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = (new UserRoleRepository())->getByName(UserRole::ROLE_ADMIN)->id;
        (new UserRepository())->create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('111111'),
            'role_id' => $adminRole
        ]);
    }
}
