<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole('Admin');
        Employee::create([
            "name" => "Fan",
            "document" => "22222",
            "phone" => "222222",
            "address" => "ddd",
            "type_document_id" =>  1,
            "gender_id" =>  1,
            "canton_id" =>  1,
            "province_id" =>  1,
            "specialty_id" =>  1,
            "type_employee_id"  => 1,
            "user_id" => 1
        ]);
        
    }
}
