<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Employee;
use App\TypeEmployee;
use App\Specialty;
use App\Zone;
use App\Institution;
use App\TypeComment;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $typeComments = [
            [
                "nombre" => "Duda",
            ],
            [
                "nombre" => "Sugerencia",
            ],
            [
                "nombre" => "Reclamo",
            ],
        ];
        foreach ($typeComments as $key => $value) {
            TypeComment::create($value);
        }

        $institucions = [
            [
                "name" => 'MSP',
                "code" => 'f42d',
            ],
            [
                "name" => 'IESS Campesino',
                "code" => 'f45f',
            ],
            [
                "name" => 'IESS',
                "code" => 'g45g',
            ],
            [
                "name" => 'Fuerzas Armadas',
                "code" => 'g45g45',
            ],
            [
                "name" => 'Policía Nacional',
                "code" => 'g454',
            ],
            [
                "name" => 'Red Privada',
                "code" => '663g3g6',
            ],
        ];

        foreach ($institucions as $value) {
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
