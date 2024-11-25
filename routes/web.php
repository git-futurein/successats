<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CandidateFileImportController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientTermController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DeshboardMenuController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IndustryTypeController;
use App\Http\Controllers\JobcategoryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\Actions\FetchEmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendenceController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendJobController;
use App\Http\Controllers\GiroController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobStatusController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\MaritalStatusController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PassTypeController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\RemarksTypesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TimeSheetController;
use App\Http\Controllers\TncController;
use App\Http\Controllers\UploadFileTypeController;
use App\Http\Controllers\UserController;
use App\Models\ClientUploadFile;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\DateUpdatedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Dashbaord Start
// Route::get('/dashboard', function () {
//     return view('admin.dashboard.index');
// })->name('dashboard');
// Dashbaord ends

Route::get('/ats', function () {
    return redirect(route('login'));
})->middleware('auth');


Route::get('/', function () {

    return redirect(route('login'));
})->middleware('auth');

Auth::routes(['register' => false, 'login' => false]);
Route::get('/login', [UserController::class, 'loginform'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::any('/ATS/admin', function () {
    return redirect('/ATS/designation');
})->name('2fa')->middleware(['2fa', 'auth']);


Route::prefix('ATS')->group(function () {
    Route::get('/log', function () {
        return json_encode(activity::all()->last());
    });

    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    // Route::get('/employeefetch',[App\Http\Controllers\Action\FetchEmployeeController::class])->name('employee.fetch');

    Route::resources([
        '/roles' => RoleController::class,
        '/users' => UserController::class,
        '/department' => DepartmentController::class,
        '/designation' => DesignationController::class,
        '/employee' => EmployeeController::class,
        '/leave-type' => LeaveTypeController::class,
        '/tnc' => TncController::class,
        '/dashboard/menu' => DeshboardMenuController::class,
        '/religion' => ReligionController::class,
        '/client-term' => ClientTermController::class,
        '/marital-status' => MaritalStatusController::class,
        '/industry-type' => IndustryTypeController::class,
        '/clients' => ClientController::class,
        '/job-type' => JobTypeController::class,
        '/job-category' => JobcategoryController::class,
        '/job' => JobController::class,
        '/leave' => LeaveController::class,
        '/candidate' => CandidateController::class,
        '/import' => CandidateFileImportController::class,
        '/file-type' => UploadFileTypeController::class,
        '/pass-type' => PassTypeController::class,
        '/remarks-type' => RemarksTypesController::class,
        '/job-application' => JobApplicationController::class,
        '/bank' => BankController::class,
        '/giro' => GiroController::class,
        '/nationality' => NationalityController::class,
        '/company' => CompanyController::class,
        '/outlets' => OutletController::class,
        '/time-sheet' => TimeSheetController::class,
        '/attendence' => AttendenceController::class,
        '/job-status' => JobStatusController::class,
        '/countries' => CountryController::class,
    ]);

    Route::get('/leave/get/employee/{type}',  [LeaveController::class, 'getEmployees'])->name('leave.get.employees');
    Route::get('/leave/get/candidate/{type}',  [LeaveController::class, 'getCandidates'])->name('leave.get.candidates');

    Route::get('/authenticate',  [UserController::class, 'storecomplete'])->name('user.authenticate');
    Route::post('/users/fetch-email',  [UserController::class, 'search'])->name('email.searchapi');

    Route::get('/setting/profile', [App\Http\Controllers\AdminController::class, 'index'])->name('user.profiles');

    Route::get('/attendence/candidate/data/{id}',  [AttendenceController::class, 'getCandidateAttendenceData'])->name('attendence.get.candidate.data');

    Route::get('/attendence/edit/{id}/{month}',  [AttendenceController::class, 'editAttendence'])->name('edit.attendence');

    Route::get('/get/candidate/company/{id}',  [AttendenceController::class, 'getCandidateCompany'])->name('get.candidate.company');
    Route::any('/get/month/data', [AttendenceController::class, 'getMonthData'])->name('get.month.attendence.data');

    Route::get('/import',  [CandidateFileImportController::class, 'index'])->name('import.index');
    Route::post('/import/upload',  [CandidateFileImportController::class, 'upload'])->name('upload.files');
    Route::post('/delete/import/data',  [CandidateFileImportController::class, 'deleteUploadedData'])->name('delete.uploaded.data');
    Route::post('/import/extract',  [CandidateFileImportController::class, 'extractInfo'])->name('extract.info');
    Route::post('/import/data/temporary/save',  [CandidateFileImportController::class, 'temporaryDataSave'])->name('temporary.data.save');
    Route::post('/import/data/temporary/delete/{id}',  [CandidateFileImportController::class, 'temporaryDataDelete'])->name('temporary.data.delete');
    // Route::post('/import/candidate/data',  [CandidateFileImportController::class, 'importCandidateData'])->name('import.candidate.data');
    Route::post('/import/candidate/data', [CandidateFileImportController::class, 'importCandidateData'])->name('import.candidate.data');
    // Route::post('/preview-file', [CandidateFileImportController::class, 'previewFile'])->name('preview.file');
    // Employee extra route start
    Route::post('salary/info/post', [EmployeeController::class, 'salaryInfoPost'])->name('employee.salary.info.post');
    // Employee extra route ends

    Route::post('/file-upload/{id}', [ClientController::class, 'fileUpload'])->name('client.file.upload');
    Route::delete('/file-delete/{id}', [ClientController::class, 'fileDelete'])->name('client.file.delete');
    Route::post('/client/followup/{id}', [ClientController::class, 'followUp'])->name('client.followup');
    Route::post('/client/followup/update/{id}', [ClientController::class, 'updateFollowUp'])->name('client.followup.update');
    Route::delete('/client/followup/{id}', [ClientController::class, 'folowupDelete'])->name('client.followup.delete');
    Route::post('/client/import', [ClientController::class, 'clientImport'])->name('client.import');
    Route::post('/client/department/store', [ClientController::class, 'clientDepartmentStore'])->name('client.department.store');
    Route::delete('/client/department/delete/{id}', [ClientController::class, 'clientDepartmentDelete'])->name('client.department.delete');
    Route::get('/test', [ClientController::class, 'test']);
    Route::get('/test1', [ClientController::class, 'test1']);


    //Candidate extra part
    Route::post('/candidate/file-upload/{id}', [CandidateController::class, 'fileUpload'])->name('candidate.file.upload');
    Route::delete('/candidate/file-delete/{id}/{candidate}', [CandidateController::class, 'fileDelete'])->name('candidate.file.delete');
    Route::post('/candidate/followup/{id}', [CandidateController::class, 'followUp'])->name('candidate.followup');
    Route::delete('/candidate/followup/{id}', [CandidateController::class, 'folowupDelete'])->name('candidate.followup.delete');
    Route::post('/candidate/remark/{id}', [CandidateController::class, 'remark'])->name('candidate.remark');
    Route::delete('/candidate/remark/{id}', [CandidateController::class, 'remarkDelete'])->name('candidate.remark.delete');
    Route::post('/candidate/payroll/{id}', [CandidateController::class, 'payroll'])->name('candidate.payroll');
    Route::delete('/candidate/payroll/{id}', [CandidateController::class, 'payrollDelete'])->name('candidate.payroll.delete');
    Route::post('/candidate/working-hour/{id}', [CandidateController::class, 'workingHour'])->name('candidate.working.hour');
    Route::post('/candidate/family/{id}', [CandidateController::class, 'family'])->name('candidate.family');
    Route::delete('/candidate/family/{id}', [CandidateController::class, 'familyDelete'])->name('candidate.family.delete');
    Route::post('/candidate/resume/{id}', [CandidateController::class, 'resumeUpload'])->name('candidate.resume');
    Route::delete('/candidate/resume/{id}/{candidate}', [CandidateController::class, 'resumeDelete'])->name('candidate.resume.delete');
    Route::post('/candidate/resume/update/{candidate}', [CandidateController::class, 'resumeMain'])->name('candidate.resume.main');

    Route::get('/candidate/timesheet-data/{timeSheetId}', [CandidateController::class, 'timeSheetData'])->name('candidate.timesheet.data');


    // Route::get('{any}',  [App\Http\Controllers\HomeController::class, 'index']);


    //  Route::get('/',  [App\Http\Controllers\AdminController::class, 'root'])->name('admin.dashboard');


    Route::any('/hello', [AttendanceController::class, 'mystore'])->name('mystore');

    // Client
    Route::post('/client/supervisor/store/{client}', [ClientController::class, 'supervisorStore'])->name('client.supervisor.store');
    Route::delete('/client/supervisor/{supervisor}',  [ClientController::class, 'deleteSupervisor'])->name('client.supervisor.delete');

    // Candidate
    Route::get('/candidates/search', [CandidateFileImportController::class, 'candidateSearch'])->name('candidates.search');
    Route::post('/candidates/search/result', [CandidateFileImportController::class, 'candidateSearchResult'])->name('candidate.search.resutl');

    Route::get('/get/candidate/remarks/{candidate}',  [CandidateFileImportController::class, 'getCandidateRemark']);
    Route::get('/get/candidate/teamleader',  [CandidateFileImportController::class, 'getCandidateTeamleader']);
    Route::get('/get/candidate/rc',  [CandidateFileImportController::class, 'getCandidateRc']);
    Route::post('/search/leave',  [LeaveController::class, 'searchLeave'])->name('search.leave');
    Route::get('/search/cancle/{leave}',  [LeaveController::class, 'cancle'])->name('leave.cancle');
    Route::get('/attendence/print/{attendence}',  [AttendenceController::class, 'attendencePrint'])->name('attendence.print');
    Route::get('/attendence/print/p/{attendence}',  [AttendenceController::class, 'attendencePrint_p'])->name('attendence.print_p');
    Route::get('/get/client/team/{client}',  [JobController::class, 'getClientLeader'])->name('get.client.leader');
    Route::get('/get/client/remarks/{client}',  [ClientController::class, 'getClientRemark'])->name('get.client.remark');
    Route::get('/get/consultant/{employee}',  [EmployeeController::class, 'getConsultant'])->name('get.consultants');
    Route::get('/get/teamleader/{employee}',  [EmployeeController::class, 'getTeamleader'])->name('get.teamleader');
    Route::get('/time/sheet/details/{timesheet}',  [TimeSheetController::class, 'timeSheetDetails'])->name('time.sheet.details');

    Route::get('/change/dashboard/remark/{dashboard}/{id}', [DashboardController::class, 'change_dashboard_remark'])->name('change.dashboard.remark');
    Route::get('/candidates/edit/remark/{candidate}/{remark}', [CandidateController::class, 'candidates_edit_remark'])->name('candidates.edit.remark');
    Route::post('/candidate/remark/update/{remark}', [CandidateController::class, 'candidate_remark_update'])->name('candidate.remark.update');
    Route::get('/client/tnctemplate/download/{client}', [ClientController::class, 'client_tnctemplate_download'])->name('client.tnctemplate.download');
    Route::get('/get/attendence/{parent}', [AttendanceController::class, 'get_attendence'])->name('get.attendence');
    Route::get('/get/single/attendence/{attendance}', [AttendanceController::class, 'get_single_attendence'])->name('get.single.attendence');
    Route::post('/filter/job', [JobController::class, 'filter_job'])->name('filter.job');
})->middleware('auth');


Route::get('/job/lists',  [FrontendJobController::class, 'index'])->name('job.lists');
Route::get('/job/list/{job}',  [FrontendJobController::class, 'job_details'])->name('job.details');
Route::post('/job/apply',  [FrontendJobController::class, 'apply'])->name('job.apply');
Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'mark_as_read'])->name('notifications.markAsRead');
