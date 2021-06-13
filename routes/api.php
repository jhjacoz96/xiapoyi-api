<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Events\CommentAdultOldEvent;
use App\Events\FileClinicalObstetricEvent;
use App\Events\DiabeticPatientEvent;
use App\Pregnant;
use App\Comment;
use App\DiabeticPatient;

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
    Route::post('login-diabetic', 'AuthController@loginDiabetic');
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

      
      Route::ApiResource('zone', 'ZoneController');
      Route::get('zone-by-canton/{id}', 'ZoneController@zoneFind');
      Route::get('province', 'ZoneController@provinceFind');
      Route::get('canton/{id}', 'ZoneController@cantonFind');

      Route::get('gender', 'GenderController@index');
      Route::get('type-document', 'TypeDocumentController@index');

      Route::ApiResource('presentation', 'PresentationController');
      Route::ApiResource('medicine', 'MedicineController');
      Route::ApiResource('frequency', 'FrequencyController');
      Route::ApiResource('measure', 'MeasureController');
      Route::ApiResource('type-blood', 'TypeBloodController');
      Route::ApiResource('cultural-group', 'CulturalGroupController');
      Route::ApiResource('pathology', 'PathologyController');
      Route::ApiResource('disability', 'DisabilityController');
      Route::ApiResource('group-age', 'GroupAgeController');
      Route::ApiResource('risk-classification', 'RiskClassificationController');
      Route::ApiResource('risk', 'RiskController');
      Route::ApiResource('level-risk', 'LevelRiskController');
      Route::ApiResource('level-total', 'LevelTotalController');
      Route::ApiResource('vaccine', 'VaccineController');
      Route::ApiResource('exam-routine', 'ExamRoutineController');

      Route::get('reflex', 'OtherParameterController@reflexIndex');
      Route::get('alteration-pregnant', 'OtherParameterController@alterationPregnantIndex');
      Route::get('pathology-neonatal', 'OtherParameterController@pathologyNeonatalIndex');
      Route::get('pathology-pregnant', 'OtherParameterController@pathologyPregnantIndex');

      Route::get('relationship', 'OtherParameterController@relationshipIndex');
      Route::get('psyshotrophic', 'OtherParameterController@psyshotrophicIndex');
      Route::get('gestation-week', 'OtherParameterController@GestationWeekIndex');
      Route::get('scholarship', 'OtherParameterController@ScholarshipIndex');

      Route::ApiResource('filter-one-publication', 'FilterOnePublicationController');
      Route::ApiResource('filter-two-publication', 'FilterTwoPublicationController');
      Route::get('filter-two-publication/filter/{id}', 'FilterTwoPublicationController@indexFilter');
      Route::ApiResource('filter-three-publication', 'FilterThreePublicationController');
      Route::get('filter-three-publication/filter/{id}', 'FilterThreePublicationController@indexFilter');
      Route::ApiResource('resource', 'ResourceController');
      Route::ApiResource('publication', 'PublicationController');
      Route::ApiResource('carrusel', 'CarruselController');

      Route::prefix('control-diabetic')->group(function () {
            Route::get('', [
                'uses' => 'DiabeticPatientController@index',
                'as' => 'api.controlDiabetic.index'
            ]);
            Route::put('{id}', [
                'uses' => 'DiabeticPatientController@update',
                'as' => 'api.controlDiabetic.update'
            ]);
            Route::post('{id}/register-glucose', [
                'uses' => 'DiabeticPatientController@registerGlucose',
                'as' => 'api.controlDiabetic.registerGlocose.post'
            ]);
            Route::get('{id}/register-glucose', [
                'uses' => 'DiabeticPatientController@indexRegisterGlucose',
                'as' => 'api.controlDiabetic.registerGlocose.index'
            ]);
            Route::post('{id}/register-weight', [
                'uses' => 'DiabeticPatientController@registerWeight',
                'as' => 'api.controlDiabetic.registerWeight.post'
            ]);
            Route::get('{id}/register-weight', [
                'uses' => 'DiabeticPatientController@indexRegisterWeight',
                'as' => 'api.controlDiabetic.registerWeight.index'
            ]);
      });

      Route::prefix('movil-diabetic')->group(function () {
            Route::post('register-glucose', [
                'uses' => 'DiabeticPatientController@registerGlucoseMovil',
                'as' => 'api.controlDiabetic.registerGlocoseMovil.post'
            ]);
            Route::get('register-glucose', [
                'uses' => 'DiabeticPatientController@indexRegisterGlucoseMovil',
                'as' => 'api.controlDiabetic.registerGlocoseMovil.index'
            ]);
            Route::post('register-weight', [
                'uses' => 'DiabeticPatientController@registerWeightMovil',
                'as' => 'api.controlDiabetic.registerWeightMovil.post'
            ]);
            Route::get('register-weight', [
                'uses' => 'DiabeticPatientController@indexRegisterWeightMovil',
                'as' => 'api.controlDiabetic.registerWeightMovil'
            ]);
            Route::get('treatment', [
                'uses' => 'DiabeticPatientController@indexTreatment',
                'as' => 'api.controlDiabetic.treatment'
            ]);

            Route::post('continue-treatment', [
                'uses' => 'DiabeticPatientController@continueTreatment',
                'as' => 'api.controlDiabetic.continueTreatment'
            ]);
            Route::get('register-treatment', [
                'uses' => 'DiabeticPatientController@indexRegisterTreatment',
                'as' => 'api.controlDiabetic.indexRegisterTreatment'
            ]);
            Route::get('activity', [
                'uses' => 'DiabeticPatientController@indexActivity',
                'as' => 'api.controlDiabetic.activity'
            ]);

            Route::post('continue-activity', [
                'uses' => 'DiabeticPatientController@continueActivity',
                'as' => 'api.controlDiabetic.continueActivity'
            ]);
            Route::get('register-activity', [
                'uses' => 'DiabeticPatientController@indexRegisterActivity',
                'as' => 'api.controlDiabetic.indexRegisterActivity'
            ]);
      });

      Route::post('file-clinical-neonatology/search', 'FileClinicalNeonatologyController@search');
      Route::post('file-clinical-neonatology/filter', 'FileClinicalNeonatologyController@filter');
      Route::ApiResource('file-clinical-neonatology', 'FileClinicalNeonatologyController');

      Route::post('file-clinical-obstetric/search', 'PregnantController@search');
      Route::post('file-clinical-obstetric/filter', 'PregnantController@filter');
      Route::get('file-clinical-obstetric/check/{cedula}', 'PregnantController@check');
      Route::ApiResource('file-clinical-obstetric', 'PregnantController');

      Route::post('file-family/search', 'FileFamilyController@search');
      Route::post('file-family/filter', 'FileFamilyController@filter');
      Route::get('file-family/member/verify-document/{cedula}', 'FileFamilyController@verifyDocument');
      Route::get('file-family/member/verify-email/{email}', 'FileFamilyController@verifyEmail');
      Route::ApiResource('file-family', 'FileFamilyController');

      Route::prefix('employee')->group(function () {
        Route::post('password', 'EmployeeController@updatePassword');
        Route::post('avatar', [
              'uses' => 'EmployeeController@updateAvatar',
              'as' => 'api.avatar.update'
          ]);
          Route::get('read-all-notifications', 'EmployeeController@readAllNotifications');
          Route::get('read-notifications/{id}', 'EmployeeController@readNotifications');
          Route::get('notifications', 'EmployeeController@notifications');
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
      Route::post('service-web', 'ConfigWeb@serviceStore');
      Route::get('service-web', 'ConfigWeb@serviceIndex');
      Route::post('older-adult', 'ConfigWeb@olderAdultStore');
      Route::get('older-adult', 'ConfigWeb@olderAdultIndex');
      Route::get('diabetic', 'ConfigWeb@diabeticIndex');
      Route::post('diabetic', 'ConfigWeb@diabeticStore');
      Route::post('subcription', 'ConfigWeb@subcriptionStore');
      Route::get('subcription', 'ConfigWeb@subcriptionIndex');
      Route::post('contact', 'ConfigWeb@contactStore');
      Route::get('contact', 'ConfigWeb@contactIndex');

      Route::post('suscription', 'SuscriptionController@store');
      Route::ApiResource('type-comment', 'TypeCommentController');
      Route::ApiResource('comment', 'CommentController');


      Route::get('/event', function () {
        $comment = Comment::find(1);
        event(new CommentAdultOldEvent($comment));
        return 'send';
      });

       Route::prefix('dashboard')->group(function () {
          Route::get('', [
              'uses' => 'ReportStadisticController@dashboard',
          ]);
       });
  });

  Route::group([
    'prefix' => 'web'
  ], function () {
    Route::post('organization', 'ConfigWeb@organizationStore');
    Route::get('organization', 'ConfigWeb@organizationIndex');
     Route::get('organization-all', 'ConfigWeb@organizationFind');
    Route::post('us', 'ConfigWeb@upStore');
    Route::get('us', 'ConfigWeb@upIndex');
    Route::get('zone', 'ZoneController@index');
    Route::post('service', 'ConfigWeb@serviceStore');
    Route::get('service', 'ConfigWeb@serviceIndex');
    Route::get('service-all', 'ConfigWeb@serviceAllIndex');
    Route::post('older-adult', 'ConfigWeb@olderAdultStore');
    Route::get('older-adult', 'ConfigWeb@olderAdultIndex');
    Route::get('older-adult-all', 'ConfigWeb@olderAdultAllIndex');
    Route::get('publication', 'ConfigWeb@publicationIndex');
    Route::post('publication-search', 'ConfigWeb@publicationSearch');
    Route::post('publication-filter', 'ConfigWeb@publicationFilter');
    Route::get('filter-one-publication', 'FilterOnePublicationController@index');
    Route::get('filter-two-publication/filter/{id}', 'FilterTwoPublicationController@indexFilter');
    Route::get('filter-three-publication/filter/{id}', 'FilterThreePublicationController@indexFilter');
    Route::post('dowloand-file', 'ConfigWeb@dowloandFile');
    Route::post('diabetic', 'ConfigWeb@diabeticStore');
    Route::get('diabetic', 'ConfigWeb@diabeticIndex');
    Route::post('subcription', 'ConfigWeb@subcriptionStore');
    Route::get('subcription', 'ConfigWeb@subcriptionIndex');
    Route::post('contact', 'ConfigWeb@contactStore');
    Route::get('contact', 'ConfigWeb@contactIndex');
    Route::get('carrusel', 'CarruselController@index');
    Route::get('type-comment', 'TypeCommentController@index');
    Route::post('comment', 'CommentController@store');
    Route::post('suscription', 'SuscriptionController@store');
  });
