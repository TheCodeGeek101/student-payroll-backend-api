<?php


namespace App\Containers\SchoolsSection\Term\Data\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $terms = [
            [
                'name' => 'Term 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Term 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Term 3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('terms')->insert($terms);
    }
}
