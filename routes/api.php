<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Events\CommentAdultOldEvent;
use App\Events\FileClinicalObstetricEvent;
use App\Events\DiabeticPatientEvent;
use App\Pregnant;
use App\Comment;
use App\DiabeticPatient;
use App\Mortality;
use App\Member;

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
    Route::post('forgot-password', 'AuthController@forgot');
    Route::post('reset-password', 'AuthController@reset');
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

      Route::resource('service', 'ServiceController');
      Route::put('service/assign-activities/{id}', 'ServiceController@assignActivities');

      Route::ApiResource('activity', 'ActivityController');

      
      Route::ApiResource('zone', 'ZoneController');
      Route::get('zone-by-canton/{id}', 'ZoneController@zoneFind');
      Route::get('province', 'ZoneController@provinceFind');
      Route::get('canton/{id}', 'ZoneController@cantonFind');

      Route::get('gender', 'GenderController@index');
      Route::get('type-document', 'TypeDocumentController@index');

      Route::get('get-member', function(){
        $w = Member::All();
        return $w;
      });

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
      Route::ApiResource('cause-mortality', 'CauseMortalityController');
      Route::ApiResource('contamination', 'ContaminationController');
      Route::get('cause-contamination/find/{id}', 'CauseContaminationController@find');
      Route::ApiResource('cause-contamination', 'CauseContaminationController');
      Route::ApiResource('vaccine', 'VaccineController');
      Route::ApiResource('exam-routine', 'ExamRoutineController');
      Route::ApiResource('activity-evolution', 'ActivityEvaluationController');

      Route::ApiResource('reflex', 'ReflexController');
      Route::ApiResource('senal-alarm', 'SenalAlarmController');
      Route::ApiResource('alteration-pregnant', 'AlterationPregnantController');
      Route::ApiResource('pathology-neonatal', 'PathologyNeonatalController');
      Route::ApiResource('pathology-pregnant', 'PathologyPregnantController');

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
            Route::get('index-recent', [
                'uses' => 'DiabeticPatientController@indexRecent',
                'as' => 'api.controlDiabetic.indexRecent'
            ]);
            Route::get('{id}', [
                'uses' => 'DiabeticPatientController@show',
                'as' => 'api.controlDiabetic.show'
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
            Route::get('dashboard', [
                'uses' => 'DiabeticPatientController@dashboardMovil',
                'as' => 'api.diabeticPatientController.dashboardMovil'
            ]);
            Route::get('stadististic-glucose', [
                'uses' => 'DiabeticPatientController@stadististicGlucose',
                'as' => 'api.diabeticPatientController.stadististicGlucose'
            ]);
            Route::get('stadististic-weight', [
                'uses' => 'DiabeticPatientController@stadististicWeight',
                'as' => 'api.diabeticPatientController.stadististicWeight'
            ]);
            Route::prefix('/notification')->group(function () {
                Route::patch('fcm-token', 'NotificationMovilController@updateToken');
                Route::post('/send-notification','NotificationMovilController@notification');
            });
      });

      Route::ApiResource('file-clinical-neonatology', 'FileClinicalNeonatologyController');
       Route::prefix('file-clinical-neonatology')->group(function () {
        Route::post('search', 'FileClinicalNeonatologyController@search');
        Route::get('search/{history}', 'FileClinicalNeonatologyController@searchHistory');
        Route::post('filter', 'FileClinicalNeonatologyController@filter');
        Route::get('check-pregnant/{cedula}', 'FileClinicalNeonatologyController@checkFile');
      });

      
      Route::prefix('file-clinical-obstetric')->group(function () {
        Route::get('not-neonatology', 'PregnantController@indexNotNeonatology');
        Route::get('', 'PregnantController@index');
        Route::post('', 'PregnantController@store');
        Route::put('{id}', 'PregnantController@update');
        Route::get('{id}', 'PregnantController@show');
        Route::delete('{id}', 'PregnantController@delete');
        Route::post('search', 'PregnantController@search');
        Route::get('search/{history}', 'PregnantController@searchHistory');
        Route::post('filter', 'PregnantController@filter');
        Route::get('check/{cedula}', 'PregnantController@check');
        Route::get('check-pregnant/{cedula}', 'PregnantController@checkFile');
      });

      Route::ApiResource('file-family', 'FileFamilyController');
      Route::prefix('file-family')->group(function () {
        Route::post('search', 'FileFamilyController@search');
        Route::post('filter', 'FileFamilyController@filter');
        Route::get('member/verify-document/{cedula}', 'FileFamilyController@verifyDocument');
        Route::get('member/verify-email/{email}', 'FileFamilyController@verifyEmail');
        Route::get('search/{history}', 'FileFamilyController@searchHistory');
      });

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

      Route::prefix('report')->group(function () {
        Route::post('file-family', [
            'uses' => 'ReportController@fileFamilyIndex',
            'as' => 'api.report.fileFamily.index'
        ]);
        Route::post('file-family/generate', [
            'uses' => 'ReportController@fileFamilyGenerate',
            'as' => 'api.report.fileFamilyGenerate.post'
        ]);
        Route::post('member/generate', [
            'uses' => 'ReportController@memberGenerate',
            'as' => 'api.report.memberGenerate.post'
        ]);
        Route::get('pdf', [
            'uses' => 'ReportController@pdf',
            'as' => 'api.report.fileFamily.index'
        ]);
        Route::post('member', [
              'uses' => 'ReportController@memberIndex',
              'as' => 'api.report.memberIndex.post'
          ]);
        Route::post('file-clinical-obstetric', [
              'uses' => 'ReportController@fileClinicalObstetricIndex',
              'as' => 'api.report.fileClinicalObstetricIndex.post'
          ]);
        Route::post('file-clinical-obstetric/generate', [
            'uses' => 'ReportController@fileClinicalObstetricGenerate',
            'as' => 'api.report.fileClinicalObstetricGenerate.post'
        ]);
        Route::post('file-clinical-neonatology', [
              'uses' => 'ReportController@fileClinicalNeonatologyIndex',
              'as' => 'api.report.fileClinicalNeonatologyIndex.post'
          ]);
        Route::post('file-clinical-neonatology/generate', [
            'uses' => 'ReportController@fileClinicalNeonatologyGenerate',
            'as' => 'api.report.fileClinicalNeonatologyGenerate.post'
        ]);
        Route::post('diabetic-patient', [
            'uses' => 'ReportController@diabeticPatientIndex',
            'as' => 'api.report.diabeticPatientIndex.post'
        ]);
         Route::post('diabetic-patient/generate', [
            'uses' => 'ReportController@diabeticPatientGenerate',
            'as' => 'api.report.diabeticPatientGenerate.post'
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
        return 'notification send';
      });

       Route::prefix('dashboard')->group(function () {
          Route::get('', [
              'uses' => 'ReportStadisticController@dashboard',
          ]);
          Route::get('report-pathology', [
              'uses' => 'ReportStadisticController@reportPathology',
          ]);
       });

       Route::prefix('report-stadistic')->group(function () {
          Route::post('level-total-risk', [
              'uses' => 'ReportStadisticController@levelTotalRisk',
          ]);
           Route::post('risk', [
              'uses' => 'ReportStadisticController@risk',
          ]);
          Route::post('evolution', [
              'uses' => 'ReportStadisticController@evolution',
          ]);
          Route::post('pathology', [
              'uses' => 'ReportStadisticController@pathology',
          ]);
          Route::post('disability', [
              'uses' => 'ReportStadisticController@disability',
          ]);
          Route::post('vaccine', [
              'uses' => 'ReportStadisticController@vaccine',
          ]);
          Route::post('pregnant', [
              'uses' => 'ReportStadisticController@pregnant',
          ]);
          Route::post('type-birth', [
              'uses' => 'ReportStadisticController@typeBirth',
          ]);
          Route::post('planned-pregnancy', [
              'uses' => 'ReportStadisticController@plannedPregnancy',
          ]);
          Route::post('characteristic', [
              'uses' => 'ReportStadisticController@characteristic',
          ]);
          Route::post('gestation', [
              'uses' => 'ReportStadisticController@gestation',
          ]);
          Route::post('vaccine-neonatology', [
              'uses' => 'ReportStadisticController@vaccineNeonatology',
          ]);
          Route::post('glucose', [
              'uses' => 'ReportStadisticController@glucose',
          ]);
          Route::post('weight', [
              'uses' => 'ReportStadisticController@weight',
          ]);
          Route::post('comorbid', [
              'uses' => 'ReportStadisticController@comorbid',
          ]);
          Route::post('mortality', [
              'uses' => 'ReportStadisticController@mortality',
          ]);
       });

       Route::prefix('administration-system')->group(function () {
          Route::prefix('/backup-db')->group(function () {
            Route::get('', 'BackupController@index');
            Route::get('dropbox', 'BackupController@indexDropbox');
            Route::get('store', 'BackupController@store');
            Route::get('download/{filename}', 'BackupController@download');
            Route::get('dropbox/download/{filename}', 'BackupController@downloadDropbox');
            Route::get('destroy/{filename}', 'BackupController@destroy');
          });
          Route::prefix('/audit')->group(function () {
            Route::post('', 'AuditController@index');
          });
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

