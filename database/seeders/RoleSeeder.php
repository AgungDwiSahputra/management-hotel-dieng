<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'developer',
            'admin',
            'partner'
        ];

        foreach($roles as $role){
            Role::findOrCreate($role);
        }
    }
}
