<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Employee;
use App\TypeEmployee;
use App\Specialty;
use App\Institution;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $institucions = [
            [
                "name" => 'MSP',
                "code" => '111',
            ],
            [
                "name" => 'IESS Campesino',
                "code" => '222',
            ],
            [
                "name" => 'IESS',
                "code" => '333',
            ],
            [
                "name" => 'Fuerzas Armadas',
                "code" => '444',
            ],
            [
                "name" => 'Policía Nacional',
                "code" => '555',
            ],
            [
                "name" => 'Red Privada',
                "code" => '666',
            ],
        ];

        foreach ($institucions as $key => $value) {
            Institution::create($value);
        }

        $typeEmployees = [
            [
                "name" => "Médico",
                "description" => "description test",
            ],
             [
                "name" => "Enfermera",
                "description" => "description test",
            ],
        ];

        foreach ( $typeEmployees as  $typeEmployee) {
            TypeEmployee::create($typeEmployee);
        }

        $especialties = [
             [
                "name" => "Pediatra",
                "description" => "description test",
            ],
             [
                "name" => "Fisiatra",
                "description" => "description test",
            ],
        ];

        foreach ( $especialties as  $especialty) {
            Specialty::create($especialty);
        }

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
