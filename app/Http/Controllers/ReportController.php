<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReportService;
use App\Utils\Enums\EnumResponse;
use App\Http\Resources\FileFamilyResource;
use App\Http\Resources\FileFamilyListResource;
use App\Http\Resources\MemberResource;

class ReportController extends Controller
{
    
    function __construct(ReportService $_ReportService)
    {
        $this->service = $_ReportService;
    }

    public function fileFamilyIndex (Request $request) {
        try {
            $model = $this->service->fileFamilyIndex($request);
            $data = FileFamilyListResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function memberIndex (Request $request) {
        try {
            $model = $this->service->memberIndex($request);
            $data = MemberResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

}
