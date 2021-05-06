<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Province;
use Illuminate\Support\Str;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = [
            ["name" => "Azuay", "code" => Str::random(4)],
            ["name" => "Bolívar", "code" => Str::random(4)],
            ["name" => "Cañar", "code" => Str::random(4)],
            ["name" => "Carchi", "code" => Str::random(4)],
            ["name" => "Chimborazo", "code" => Str::random(4)],
            ["name" => "Cotopaxi", "code" => Str::random(4)],
            ["name" => "El Oro", "code" => Str::random(4)],
            ["name" => "Esmeraldas", "code" => Str::random(4)],
            ["name" => "Galápagos", "code" => Str::random(4)],
            ["name" => "Guayas", "code" => Str::random(4)],
            ["name" => "Imbabura", "code" => Str::random(4)],
            ["name" => "Loja", "code" => Str::random(4)],
            ["name" => "Los Ríos", "code" => Str::random(4)],
            ["name" => "Manabí", "code" => Str::random(4)],
            ["name" => "Morona Santiago", "code" => Str::random(4)],
            ["name" => "Napo", "code" => Str::random(4)],
            ["name" => "Orellana", "code" => Str::random(4)],
            ["name" => "Pastaza", "code" => Str::random(4)],
            ["name" => "Pichincha", "code" => Str::random(4)],
            ["name" => "Santa Elena", "code" => Str::random(4)],
            ["name" => "Santo Domingo de los Tsáchilas", "code" => Str::random(4)],
            ["name" => "Sucumbíos", "code" => Str::random(4)],
            ["name" => "Tungurahua", "code" => Str::random(4)],
            ["name" => "Zamora Chinchipe", "code" => Str::random(4)],
        ];

        foreach($provinces as $province) {
            Province::create($province);
        };

    }
}
