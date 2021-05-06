<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // foreach (Resource::supported() as $permission) {
        //     Permission::create($permission);
        // }
        $permissions = [
            ['name' => 'home_access', 'description' => 'Inicio'],
            ['name' => 'initial_information_access', 'description' => 'Información inicial'],
            ['name' => 'master_access', 'description' => 'Maestros'],
            ['name' => 'configuration_master_access', 'description' => 'Configuración de maestros'],
            ['name' => 'configuration_web_site_access', 'description' => 'Configuración de sitio web'],
            ['name' => 'configuration_mobile_access', 'description' => 'Configuración de movil'],
            ['name' => 'file_familiy_access', 'description' => 'Ficha familiar'],
            ['name' => 'file_clinical_access', 'description' => 'Ficha clinica'],
            ['name' => 'neonatology_access', 'description' => 'Neonatología'],
            ['name' => 'obstetrics_access', 'description' => 'Obstetricia'],
            ['name' => 'diabetes_control_access', 'description' => 'Control de diabéticos'],
            ['name' => 'patient_care_access', 'description' => 'Atención al paciente'],
            ['name' => 'evaluate_suggestion_access', 'description' => 'Evaluar sugerencias'],
            ['name' => 'report_access', 'description' => 'Reportes'],
            ['name' => 'system_administration_access', 'description' => 'Administración del sistema'],
        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
