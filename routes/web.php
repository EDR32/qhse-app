<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicDashboardController;

// New Livewire Component Imports
use App\Livewire\AccidentList;
use App\Livewire\AccidentCreate;
use App\Livewire\AccidentShow;
use App\Livewire\AccidentEdit;
use App\Livewire\ViolationList;
// use App\Livewire\ViolationCreate;
use App\Livewire\ViolationCreateUnit;
use App\Livewire\ViolationCreateDriver;
// use App\Livewire\ViolationShow;
use App\Livewire\ViolationShowUnit;
use App\Livewire\ViolationShowDriver;
use App\Livewire\ViolationEdit;
use App\Livewire\RcaList;
use App\Livewire\RcaCreate;
use App\Livewire\RcaShow;
use App\Livewire\RcaEdit;
use App\Livewire\CarList;
use App\Livewire\CarCreate;
use App\Livewire\CarShow;
use App\Livewire\CarEdit;
use App\Livewire\UnitMonthlyReportPage; // <-- Use new component class name
use App\Livewire\Master\UnitPage;
use App\Livewire\Master\DriverPage;
use App\Livewire\UserManagementPage;

// Placeholder for Manajemen Risiko Livewire Components
// use App\Livewire\ManajemenRisiko\TrainingList;
// use App\Livewire\ManajemenRisiko\FgdList;
// use App\Livewire\ManajemenRisiko\InspectionList;
// use App\Livewire\ManajemenRisiko\SafetyPatrolList;
// use App\Livewire\ManajemenRisiko\SafetyObservationTourList;
// use App\Livewire\ManajemenRisiko\CapaList;
// use App\Livewire\ManajemenRisiko\NearmissReportList;
// use App\Livewire\ManajemenRisiko\AuditReportList;
// use App\Livewire\ManajemenRisiko\ApdList;

Route::get('/', [PublicDashboardController::class, 'index'])->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
// Incident Management Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/incidents', App\Livewire\IncidentList::class)
        ->middleware('can:view all incidents')
        ->name('incidents.index');
    Route::get('/incidents/create', App\Livewire\IncidentCreate::class)
        ->middleware('can:create incident')
        ->name('incidents.create');
    Route::get('/incidents/{incident}', App\Livewire\IncidentShow::class)
        ->middleware('can:view all incidents') // Or a more specific 'view incident'
        ->name('incidents.show');
    Route::get('/incidents/{incident}/edit', App\Livewire\IncidentEdit::class)
        ->middleware('can:edit incident')
        ->name('incidents.edit');
});

// CAPA (Actions) Management Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/actions', App\Livewire\ActionList::class)
        ->middleware('can:manage actions')
        ->name('actions.index');
    Route::get('/actions/create', App\Livewire\ActionCreate::class)
        ->middleware('can:manage actions')
        ->name('actions.create');
    Route::get('/actions/{action}', App\Livewire\ActionShow::class)
        ->middleware('can:manage actions')
        ->name('actions.show');
    Route::get('/actions/{action}/edit', App\Livewire\ActionEdit::class)
        ->middleware('can:manage actions')
        ->name('actions.edit');
});

// Audits & Inspections Management Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/audits', App\Livewire\AuditList::class)
        ->middleware('can:view all audits')
        ->name('audits.index');
    Route::get('/audits/create', App\Livewire\AuditCreate::class)
        ->middleware('can:create audit')
        ->name('audits.create');
    Route::get('/audits/{audit}', App\Livewire\AuditShow::class)
        ->middleware('can:view all audits') // Or a more specific 'view audit'
        ->name('audits.show');
    Route::get('/audits/{audit}/edit', App\Livewire\AuditEdit::class)
        ->middleware('can:edit audit')
        ->name('audits.edit');
});
*/

// Accident Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/accidents', AccidentList::class)->name('accidents.index');
    Route::get('/accidents/create', AccidentCreate::class)->name('accidents.create');
    Route::get('/accidents/{accident}', AccidentShow::class)->name('accidents.show');
    Route::get('/accidents/{accident}/edit', AccidentEdit::class)->name('accidents.edit');
});

// Violation Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/violations', ViolationList::class)->name('violations.index');
    Route::get('/violations/create/unit', UnitMonthlyReportPage::class)->name('violations.create.unit'); // <-- Use new component
    Route::get('/violations/create/driver', ViolationCreateDriver::class)->name('violations.create.driver');
    Route::get('/violations/unit/{unit}', ViolationShowUnit::class)->name('violations.show.unit');
    Route::get('/violations/driver/{driver}', ViolationShowDriver::class)->name('violations.show.driver');
    Route::get('/violations/{violation}/edit', ViolationEdit::class)->name('violations.edit');
    // Route::get('/violations/create', ViolationCreate::class)->name('violations..create');
});

// RCA Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/rca', RcaList::class)->name('rca.index');
    Route::get('/accidents/{accident}/rca/create', RcaCreate::class)->name('rca.create');
    Route::get('/rca/{rca}', RcaShow::class)->name('rca.show');
    Route::get('/rca/{rca}/edit', RcaEdit::class)->name('rca.edit');
});

// CAR Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cars', CarList::class)->name('cars.index');
    Route::get('/rca/{rca}/car/create', CarCreate::class)->name('cars.create');
    Route::get('/cars/{car}', CarShow::class)->name('cars.show');
    Route::get('/cars/{car}/edit', CarEdit::class)->name('cars.edit');
});

// Manajemen Risiko Routes
Route::middleware(['auth', 'verified'])->prefix('manajemen-risiko')->name('manajemen-risiko.')->group(function () {
    Route::get('/training', function() { return 'Training'; })->name('training');
    Route::get('/fgd', function() { return 'FGD'; })->name('fgd');
    Route::get('/inspection', function() { return 'Inspection'; })->name('inspection');
    Route::get('/safety-patrol', function() { return 'Safety Patrol'; })->name('safety-patrol');
    Route::get('/safety-observation-tour', function() { return 'Safety Observation Tour'; })->name('safety-observation-tour');
    Route::get('/capa', function() { return 'CAPA'; })->name('capa');
    Route::get('/nearmiss-report', function() { return 'Nearmiss Report'; })->name('nearmiss-report');
    Route::get('/audit-report', function() { return 'Audit Report'; })->name('audit-report');
    Route::get('/apd', function() { return 'APD'; })->name('apd');
});

// Master Data Routes
Route::middleware(['auth', 'verified', 'can:manage-master-data'])->prefix('master')->name('master.')->group(function () {
    Route::get('/units', UnitPage::class)->name('units.index');
    Route::get('/drivers', DriverPage::class)->name('drivers.index');
});

// Document Control Management Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/documents', App\Livewire\DocumentList::class)
        ->middleware('can:view all documents')
        ->name('documents.index');
    Route::get('/documents/create', App\Livewire\DocumentCreate::class)
        ->middleware('can:create document')
        ->name('documents.create');
    Route::get('/documents/{document}', App\Livewire\DocumentShow::class)
        ->middleware('can:view all documents') // Or a more specific 'view document'
        ->name('documents.show');
    Route::get('/documents/{document}/edit', App\Livewire\DocumentEdit::class)
        ->middleware('can:edit document')
        ->name('documents.edit');
    Route::get('/documents/{document}/download', [App\Livewire\DocumentShow::class, 'download'])
        ->middleware('can:view all documents') // Or a more specific 'download document'
        ->name('documents.download');
});

Route::middleware('auth')->group(function () {
    Route::get('/users', UserManagementPage::class)->name('users.index')->middleware('can:manage users');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
