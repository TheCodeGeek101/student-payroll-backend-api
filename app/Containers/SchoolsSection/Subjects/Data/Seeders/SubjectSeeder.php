<?php

namespace App\Containers\SchoolsSection\Subjects\Data\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([
            [
                "name" => "Biology",
                "code" => "BIO101",
                "description" => "An introductory course to Biology",
                "credits" => 3,
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "Physics",
                "code" => "PHYS101",
                "description" => "An introductory course to Physics",
                "credits" => 4,
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "Mathematics",
                "code" => "MATH101",
                "description" => "An introductory course to Mathematics",
                "credits" => 4,
                "created_at" => now(),
                "updated_at" => now(),

            ],
            [
                "name" => "English Literature",
                "code" => "ENG101",
                "description" => "An introductory course to English Literature",
                "credits" => 3,
                "created_at" => now(),
                "updated_at" => now()
            ]
        ]);
    }
}
