<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;
use App\Containers\UsersSection\Students\Data\Seeders\StudentSeeder;
use App\Containers\SchoolsSection\Subjects\Data\Seeders\SubjectSeeder;
use App\Containers\UsersSection\Admin\Data\Seeders\AdminSeeder;
use App\Containers\SchoolsSection\Department\Data\Seeders\DepartmentSeeder;
use App\Containers\SchoolsSection\Class\Data\Seeders\ClassSeeder;
use App\Containers\SchoolsSection\Term\Data\Seeders\TermSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
//            AdminSeeder::class,
            TermSeeder::class

//            ClassSeeder::class,
//            DepartmentSeeder::class,

//            SubjectSeeder::class,
//            StudentSeeder::class,
        ]);

    }
}
