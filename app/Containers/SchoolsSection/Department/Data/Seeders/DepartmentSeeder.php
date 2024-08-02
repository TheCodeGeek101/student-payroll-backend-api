<?php

namespace App\Containers\SchoolsSection\Department\Data\Seeders;

use App\Containers\SchoolsSection\Department\Data\Models\Department;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Example data for departments
        $departments = [
            [
                'name' => 'Science',
                'code' => 'SCI',
                'description' => 'The Science Department encompasses subjects such as Physics, Chemistry, Biology, and Mathematics.',
            ],
            [
                'name' => 'Humanities',
                'code' => 'HUM',
                'description' => 'The Humanities Department covers subjects like History, Geography, and Religious Studies.',
            ],
            [
                'name' => 'Languages',
                'code' => 'LANG',
                'description' => 'The Languages Department includes courses in English, French, and other languages.',
            ],
            [
                'name' => 'Arts',
                'code' => 'ART',
                'description' => 'The Arts Department offers courses in Fine Arts, Music, Drama, and other creative arts.',
            ],
        ];

        // Insert data into the database
        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
