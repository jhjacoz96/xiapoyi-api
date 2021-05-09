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

      Route::get('role/permission', 'RoleController@permissionIndex');
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

      Route::ApiResource('filter-one-publication', 'FilterOnePublicationController');
      Route::ApiResource('filter-two-publication', 'FilterTwoPublicationController');
      Route::get('filter-two-publication/filter/{id}', 'FilterTwoPublicationController@indexFilter');
      Route::ApiResource('filter-three-publication', 'FilterThreePublicationController');
      Route::get('filter-three-publication/filter/{id}', 'FilterThreePublicationController@indexFilter');
      Route::ApiResource('resource', 'ResourceController');
      Route::ApiResource('publication', 'PublicationController');
      Route::ApiResource('carrusel', 'CarruselController');

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


      Route::post('organization', 'ConfigWeb@organizationStore');
      Route::get('organization', 'ConfigWeb@organizationIndex');
      Route::post('us', 'ConfigWeb@upStore');
      Route::get('us', 'ConfigWeb@upIndex');
      Route::post('service', 'ConfigWeb@serviceStore');
      Route::get('service', 'ConfigWeb@serviceIndex');
      Route::post('older-adult', 'ConfigWeb@olderAdultStore');
      Route::get('older-adult', 'ConfigWeb@olderAdultIndex');
      Route::post('diabetic', 'ConfigWeb@diabeticStore');
      Route::get('diabetic', 'ConfigWeb@diabeticIndex');
      Route::post('subcription', 'ConfigWeb@subcriptionStore');
      Route::get('subcription', 'ConfigWeb@subcriptionIndex');
      Route::post('contact', 'ConfigWeb@contactStore');
      Route::get('contact', 'ConfigWeb@contactIndex');

  });

  Route::group([
    'prefix' => 'web'
  ], function () {
    Route::post('organization', 'ConfigWeb@organizationStore');
    Route::get('organization', 'ConfigWeb@organizationIndex');
    Route::post('up', 'ConfigWeb@upStore');
    Route::get('up', 'ConfigWeb@upIndex');
    Route::post('service', 'ConfigWeb@serviceStore');
    Route::get('service', 'ConfigWeb@serviceIndex');
    Route::post('older-adult', 'ConfigWeb@olderAdultStore');
    Route::get('older-adult', 'ConfigWeb@olderAdultIndex');
    Route::post('diabetic', 'ConfigWeb@diabeticStore');
    Route::get('diabetic', 'ConfigWeb@diabeticIndex');
    Route::post('subcription', 'ConfigWeb@subcriptionStore');
    Route::get('subcription', 'ConfigWeb@subcriptionIndex');
    Route::post('contact', 'ConfigWeb@contactStore');
    Route::get('contact', 'ConfigWeb@contactIndex');

  });
