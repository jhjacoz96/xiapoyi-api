<?php

use Illuminate\Database\Seeder;
use App\ActivityEvolution;

class ActivityEvolutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $activities = [
        	[
        		"compromiso_familiar" => "Estar atentos de nuevas joranas de vacunación que ofrescan en el centro de salud",
        		"compromiso_equipo" => "Comunicar a la comunidad acerca de las nuevas jornadas",
        	],
        	[
        		"compromiso_familiar" => "Modificar paulatinamente los malos habitos alimenticios por unos habitos saludables",
        		"compromiso_equipo" => "Guiar a la familia en el cambio de habitos alimenticios, enseñandoles una dieta mas saludable",
        	],
        	[
        		"compromiso_familiar" => "Poner en practica los cuidados y hábitos que el equipo médico proporcionó a la familia, así como también acudir al centro de salud con frecuencia para tener un control de sus patologías",
        		"compromiso_equipo" => "Inculcar habitos de prevención y cuidado para las patologías que presente cada miembro de la familia",
        	],
        	[
        		"compromiso_familiar" => "Poner en practica las prevenciones y medidas estrictas que se deben tomar para un mejor cuidado de la salud",
        		"compromiso_equipo" => "Proporcionar ayuda a las embarazas ofreciendoles un cuidados y visitas domiciliarias frecuentemente para su monitoreo",
        	],
        	[
        		"compromiso_familiar" => "Poner en practica los medidas de seguridad y prevención para afrontar las discapacionades que presenten",
        		"compromiso_equipo" => "Proporionar habitos preventivos acerca del cuidado que deben tener los pacientes con tales discapaciadades",
        	],
        	[
        		"compromiso_familiar" => "Acudir al centro para ofrecele a los pacientes las ayudas necesarias de reahabilitación de promoción de la salud que ameriten",
        		"compromiso_equipo" => "Ofrecer información acerca de los sarvicios de rehabilitación que ofrece el centro de salud",
        	],
        	[
        		"compromiso_familiar" => "Incrementar el consumo de agua",
        		"compromiso_equipo" => "Inculcar hábitos saludables a la familia para evitar enfermedades futuras",
        	],
        	[
        		"compromiso_familiar" => "Acudir a las autoridades municipales para salicitar humanitarias",
        		"compromiso_equipo" => "Proporcionar información acerca de los programas ecónomicos ofrecidos por las autoridades",
        	],
        	[
        		"compromiso_familiar" => "Realizar limpieza de la vivienda con mayor frecuencia y hacer uso de aseo urbano",
        		"compromiso_equipo" => "Proporcionar información acerca de las enfermedades que pueden ocacionar la acumulación de desechos y desperdicios",
        	],
        	[
        		"compromiso_familiar" => "Eliminar los desechos liquidos que se puedan visualizar dentro de la vivienda",
        		"compromiso_equipo" => "Proporcionar información acerca de las enfermedades que pueden generar los desechos liquedos",
        	],
        	[
        		"compromiso_familiar" => "Solicitar a la cumunidad reuniones para afrontar la contaminación que genera las industrias aledañas",
        		"compromiso_equipo" => "Informar a la familia acerca de las enfermedades que pueden generar los distindos desechos que generan las industrias",
        	],
        	[
        		
        		"compromiso_familiar" => "No permanecer con animales dentro del hogar",
        		"compromiso_equipo" => "Informar a la familia acerca de las enfermedades que pueden generar los animales dentro del hogar",
        	],
        	[
        		
        		"compromiso_familiar" => "Solicitar al gobierno local la iclusión de la familia en programas de ayuda económicas",
        		"compromiso_equipo" => "Infomar a la familia acerca de los programas económicos que ofrece el gobierno",
        	],
        	[
        		
        		"compromiso_familiar" => "Ayudar al jefe de familia a generar ingresos que permitar sustentar el hogar",
        		"compromiso_equipo" => "Infomar a la familia acerca de como se puede ayudar al jefe de familia en cuanto al sustento del hogar",
        	],
        	[
        		"compromiso_familiar" => "Ingresar a escuelas rurales que le permiten culminar sus estudios",
        		"compromiso_equipo" => "Infomar a la familia acerca de las distintas escuelas que puden encontrar al rededor de la zona",
        	],
        	[
        		"compromiso_familiar" => "Afrontar los problemas que pueden generar la desestructuracción familiar",
        		"compromiso_equipo" => "Ofrecer ayuda a los miembros del grupo familiar para afrontar desestructuracción familiar",
        	],
        	[
        		"compromiso_familiar" => "Acudir a rehabilitaciones ofrecidas en el centro de salud por los profecionales",
        		"compromiso_equipo" => "Infomar a la familia acerca de las distintas problemas acerca de las conecuencias que pueden generar el alcoholismo y la violencia familiar, así como también, informar acerca de los distintos programas de rehabilitación que ofrecen en el centro de salud",
        	],
        	[
        		"compromiso_familiar" => "Prevenir el hacinamiento",
        		"compromiso_equipo" => "Infomar a acerca de las concecuencias que traen consigo el hacinamiento",
        	]
        ];

        foreach ($activities as $value) {
        	ActivityEvolution::create($value);
        }
    }
}
