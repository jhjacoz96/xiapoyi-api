<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuditResource;
use App\Utils\Enums\EnumResponse;
use Illuminate\Http\Request;
use \OwenIt\Auditing\Models\Audit;
use App\Pregnant;

class AuditController extends Controller
{

    public function index(Request $request)
    {
        try {
            $q = Audit::with('user');
            !empty($request["auditable_type"]) ? $model = $q->where('auditable_type', $request["auditable_type"]) : "";
            !empty($request["user_id"]) ? $model = $q->where('user_id', $request["user_id"]) : "";
            !empty($request["date_start"]) &&
            !empty($request["date_start"]) ? $model = $q->whereBetween('created_at', [$request["date_start"], $request["date_end"]]) : "";
            $model = $q->get();
            $data = AuditResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }
}
