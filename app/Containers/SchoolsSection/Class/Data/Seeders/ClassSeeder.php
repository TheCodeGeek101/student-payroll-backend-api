<?php

namespace App\Containers\SchoolsSection\Class\Data\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the classes
        $classes = [
            ['name' => 'Form 1'],
            ['name' => 'Form 2'],
            ['name' => 'Form 3'],
            ['name' => 'Form 4'],
            ['name' => 'Form 5'],
        ];

        // Insert the classes into the database
        DB::table('classroom')->insert($classes);
    }
}
