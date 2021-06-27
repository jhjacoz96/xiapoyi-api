<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReportService;
use App\Utils\Enums\EnumResponse;
use App\Http\Resources\FileFamilyResource;
use App\Http\Resources\FileFamilyListResource;
use App\Http\Resources\ReportFileFamilyResource;
use App\Http\Resources\MemberResource;
use App\FileFamily;
use App\Organization;
use DateTime;
use PDF;
use Carbon\Carbon;

class ReportController extends Controller
{
    
    function __construct(ReportService $_ReportService)
    {
        $this->service = $_ReportService;
    }

    public function fileFamilyIndex (Request $request) {
        try {
            $model = $this->service->fileFamilyIndex($request);
            $data = ReportFileFamilyResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function fileFamilyGenerate(Request $request) {
        try {
            $model = $this->service->fileFamilyIndex($request);
            $data = ReportFileFamilyResource::collection($model);
            $organization = Organization::find(3);
            $path = public_path() . '/pdf/' . Carbon::now()->toDateTimeString() . '_informe_ficha_familiar' . '.pdf';
            $pdf = \PDF::loadView('report.fileFamily', compact('data', 'organization'));
            $pdf->save($path);
            return response()->download($path);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function pdf() {
        try {
            $model = FileFamily::All();
            $data = ReportFileFamilyResource::collection($model);
            $organization = Organization::find(3);
            $pdf = \PDF::loadView('report.fileFamily', compact('data', 'organization'));
            return $pdf->download('informe_ficha_familiar' . '.pdf');
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
