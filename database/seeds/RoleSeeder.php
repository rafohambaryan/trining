<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['user', 'admin'];
        foreach ($roles as $index => $role) {
            Role::create([
                'status' => $role
            ]);
        }
    }
}
