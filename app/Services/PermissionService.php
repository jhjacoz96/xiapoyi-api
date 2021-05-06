<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\User;
use Carbon\Carbon;

class PermissionService {

    function __construct()
    {

    }

    public function index () {
        try {
            $model = Auth()->user()->roles()->with('permissions')->get()
                ->pluck('permissions')
                ->flatten()
                ->pluck('name')
                ->toArray();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }
    
}