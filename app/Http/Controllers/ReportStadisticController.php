<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Enums\EnumResponse;
use App\Pathology;
use App\Member;
use App\GroupAge;
use App\Risk;
use App\LevelRisk;
use App\LevelTotal;
use App\FileFamily;
use App\Zone;
use App\DiabeticPatient;
use App\RiskFile;
use App\Disability;
use App\Pregnant;
use App\Gender;
use App\FileClinicalNeonatology;
use App\GestationWeek;
use App\Mortality;
use App\CauseMortality;
use App\Comment;
use App\Medicine;
use App\TypeComment;
use App\FilterTwoPublication;
use App\Utils\CalAge;
use Carbon\Carbon;



class ReportStadisticController extends Controller
{
     public function dashboard()
    {
        try {
            $genders = Gender::All();
            $nameGender = [];
            $cantGender = [];
            foreach ($genders as $key => $value) {
            	$nameGender[] = $value['nombre'];  
            	$cantGender[] = Member::where('gender_id', $value["id"])->count();
            }

            $medicines = Medicine::has("diabeticPatients")->orHas("pregnants")->get();
            $nameMedicine = [];
            $cantMedicine = [];
            foreach ($medicines as $key => $value) { 
                $cantDiabetic = DiabeticPatient::whereHas("medicines", function($query)use($value){
                    $query->where("medicines.id", $value["id"]);
                })->count();
                $cantPregnant = Pregnant::whereHas("medicines", function($query)use($value){
                    $query->where("medicines.id", $value["id"]);
                })->count();
                $sum = $cantDiabetic + $cantPregnant;
                $cantMedicine[] = $sum;
                $nameMedicine[] = $value['name'] . " " . "(" . $sum . ")"; 
            }

            $groupAges = GroupAge::where('id','>=',4)->get();
            $nameGroupAge = [];
            $cantGroupAge = [];
            foreach ($groupAges as $key => $value) {
                $memberr = Member::where('gender_id', 2)
                    ->has('pregnant')
                    ->where('group_age_id', $value["id"])
                    ->count();
                $cantGroupAge[] = $memberr;
                $nameGroupAge[] = $value["name"] . " " . "(" . $memberr . ")";
            }

            $parroquias = Zone::All();
            $nameParroquia = [];
            $cantParroquia = [];
            foreach ($parroquias as $key => $value) {
                $d = FileFamily::where('zone_id', $value["id"])->count();
                $nameParroquia[] = $value["name"] . ' ' . '(' . $d  . ')';
                $cantParroquia[] = $d;
            }

            $typeComment = TypeComment::All();
            $nametypeComment = [];
            $cantTypeComment = [];
            foreach ($typeComment as $key => $value) {
                $comment = Comment::where('type_comment_id', $value["id"])->count();
                $cantTypeComment[] = $comment ;
                $nametypeComment[] = $value["nombre"] . ' ' . '(' . $comment . ')';
            }

            $levelRisk = LevelTotal::All();
            $nivelRisk = [];
            $colorRisk = [];
            foreach ($levelRisk as $key => $value) {
                $nivelRisk[] = [
                    "name" => $value["name"],
                    "data" => [],
                    "color" => $value["color"],
                ];
            }

            $zones = Zone::All();
            $nameZone = [];
            $cantMember = [];
            foreach ($zones as $key => $value) {
                $nameZone[] = $value["name"];
                foreach ($levelRisk as $key => $v) {
                    $cant = FileFamily::where('zone_id', $value["id"])->where('level_total_id', $v["id"])->count();
                    $nivelRisk[$key]["data"][] = $cant;
                }

             }


             $diabetic = DiabeticPatient::count();
             $member = Member::count();
             $adultOld = Member::where("group_age_id", ">=", 7)->count();
             $precoz = Pregnant::whereHas("member", function($query){
                $query->where("group_age_id", 4);
             })->count();
             $pregnant =  Pregnant::All();
             $agePregnant = collect([]);
             foreach ($pregnant as $key => $query) {
                $age = Carbon::parse($query->member["fecha_nacimiento"])->age;
                $agePregnant[] = $age;
             }

            $data = [
                "estadisticaMedinas" => [
                    "medicinas" =>  $nameMedicine,
                    "cantidades" => $cantMedicine,
                ],
                "estadisticaComentarios" => [
                    "tipoComentarios" =>  $nametypeComment,
                    "cantidades" => $cantTypeComment,
                ],
            	"estadisticaMiembros" => [
            		"generos" =>  $nameGender,
            		"cantidades" => $cantGender,
                ],
                "estadisticaEmbarazadas" => [
                    "grupoEdades" =>  $nameGroupAge,
                    "cantidades" =>  $cantGroupAge,
                ],
                "estadisticasRiesgos" => [
                    "parroquias" => $nameZone,
                    "nivelRiesgo" => $nivelRisk,
                    "color" => $colorRisk,
                ],
                "estadisticasParroquias" => [
                    "parroquias" => $nameParroquia,
                    "cantidades" => $cantParroquia,
                ],
                "dataInterest" => [
                    "diabeticos" => round(($diabetic / $member)*100)."%",
                    "adultosMayores" => round(($adultOld / $member)*100)."%",
                    "embarazoPrecoz" => round(($precoz / $member)*100)."%",
                    "promedioEmbarazo" =>  round($agePregnant->avg()),
                ],
                "cantidadFichasFamiliares" => FileFamily::count(),
                "cantidadEmbarazadas" => Member::where('embarazo', 1)->where('gender_id', 2)->count(),
                "cantidadDiabeticos" => DiabeticPatient::count(),
                "cantidadNeonatos" => FileClinicalNeonatology::count(),
                "cantidadComentarios" => Comment::whereNull("respuesta")->count(),
            ];



            return bodyResponseRequest(EnumResponse::ACCEPTED,  $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function reportPathology (Request $request) {
        try {
            $label = [];
            $gender = Gender::All();
            $data = [];
            foreach ($gender as $key => $value) {
                $data[] = [
                    "name" => $value["nombre"],
                    "data" => [],
                ];
            }

            $pathology = Pathology::All();
            $cantMember = [];
            foreach ($pathology as $key => $value) {
                $label[] = $value["name"];
                foreach ($gender as $key => $v) {
                    $q = Member::where("gender_id", $v["id"]);
                    $request["group_age_id"] != "null" ? $cant = $q->where("group_age_id", $request["group_age_id"]) : "";
                    $cant = $q->whereHas("pathologies", function($query)use($value){
                        $query->where("pathologies.id", $value["id"]);
                    })->count();
                    $data[$key]["data"][] = $cant;
                }

             }
             $data = [
                "label" => $label,
                "data" => $data,
            ];
            return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
              
        } catch (Exception $e) {
            return $e;
        }
    }

    public function levelTotalRisk (Request $request) {
        try {
            $label = [];
            $color = [];
            $cant = [];
            $legend = [];
            $model = LevelTotal::All();
            foreach ($model as $key => $value) {
               $color[] = $value["color"];
               $q = FileFamily::where("level_total_id", $value["id"]);
                    count($request["culturalGroup"]) > 0 ? $result = $q->whereIn("cultural_group_id", $request["culturalGroup"]) : "";
                     /*$result = $q->withCount('members')->havingRaw('members_count BETWEEN ? AND ?', [$request["member"][0], $request["member"][1]]);*/
                    count($request["zone"]) > 0          ? $result = $q->whereIn("zone_id", $request["zone"]) : "";
                    !empty($request["startDate"]) && 
                    !empty($request["endDate"])          ? $result = $q->whereBetween("created_at", [$request["startDate"], $request["endDate"]]) : "";
                     $result = $q->get();
                $cant[] = $result->count();
                $label[] = $value["name"] . " " . "(" . $result->count() .")";
                $legend[] = $value["name"] . " " . "(" . $result->count() . ")";
            }

            $data = [
                "label" => $label,
                "color" => $color,
                "data" => $cant,
                "legend" => $legend,
                "total" => array_sum($cant)
            ];
            return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function risk (Request $request) {
        try {
            $label = [];
            $cant = [];
            $total = collect([]);
            $model = Risk::All();
            foreach ($model as $key => $value) {
                $q = FileFamily::whereHas("riskFiles", function($query)use($request, $value){
                    $query->whereHas('risk', function($query)use($request, $value){
                        $query->where("name", $value["name"]);
                    });
                    $query->whereHas('levelRisk', function($query)use($request){
                        count($request["level"]) > 0 ? $query->whereIn("level_risks.id", $request["level"]) : "";
                        count($request["level"]) == 0 ? $query->where("value", "!=", 0) : "";
                    });
                });

                    count($request["zone"]) > 0 ? $result = $q->whereIn("zone_id", $request["zone"]) : "";
                    count($request["contamination"]) > 0 ? $result = $q->whereHas("contaminationPoints", function($query)use($request){
                        $query->where("contamination_id", $request["contamination"]);
                    }) : "";
                    $result = $q->get();
                    $total[] = $q->get();
                    $cant[] = $result->count();
                    $label[] = $value["name"] . " " . "(" . $result->count() .")";
            }

            $data = [
                "label" => $label,
                "data" => $cant,
                "total" => $total->collapse()->unique("id")->values()->count(),
            ];
            return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function evolution (Request $request) {
        try {
            $label = [];
            $cant = [];
            $model = collect([
                [
                    "name" => "Si cumplió",
                    "value" => "si",
                ],
                [
                    "name" => "No cumplió",
                    "value" => "no",
                ],
                [
                    "name" => "Cumplió parcialmente",
                    "value" => "parcial",
                ],
            ]);

            foreach ($model as $key => $value) {
               $q = FileFamily::whereHas("riskFiles", function($query) use($value, $request) {
                    $query->where("cumplio", $value["value"]);
                    !empty($request["risk"]) ? $query->where("risk_id", $request["risk"]) : "";
                    !empty($request["activity"]) ? $query->where("compromiso_id", $request["activity"]) : "";
                    !empty($request["startDateActivity"]) &&
                    !empty($request["endDateActivity"]) ? $query->whereBetween("fecha_programacion", [$request["startDateActivity"], $request["endDateActivity"]]) : "";
                    !empty($request["startDateEvaluation"]) && 
                    !empty($request["endDateEvaluation"]) ? $query->whereBetween("fecha_evaluacion", [$request["startDateEvaluation"], $request["endDateEvaluation"]]) : "";
               });
                    count($request["zone"]) > 0          ? $result = $q->whereIn("zone_id", $request["zone"]) : "";
                     $result = $q->get();
                $cant[] = $result->count();
                $label[] = $value["name"] . " " . "(" . $result->count() .")";
            }

            $data = [
                "label" => $label,
                "data" => $cant,
                "total" => array_sum($cant)
            ];
            return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function pathology (Request $request) {
        try {
            $label = [];
            $cant = [];
            $model = Pathology::All();
            foreach ($model as $key => $value) {
                $q = Member::whereHas("pathologies", function($query) use($value) {
                    $query->where("pathologies.id", $value["id"]);
                });
                count($request["groupAge"]) > 0 ? $result = $q->whereIn("group_age_id", $request["groupAge"]) : "";
                !empty($request["gender"])           ? $result = $q->where("gender_id", $request["gender"]) : "";
                count($request["disability"]) > 0           ? $result = $q->whereHas("disabilities", function($query) use($request) {
                    $query->whereIn("disabilities.id", $request["disability"]);
                }) : "";

                !empty($request["startDate"]) && 
                !empty($request["endDate"])          ? $result = $q->whereBetween("fecha_nacimiento", [$request["startDate"], $request["endDate"]]) : "";
                 $result = $q->get();
                 $cant[] = $result->count();
                 $label[] = $value["name"] . " " . "(" . $result->count() .")";
            }
            $data = [
                "label" => $label,
                "data" => $cant,
                "total" => array_sum($cant)
            ];
            return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function disability (Request $request) {
        try {
            $label = [];
            $cant = [];
            $model = Disability::All();
            foreach ($model as $key => $value) {
                $q = Member::whereHas("disabilities", function($query) use($value) {
                    $query->where("disabilities.id", $value["id"]);
                });
                count($request["groupAge"]) > 0 ? $result = $q->whereIn("group_age_id", $request["groupAge"]) : "";
                !empty($request["gender"])           ? $result = $q->where("gender_id", $request["gender"]) : "";
                count($request["pathology"]) > 0           ? $result = $q->whereHas("pathologies", function($query) use($request) {
                    $query->whereIn("pathologies.id", $request["pathology"]);
                }) : "";

                !empty($request["startDate"]) && 
                !empty($request["endDate"])          ? $result = $q->whereBetween("fecha_nacimiento", [$request["startDate"], $request["endDate"]]) : "";
                 $result = $q->get();
                 $cant[] = $result->count();
                 $label[] = $value["name"] . " " . "(" . $result->count() .")";
            }
            $data = [
                "label" => $label,
                "data" => $cant,
                "total" => array_sum($cant)
            ];
            return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function vaccine (Request $request) {
        try {
            $label = [];
            $cant = [];
            $model = collect([
                [
                    "name" => "Esquema de vacunación completa",
                    "value" => true,
                ],
                [
                    "name" => "Esquema de vacunación incompleta",
                    "value" => false,
                ],
            ]);
            foreach ($model as $key => $value) {
                $q = Member::where("vacunacion", $value["value"]);

                count($request["groupAge"]) > 0 ? $result = $q->whereIn("group_age_id", $request["groupAge"]) : "";
                count($request["zone"]) > 0     ? $result = $q->whereHas("FileFamily", function($query) use($request){
                    $query->whereIn("zone_id", $request["zone"]);
                }) : "";
                !empty($request["gender"])      ? $result = $q->where("gender_id", $request["gender"]) : "";

                !empty($request["startDate"]) && 
                !empty($request["endDate"])     ? $result = $q->whereBetween("fecha_nacimiento", [$request["startDate"], $request["endDate"]]) : "";
                 $result = $q->get();
                 $cant[] = $result->count();
                 $label[] = $value["name"] . " " . "(" . $result->count() .")";
            }
            $data = [
                "label" => $label,
                "data" => $cant,
                "total" => array_sum($cant)
            ];
            return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function pregnant (Request $request) {
         try {
            $label = [];
            $cant = [];
            $model = GroupAge::where("id", ">", 3)->get();
            foreach ($model as $key => $value) {
                $q = Pregnant::whereHas("member", function($query)use($value, $request){
                    $query->where("group_age_id", $value["id"]);
                    count($request["discapacidad"]) > 0 ? $query->whereHas("disabilities", function($query)use($request){
                        $query->whereIn("disabilities.id", $request["discapacidad"]);
                    }) : "";
                    count($request["zona"]) > 0 ? $query->whereHas("fileFamily", function($query)use($request){
                        $query->whereIn("zone_id", $request["zona"]);
                    }) : "";
                });
                count($request["psicotropica"]) > 0  ? $result = $q->whereHas("psychotrophics", function($query)use($request){
                    $query->whereIn("psychotrophic_substances.id", $request["psicotropica"]);
                }) : "";
                ($request["embarazo"] === true)      ? $result = $q->whereNull("recomendaciones") : "";
                ($request["embarazo"] === false)     ? $result = $q->whereNotNull("recomendaciones") : "";
                 $result = $q->get();
                 $cant[] = $result->count();
                 $label[] = $value["name"] . " " . "(" . $result->count() .")";
            }
            $data = [
                "label" => $label,
                "data" => $cant,
                "total" => array_sum($cant)
            ];
            return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function typeBirth (Request $request) {
        try {
            $label = [];
            $cant = [];
            $model = collect([
                [
                    "name" => "Vaginal",
                    "value" => "Vaginal",
                ],
                [
                    "name" => "Cesarea",
                    "value" => "Cesarea",
                ]
            ]);
            foreach ($model as $key => $value) {
                $q = Pregnant::where("tipo_parto", $value["value"]);
                count($request["gestation"]) > 0 ? $result = $q->whereIn("descripcion_gestacion", $request["gestation"]) : "";
                count($request["groupAge"]) > 0 ? $result = $q->whereHas("member", function($query) use($request) {
                    $query->whereIn("group_age_id", $request["groupAge"]);
                }) : "";
                !empty($request["startDate"]) && 
                !empty($request["endDate"])          ? $result = $q->whereBetween("created_at", [$request["startDate"], $request["endDate"]]) : "";
                 $result = $q->get();
                 /*!empty($request["imc"]) ? $result = $result->filter(function ($query) use($request){
                    $rankImc = collect([
                        [
                            "name" => "Desnutrición",
                            "rank" => [0,18.4]
                        ],
                        [
                            "name" => "Peso normal",
                            "rank" => [18.5,24]
                        ],
                        [
                            "name" => "Sobrepeso",
                            "rank" => [25,30]
                        ],
                        [
                            "name" => "Obesidad",
                            "rank" => [31,200]
                        ],
                    ]);
                    $findImc = $rankImc->where("name", $request["imc"])->first();
                    $imc = ($query->peso / pow($query->talla, 2));

                    return $findImc["rank"][0] <= $imc && $findImc["rank"][1] >= $imc;
                 }) : "";*/
                 $cant[] = $result->count();
                 $label[] = $value["name"] . " " . "(" . $result->count() .")";
            }
            $data = [
                "label" => $label,
                "data" => $cant,
                "total" => array_sum($cant)
            ];
            return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function plannedPregnancy (Request $request) {
        try {
            $label = [];
            $cant = [];
            $model = collect([
                [
                    "name" => "Embarazo planificado",
                    "value" => true
                ],
                [
                    "name" => "Embarazo no planificado",
                    "value" => false,
                ]
            ]);
            foreach ($model as $key => $value) {
                $q = Pregnant::where("embarazo_planificado", $value["value"]);
                count($request["groupAge"]) > 0 ? $result = $q->whereHas("member", function($query) use($request) {
                    $query->whereIn("group_age_id", $request["groupAge"]);
                }) : "";
                count($request["zone"]) > 0 ? $result = $q->whereHas("member", function ($query) use($request){
                    $query->whereHas("FileFamily", function ($query) use($request){
                            $query->whereIn("zone_id", $request["zone"]);
                    });
                }) : "";
                !empty($request["startDate"]) && 
                !empty($request["endDate"])          ? $result = $q->whereBetween("created_at", [$request["startDate"], $request["endDate"]]) : "";
                 $result = $q->get();
                 $cant[] = $result->count();
                 $label[] = $value["name"] . " " . "(" . $result->count() .")";
            }
            $data = [
                "label" => $label,
                "data" => $cant,
                "total" => array_sum($cant)
            ];
            return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function characteristic (Request $request) {
        try {
            $label = [];
            $cant = [];
            $total = ([]);
            $model = collect([
                [
                    "model" => "episiorria",
                    "name" => "Episiorrafia",
                ],
                [
                    "model" => "hemorroides",
                    "name" => "Hemorroides",
                ],
                [
                    "model" => "dolor",
                    "name" => "Dolor",
                ],
                [
                    "model" => "epitomia",
                    "name" => "Episiotomía/Desgarro",
                ],
            ]);
            foreach ($model as $key => $value) {
                $q = Pregnant::where($value["model"], true);
                count($request["groupAge"]) > 0 ? $result = $q->whereHas("member", function($query) use($request) {
                    $query->whereIn("group_age_id", $request["groupAge"]);
                }) : "";
                count($request["typeBirth"]) > 0 ? $result = $q->whereIn("tipo_parto", $request["typeBirth"]) : "";
                count($request["gestation"]) > 0 ? $result = $q->whereIn("descripcion_gestacion", $request["gestation"]) : "";
                count($request["pathologyPregnant"]) > 0 ? $result = $q->whereHas("pathologyPregnants", function($query){
                    $query->whereIn("pathology_pregnants.id", $request["pathologyPregnant"]);
                }) : "";
                !empty($request["startDate"]) && 
                !empty($request["endDate"])          ? $result = $q->whereBetween("created_at", [$request["startDate"], $request["endDate"]]) : "";
                 $result = $q->get();
                 $cant[] = $result->count();
                 $total[] = $q->get();
                 $label[] = $value["name"] . " " . "(" . $result->count() .")";
            }
            $data = [
                "label" => $label,
                "data" => $cant,
                "total" => $total->collapse()->unique("id")->values()->count(),
            ];
            return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function gestation (Request $request) {
        try {
            $label = [];
            $cant = [];
            $model = GestationWeek::All();
            foreach ($model as $key => $value) {
                $q = FileClinicalNeonatology::whereHas("pregnant", function($query) use($value, $request) {
                    $query->where("descripcion_gestacion", $value["name"]);
                    $query->whereHas("member", function($query) use($request) {
                        count($request["pathologys"]) > 0 ? $query->whereHas("pathologies", function($query) use($request){
                            $query->whereIn("pathologies.id", $request["pathologys"]);
                        }) : "";;
                        count($request["groupAge"]) > 0 ? $query->where("group_age_id", $request["groupAge"]) : "";;
                    });
                });
                count($request["pathologyPregnants"]) > 0 ? $result = $q->whereHas("pathologyPregnants", function($query) use($request) {
                    $query->whereIn("pathology_pregnants.id", $request["pathologyPregnants"]);
                }) : "";
                !empty($request["startDate"]) && 
                !empty($request["endDate"])          ? $result = $q->whereBetween("created_at", [$request["startDate"], $request["endDate"]]) : "";
                 $result = $q->get();
                 $cant[] = $result->count();
                 $label[] = $value["name"] . " " . "(" . $result->count() .")";
            }
            $data = [
                "label" => $label,
                "data" => $cant,
                "total" => array_sum($cant)
            ];
            return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function vaccineNeonatology (Request $request) {
        try {
            $label = [];
            $data = [];
            $model = collect([
                [
                    "name" => "Bcg",
                    "value" => "bcg",
                ],
                [
                    "name" => "Hb",
                    "value" => "hb",
                ],
                [
                    "name" => "Rotavirus",
                    "value" => "rotavirus",
                ],
                [
                    "name" => "Fipv",
                    "value" => "fipv",
                ],
                [
                    "name" => "Bopv",
                    "value" => "bopv",
                ],
                [
                    "name" => "Pentavaliente",
                    "value" => "pentavaliente",
                ],
                [
                    "name" => "Neumococo",
                    "value" => "neumococo",
                ],
                [
                    "name" => "Influenza estacionaria",
                    "value" => "influenza_estacionaria"
                ]
            ]);
            $dosis = collect([
                '1era dosis (6m)',
                '2da dosis (al mes de 1era dosis)',
                '1era dosis (2m)',
                '2da dosis (4m)',
                '3ra dosis (6m)',
                'Dosis unica (24 H)'
            ]);
            foreach ($dosis as $key => $v) {
                $data[] = [
                    "name" => $v,
                    "data" => []
                ];
            }
            foreach ($model as $key => $value) {
                $label[] = $value["name"];
                foreach ($dosis as $key => $v) {
                    $data[$key]["data"][] = FileClinicalNeonatology::where($value["value"], $v)->count();   
                }
            }
            $data = [
                "label" => $label,
                "data" => $data
            ];
            return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function glucose (Request $request) {
        try {
            $label = [];
            $cant = [];
            $d = collect([
                [
                    "name" => "Riesgo alto",
                    "value" => [0, 69.99],
                ],
                [
                    "name" => "Riesgo leve",
                    "value" => [100, 125.99],
                ],
                [
                    "name" => "Sin riesgo",
                    "value" => [70, 99.99],
                ]
            ]);
            foreach ($d as $key => $value) {
                $q = DiabeticPatient::with("member");
                switch ($value["name"]) {
                    case 'Riesgo alto':
                        $result = $q->whereBetween("nivel_glusemia", [0, 69.99]);
                        break;
                    case 'Riesgo leve':
                        $result = $q->whereBetween("nivel_glusemia", [100, 125.99]);
                        break;
                    case 'Sin riesgo':
                        $result = $q->whereBetween("nivel_glusemia", [70, 99.99]);
                        break;
                    default:
                        $result = $q->whereBetween("nivel_glusemia", [126, 900]);
                        break;
                }
                count($request["pathology"]) > 0 ? $result = $q->whereHas("member", function($query)use($request){
                    $query->whereHas("pathologies", function($query)use($request){
                        $query->whereIn("pathologies.id", $request["pathology"]);
                    });
                }) : "";
                count($request["imc"]) > 0 ? $result = $q->whereIn("descripcion_imc", $request["imc"]) : "";
                count($request["gender"]) > 0 ? $result = $q->whereHas("member", function($query)use($request){
                    $query->whereIn("gender_id", $request["gender"]);
                }) : "";
                count($request["groupAge"]) > 0 ? $result = $q->whereHas("member", function($query)use($request){
                    $query->whereIn("group_age_id", $request["groupAge"]);
                }) : "";
                $result = $q->get();
                $cant[] = $result->count();
                $label[] = $value["name"] . " " . "(" . $result->count() .")";
            }
            $data = [
                "label" => $label,
                "data" => $cant,
                "total" => array_sum($cant)
            ];
            return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function weight (Request $request) {
        try {
            $label = [];
            $cant = [];
            $model = collect([
                "Desnutrición",
                "Peso normal",
                "Sobrepeso",
                "Obesidad"
            ]);
            $p = collect([
                [
                    "name" => "Riesgo alto",
                    "valueOne" => [0, 69],
                    "valueTwo" => [126, 900],
                ],
                [
                    "name" => "Riesgo leve",
                    "valueOne" => [100, 125],
                    "valueTwo" => [100, 125],
                ],
                [
                    "name" => "Sin riesgo",
                    "valueOne" => [70, 99],
                    "valueTwo" => [70, 99],
                ]
            ]);
            !empty($request["glucose"]) ? $d = $p->where("name", $request["glucose"])->first() : "";
            foreach ($model as $key => $value) {
                $q = DiabeticPatient::where("descripcion_imc", $value);
                count($request["pathology"]) > 0 ? $result = $q->whereHas("member", function($query)use($request){
                    $query->whereHas("pathologies", function($query)use($request){
                        $query->whereIn("pathologies.id", $request["pathology"]);
                    });
                }) : "";
                !empty($request["glucose"]) ? $result = $q->whereBetween("nivel_glusemia", [$d["valueOne"][0], $d["valueOne"][1]])->orWhereBetween("nivel_glusemia",  [$d["valueTwo"][0], $d["valueTwo"][1]]) : "";
                count($request["gender"]) > 0 ? $result = $q->whereHas("member", function($query)use($request){
                    $query->whereIn("gender_id", $request["gender"]);
                }) : "";
                count($request["groupAge"]) > 0 ? $result = $q->whereHas("member", function($query)use($request){
                    $query->whereIn("group_age_id", $request["groupAge"]);
                }) : "";
                $result = $q->get();
                $cant[] = $result->count();
                $label[] = $value . " " . "(" . $result->count() .")";
            }
            $data = [
                "label" => $label,
                "data" => $cant,
                "total" => array_sum($cant)
            ];
             return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function comorbid (Request $request) {
        try {
            $label = [];
            $cant = [];
            $model = Pathology::where("id", ">=", 2)->get();
            foreach ($model as $key => $value) {
                $q = DiabeticPatient::whereHas("member", function($query)use($request, $value){
                    $query->whereHas("pathologies", function($query)use($request, $value){
                        $query->where("pathologies.id", $value["id"]);
                    });
                });
                count($request["imc"]) > 0 ? $result = $q->whereIn("descripcion_imc", $request["imc"]) : "";
                count($request["groupAge"]) > 0 ? $result = $q->whereIn("group_age_id", $request["groupAge"]) : "";
                $result = $q->get();
                $cant[] = $result->count();
                $label[] = $value["name"] . " " . "(" . $result->count() .")";
            }
            $data = [
                "label" => $label,
                "data" => $cant,
                "total" => array_sum($cant)
            ];
             return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function mortality (Request $request) {
        try {
            $label = [];
            $cant = [];
            $model = CauseMortality::All();
            foreach ($model as $key => $value) {
                 $q = Mortality::whereHas("causeMortality",function($query)use($request, $value){
                    $query->where("cause_mortalities.id", $value["id"]);
                 });
                 $result = $q->whereHas("fileFamily", function($query)use($request){
                    count($request["zone"]) > 0 ? $query->whereIn("zone_id", $request["zone"]) : "";
                    count($request["culturalGroup"]) > 0 ? $query->whereIn("cultural_group_id", $request["culturalGroup"]) : "";
                });
                $result = $q->whereHas("member", function($query)use($request){
                    count($request["groupAge"]) > 0 ? $query->whereIn("group_age_id", $request["groupAge"]) : "";
                    count($request["pathology"]) > 0 ? $query->whereHas("pathologies",function($query)use($request){
                        $query->whereIn("pathologies.id", $request["pathology"]);
                    }) : "";
                });
                $result = $q->get();
                $cant[] = $result->count();
                $label[] = $value["nombre"] . " " . "(" . $result->count() .")";
            }
            $data = [
                "label" => $label,
                "data" => $cant,
                "total" => array_sum($cant)
            ];
             return bodyResponseRequest( EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }
}
