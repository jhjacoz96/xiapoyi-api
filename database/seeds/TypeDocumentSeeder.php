<?php

use Illuminate\Database\Seeder;
use App\TypeDocument;

class TypeDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $typeDocuments = ['Ecuatoriano', 'Extranjero'];
        foreach ($typeDocuments as $typeDocument) {
            TypeDocument::create(['nombre' => $typeDocument]);
        }
    }
}
