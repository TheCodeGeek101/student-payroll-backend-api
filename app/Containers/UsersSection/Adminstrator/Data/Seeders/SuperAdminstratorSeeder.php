<?php


namespace App\Containers\UsersSection\Adminstrator\Data\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperAdministratorsSeeder extends Seeder
{
    /**
     * Seed the super_administrators table.
     *
     * @return void
     */

    public function run()
    {
        // Insert a single record
        DB::table('super_adminstrators')->insert([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
            'gender' => 'male',
            'birthdate' => '1985-06-15',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert multiple records
        DB::table('super_adminstrators')->insert([
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '0987654321',
                'gender' => 'female',
                'birthdate' => '1990-12-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
                'phone' => '1122334455',
                'gender' => 'female',
                'birthdate' => '1988-03-22',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bob Brown',
                'email' => 'bob.brown@example.com',
                'phone' => '5566778899',
                'gender' => 'male',
                'birthdate' => '1975-08-30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
