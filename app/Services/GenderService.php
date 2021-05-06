<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Gender;

class GenderService {

    function __construct()
    {

    }

    public function index () {
        try {
            
            $model = Gender::All();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
