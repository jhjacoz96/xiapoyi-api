<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReportService;
use App\Utils\Enums\EnumResponse;
use App\Http\Resources\FileFamilyResource;
use App\Http\Resources\FileFamilyListResource;
use App\Http\Resources\ReportFileFamilyResource;
use App\Http\Resources\MemberResource;
use App\Http\Resources\MemberShowResource;
use App\Http\Resources\MemberReportResource;
use App\FileFamily;
use App\Pregnant;
use App\Organization;
use App\Http\Resources\FileClinicalObstetricResource;
use App\Http\Resources\FileClincalNeonatologyResource;
use App\Http\Resources\FileClinicaNeonatologyShowResource;
use App\Http\Resources\DiabeticPatientReportResource;
use App\Resource;
use DateTime;
use PDF;
use Carbon\Carbon;
use App\Utils\CalAge;

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
            $criterios = $this->service->fileFamilyCriterion($request);
            $organization = Organization::find(3);
            $pdf = \PDF::loadView('report.fileFamily', compact('data', 'organization', 'criterios'));
            return $pdf->download("informe_ficha_familiar.pdf");
        } catch (Exception $e) {
            return $e;
        }
    }

    public function memberGenerate(Request $request) {
        try {
            $model = $this->service->memberIndex($request);
            $data = MemberReportResource::collection($model);
            $criterios = $this->service->memberCriterion($request);
            $organization = Organization::find(3);
            $pdf = \PDF::loadView('report.member', compact('data', 'organization', 'criterios'));
            return $pdf->download("Informe_miembros.pdf");
        } catch (Exception $e) {
            return $e;
        }
    }

    public function pdf() {
        try {
            $model = FileFamily::All();
            $data = ReportFileFamilyResource::collection($model);
            $organization = Organization::find(3);
            $path = public_path().'/pdf/'.\Str::random(4).'_informe_ficha_familiar'.'.pdf';
            $header=array(
                'Content-Type: application/pdf',
            );
            $pdf = \PDF::loadView('report.fileFamily', compact('data', 'organization'))->save($path);
            return response()->download($path, "informe_ficha_familiar.pdf", $header);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function memberIndex (Request $request) {
        try {
            $model = $this->service->memberIndex($request);
            $data = MemberReportResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function fileClinicalObstetricIndex (Request $request) {
        try {
            $model = $this->service->fileClinicalObstetricIndex($request);
            $data = FileClinicalObstetricResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function fileClinicalObstetricGenerate(Request $request) {
        try {
            $model = $this->service->fileClinicalObstetricIndex($request);
            $data = FileClinicalObstetricResource::collection($model);
            $criterios = $this->service->fileClinicalObstetricCriterion($request);
            $organization = Organization::find(3);
            $pdf = \PDF::loadView('report.fileClinicalObstetric', compact('data', 'organization', 'criterios'));
            return $pdf->download("informe_ficha_clinica_obstetrica.pdf");
        } catch (Exception $e) {
            return $e;
        }
    }

    public function fileClinicalNeonatologyIndex (Request $request) {
        try {
            $model = $this->service->fileClinicalNeonatologyIndex($request);
            $data = FileClinicaNeonatologyShowResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function fileClinicalNeonatologyGenerate(Request $request) {
        try {
            $model = $this->service->fileClinicalNeonatologyIndex($request);
            $data = FileClinicaNeonatologyShowResource::collection($model);
            $criterios = $this->service->fileClinicalNeonatologyCriterion($request);
            $organization = Organization::find(3);
            $pdf = \PDF::loadView('report.fileClinicalNeonatology', compact('data', 'organization', 'criterios'));
            return $pdf->download("Informe_ficha_clinica_neonatologia.pdf");
        } catch (Exception $e) {
            return $e;
        }
    }

    public function diabeticPatientIndex (Request $request) {
        try {
            $model = $this->service->diabeticPatientIndex($request);
            $data = DiabeticPatientReportResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function diabeticPatientGenerate(Request $request) {
        try {
            $model = $this->service->diabeticPatientIndex($request);
            $data = DiabeticPatientReportResource::collection($model);
            $criterios = $this->service->diabeticPatientCriterion($request);
            $organization = Organization::find(3);
            $pdf = \PDF::loadView('report.diabeticPatient', compact('data', 'organization', 'criterios'));
            return $pdf->download("Informe_patiente_diabetico.pdf");
        } catch (Exception $e) {
            return $e;
        }
    }

}
