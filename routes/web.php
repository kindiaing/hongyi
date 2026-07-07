<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Contract\MainContractList;
use App\Livewire\Contract\MainContractForm;
use App\Livewire\Contract\SubContractList;
use App\Livewire\Contract\SubContractForm;
use App\Livewire\Asset\HardwareDeviceList;
use App\Livewire\Asset\HardwareDeviceForm;
use App\Livewire\Asset\SoftwareList;
use App\Livewire\Asset\SoftwareForm;
use App\Livewire\VendorPersonnel\VendorList;
use App\Livewire\VendorPersonnel\VendorForm;
use App\Livewire\VendorPersonnel\PersonnelList;
use App\Livewire\VendorPersonnel\PersonnelForm;
use App\Livewire\Inspection\InspectionTaskList;
use App\Livewire\Inspection\InspectionTaskDetail;
use App\Livewire\Inspection\InspectionPlanList;
use App\Livewire\Inspection\InspectionPlanForm;
use App\Livewire\Inspection\ScheduleList;
use App\Livewire\Inspection\ScheduleForm;
use App\Livewire\ServiceUnit\ServiceUnitList;
use App\Livewire\ServiceUnit\ServiceUnitForm;
use App\Livewire\SatisfactionSurvey\SatisfactionSurveyList;
use App\Livewire\SatisfactionSurvey\SatisfactionSurveyForm;
use App\Livewire\SatisfactionSurveyPlan\SatisfactionSurveyPlanList;
use App\Livewire\SatisfactionSurveyPlan\SatisfactionSurveyPlanForm;
use App\Livewire\System\DataDictionaryList;
use App\Livewire\System\DataDictionaryForm;
use App\Livewire\System\UserList;
use App\Livewire\System\UserForm;
use App\Livewire\System\OperationLogList;
use App\Livewire\System\AuditConfigList;
use App\Livewire\System\RoleList;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // 合同管理
    Route::prefix('contracts')->name('contracts.')->group(function () {
        Route::get('/main', MainContractList::class)->name('main.index');
        Route::get('/main/create', MainContractForm::class)->name('main.create');
        Route::get('/main/{id}/edit', MainContractForm::class)->name('main.edit');
        Route::get('/sub', SubContractList::class)->name('sub.index');
        Route::get('/sub/create', SubContractForm::class)->name('sub.create');
        Route::get('/sub/{id}/edit', SubContractForm::class)->name('sub.edit');
    });

    // 资产管理
    Route::prefix('assets')->name('assets.')->group(function () {
        Route::get('/hardware', HardwareDeviceList::class)->name('hardware.index');
        Route::get('/hardware/create', HardwareDeviceForm::class)->name('hardware.create');
        Route::get('/hardware/{id}/edit', HardwareDeviceForm::class)->name('hardware.edit');
        Route::get('/software', SoftwareList::class)->name('software.index');
        Route::get('/software/create', SoftwareForm::class)->name('software.create');
        Route::get('/software/{id}/edit', SoftwareForm::class)->name('software.edit');
    });

    // 运维单位与人员
    Route::get('/vendors', VendorList::class)->name('vendors.index');
    Route::get('/vendors/create', VendorForm::class)->name('vendors.create');
    Route::get('/vendors/{id}/edit', VendorForm::class)->name('vendors.edit');
    Route::get('/personnel', PersonnelList::class)->name('personnel.index');
    Route::get('/personnel/create', PersonnelForm::class)->name('personnel.create');
    Route::get('/personnel/{id}/edit', PersonnelForm::class)->name('personnel.edit');

    // 服务单位管理
    Route::get('/service-units', ServiceUnitList::class)->name('service-units.index');
    Route::get('/service-units/create', ServiceUnitForm::class)->name('service-units.create');
    Route::get('/service-units/{id}/edit', ServiceUnitForm::class)->name('service-units.edit');

    // 巡检/回访任务管理
    Route::prefix('inspection')->name('inspection.')->group(function () {
        Route::get('/tasks', InspectionTaskList::class)->name('tasks.index');
        Route::get('/tasks/{id}', InspectionTaskDetail::class)->name('tasks.detail');
        Route::get('/plans', InspectionPlanList::class)->name('plans.index');
        Route::get('/plans/create', InspectionPlanForm::class)->name('plans.create');
        Route::get('/plans/{id}/edit', InspectionPlanForm::class)->name('plans.edit');
        Route::get('/schedules', ScheduleList::class)->name('schedules.index');
        Route::get('/schedules/create', ScheduleForm::class)->name('schedules.create');
        Route::get('/schedules/{id}/edit', ScheduleForm::class)->name('schedules.edit');
    });

    // 回访/满意度调查管理
    Route::prefix('satisfaction')->name('satisfaction.')->group(function () {
        Route::get('/surveys', SatisfactionSurveyList::class)->name('surveys.index');
        Route::get('/surveys/create', SatisfactionSurveyForm::class)->name('surveys.create');
        Route::get('/surveys/{id}/edit', SatisfactionSurveyForm::class)->name('surveys.edit');
        Route::get('/plans', SatisfactionSurveyPlanList::class)->name('plans.index');
        Route::get('/plans/create', SatisfactionSurveyPlanForm::class)->name('plans.create');
        Route::get('/plans/{id}/edit', SatisfactionSurveyPlanForm::class)->name('plans.edit');
    });

    // 系统管理
    Route::prefix('system')->name('system.')->group(function () {
        Route::get('/dictionaries', DataDictionaryList::class)->name('dictionaries.index');
        Route::get('/dictionaries/create', DataDictionaryForm::class)->name('dictionaries.create');
        Route::get('/dictionaries/{id}/edit', DataDictionaryForm::class)->name('dictionaries.edit');
        Route::get('/users', UserList::class)->name('users.index');
        Route::get('/users/create', UserForm::class)->name('users.create');
        Route::get('/users/{id}/edit', UserForm::class)->name('users.edit');
        Route::get('/logs', OperationLogList::class)->name('logs.index');
        Route::get('/audit-configs', AuditConfigList::class)->name('audit_configs.index');
        Route::get('/roles', RoleList::class)->name('roles.index');
    });
});

require __DIR__.'/settings.php';
