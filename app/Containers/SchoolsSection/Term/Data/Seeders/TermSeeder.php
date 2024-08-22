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
                'name' => 'First Term',
                'start_date' => Carbon::create(date('Y'), 1, 1),
                'end_date' => Carbon::create(date('Y'), 3, 31),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Second Term',
                'start_date' => Carbon::create(date('Y'), 4, 1),
                'end_date' => Carbon::create(date('Y'), 6, 30),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Third Term',
                'start_date' => Carbon::create(date('Y'), 9, 1),
                'end_date' => Carbon::create(date('Y'), 12, 31),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('terms')->insert($terms);
    }
}
