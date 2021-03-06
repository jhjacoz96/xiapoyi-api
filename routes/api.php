<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signUp');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {

        Route::get('logout', 'AuthController@logout');

    });
});

Route::group([
    'middleware' => 'auth:api'
  ], function() {

      Route::ApiResource('role', 'RoleController');
      Route::put('role/assign-permissions/{id}', 'RoleController@assignPermission');

      Route::ApiResource('type-employee', 'TypeEmployeeController');

      Route::ApiResource('specialty', 'SpecialtyController');

      Route::ApiResource('institution', 'InstitutionController');

      Route::ApiResource('service', 'ServiceController');
      Route::put('service/assign-activities/{id}', 'ServiceController@assignActivities');

      Route::ApiResource('activity', 'ActivityController');

      

      Route::get('zone-by-canton/{id}', 'ZoneController@zoneFind');
      Route::get('province', 'ZoneController@provinceFind');
      Route::get('canton/{id}', 'ZoneController@cantonFind');

      Route::get('gender', 'GenderController@index');
      Route::get('type-document', 'TypeDocumentController@index');

      Route::ApiResource('presentation', 'PresentationController');
      Route::ApiResource('medicine', 'MedicineController');
      Route::ApiResource('frequency', 'FrequencyController');
      Route::ApiResource('measure', 'MeasureController');
      Route::ApiResource('type-blood', 'typeBloodController');
      Route::ApiResource('cultural-group', 'culturalGroupController');
      Route::ApiResource('pathology', 'PathologyController');
      Route::ApiResource('disability', 'DisabilityController');
      Route::ApiResource('group-age', 'GroupAgeController');
      Route::ApiResource('risk-classification', 'RiskClassificationController');
      Route::ApiResource('risk', 'RiskController');
      Route::ApiResource('level-risk', 'LevelRiskController');
      Route::ApiResource('level-total', 'LevelTotalController');
      Route::ApiResource('vaccine', 'VaccineController');
      Route::ApiResource('exam-routine', 'ExamRoutineController');

      Route::get('relationship', 'OtherParameterController@relationshipIndex');
      Route::get('psyshotrophic', 'OtherParameterController@psyshotrophicIndex');
      Route::get('gestation-week', 'OtherParameterController@GestationWeekIndex');
      Route::get('scholarship', 'OtherParameterController@ScholarshipIndexIndex');

      Route::prefix('employee')->group(function () {
          Route::post('', [
              'uses' => 'EmployeeController@store',
              'as' => 'api.employee.store'
          ]);
          Route::get('', [
              'uses' => 'EmployeeController@index',
              'as' => 'api.employee.index'
          ]);
          Route::get('{id}', [
              'uses' => 'EmployeeController@show',
              'as' => 'api.employee.show'
          ]);
          Route::put('{id}', [
              'uses' => 'EmployeeController@update',
              'as' => 'api.employee.show'
          ]);
          Route::delete('{id}', [
              'uses' => 'EmployeeController@delete',
              'as' => 'api.employee.delete'
          ]);
      });
  });
