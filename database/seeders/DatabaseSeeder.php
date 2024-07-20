<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use App\Containers\UsersSection\Students\Data\Seeders\StudentSeeder;
use App\Containers\SchoolsSection\Subjects\Data\Seeders\SubjectSeeder;
use App\Containers\UsersSection\Adminstrator\Data\Seeders\AdministratorSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
//            AdministratorSeeder::class,
//            StudentSeeder::class,
            SubjectSeeder::class,
        ]);

    }
}
