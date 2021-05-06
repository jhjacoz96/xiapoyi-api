<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Activity;

class Service extends Model
{
    protected $fillable = [
        'nombre', 'descripcion',
    ];

    public function activities () {
        return $this->hasMany('App\Activity', 'service_id', 'id');
    }

    public function assignActivities (array $activitiesItems) {
        $children = $this->activities;
        $activitiesItems = collect($activitiesItems);
        $deletedIds = $children->filter(function ($child) use ($activitiesItems) {
            return empty($activitiesItems->where('id', $child->id)->first());
        })->map(function ($child) {
            $id = $child->id;
            $child->update(["service_id" => null]);
            return $id;
        });
       foreach ($activitiesItems as $item) {
        $model = Activity::find($item["id"]);
        $model->update(["service_id" => $item["service_id"]]);
       }
    }
}
