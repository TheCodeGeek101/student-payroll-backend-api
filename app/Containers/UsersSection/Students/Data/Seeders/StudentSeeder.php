<?php

namespace App\Containers\UsersSection\Students\Data\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert([
            [
                  "first_name" => "Sarah",
                  "last_name"=> "Williams",
                  "date_of_birth"=> "2010-11-10",
                  "address"=> "321 Birch St, Anytown, Anystate",
                  "postal_address"=> "PO Box 789, Anytown, Anystate, 34567",
                  "gender"=> "F",
                  "guardian_name"=> "Daniel Williams",
                  "guardian_contact"=> "456-789-0123",
                  "email"=> "sarah.williams@example.com",
                  "phone_number"=> "654-321-0987",
                  "admission_date"=> "2023-01-15",
                  "previous_school"=> "Hillside Elementary",
                  "emergency_contact"=> "09991239876",
                  "medical_info"=> "Gluten intolerance",
                  "remarks"=> "Excellent in arts",
                  "created_at"=> now(),
                  "updated_at" => now()
            ],
            [
                "first_name" => "John",
                "last_name" => "Doe",
                "date_of_birth" => "2009-12-15",
                "address" => "789 Maple St, Anytown, Anystate",
                "postal_address" => "PO Box 456, Anytown, Anystate, 54321",
                "gender" => "M",
                "guardian_name" => "Jane Doe",
                "guardian_contact" => "123-456-7891",
                "email" => "john.doe@example.com",
                "phone_number" => "987-654-3211",
                "admission_date" => "2022-08-20",
                "previous_school" => "New Town Elementary",
                "emergency_contact" => "0987654321",
                "medical_info" => "Asthma",
                "remarks" => "Good at sports",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "first_name" => "Michael",
                "last_name" => "Brown",
                "date_of_birth" => "2012-06-15",
                "address" => "456 Oak St, Anytown, Anystate",
                "postal_address" => "PO Box 654, Anytown, Anystate, 67890",
                "gender" => "M",
                "guardian_name" => "Susan Brown",
                "guardian_contact" => "345-678-9012",
                "email" => "michael.brown@example.com",
                "phone_number" => "765-432-1098",
                "admission_date" => "2021-09-01",
                "previous_school" => "Sunnydale Elementary",
                "emergency_contact" => "09997654321",
                "medical_info" => "None",
                "remarks" => "Active in extracurricular activities",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "first_name" => "Emily",
                "last_name" => "Johnson",
                "date_of_birth" => "2011-03-30",
                "address" => "123 Pine St, Anytown, Anystate",
                "postal_address" => "PO Box 321, Anytown, Anystate, 98765",
                "gender" => "F",
                "guardian_name" => "Robert Johnson",
                "guardian_contact" => "234-567-8901",
                "email" => "emily.johnson@example.com",
                "phone_number" => "876-543-2109",
                "admission_date" => "2023-09-01",
                "previous_school" => "Greenfield Elementary",
                "emergency_contact" => "09991234567",
                "medical_info" => "None",
                "remarks" => "Excellent in mathematics",
                "created_at" => now(),
                "updated_at" => now()
            ]




        ]);
    }
}
