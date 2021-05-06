<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Enums\EnumResponse;
use App\TypeDocument;
use App\Http\Resources\TypeDocumentResource;
use App\Services\TypeDocumentService;

class TypeDocumentController extends Controller
{
    function __construct(TypeDocumentService $_TypeDocumentService)
    {
        $this->service = $_TypeDocumentService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         try {
            $model = $this->service->index();
            $data = TypeDocumentResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

}
