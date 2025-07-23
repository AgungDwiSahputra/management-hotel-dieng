<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Participant;
use App\Models\Position;
use App\Models\User;
use App\Services\CompanyService;
use App\Services\ParticipantService;
use App\Services\UserParticipantService;
use App\Services\UserService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $developerUser = [
            'name' => 'Developer User',
            'email' => 'developer@app.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ];

        $adminUser = [
            'name' => 'Admin User',
            'email' => 'admin@app.com',
            'email_verified_at'=> now(),
            'password' => bcrypt('password'),
        ];

        $partnerUser = [
            'name' => 'Partner User',
            'email' => 'partner@app.com',
            'email_verified_at'=> now(),
            'password' => bcrypt('password'),
        ];

        $userService = new UserService(new User());
        if(!$userService->getAdmins()->count()){
            $userService->createAdmin($adminUser);
        }
        if(!$userService->getDevelopers()->count()){
            $userService->createDeveloper($developerUser);
        }
        if(!$userService->getPartners()->count()){
            $userService->createPartner($partnerUser);
        }
    }
}
