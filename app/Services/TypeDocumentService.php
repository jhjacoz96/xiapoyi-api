<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\TypeDocument;

class TypeDocumentService {

    function __construct()
    {

    }

    public function index () {
        try {
            
            $model = TypeDocument::All();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
