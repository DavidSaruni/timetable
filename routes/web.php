<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\CohortController;
use App\Http\Controllers\CommonUnitController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FullDayLocationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\LabtypeController;
use App\Http\Controllers\LectureRoomController;
use App\Http\Controllers\LecturerPreferredTimeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\SchoolBuildingController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SchoolFullDayLocationController;
use App\Http\Controllers\SchoolLecturerController;
use App\Http\Controllers\TimetableInstanceController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UnitPreferenceController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitAssingmentController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.perform');
});

Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
// not yet below
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
// not yet above
Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [LogoutController::class, 'perform'])->name('logout');

    Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings');
	Route::get('/buildings/{building}', [BuildingController::class, 'show'])->name('building.show');
	Route::post('/buildings', [BuildingController::class, 'store'])->name('building.store');
	Route::get('/buildingRow', [BuildingController::class, 'buildingRow'])->name('building.row');
	Route::post('/buildingUpdate', [BuildingController::class, 'update'])->name('building.update');
	Route::delete('/buildingDelete', [BuildingController::class, 'destroy'])->name('building.delete');

	Route::get('/fulldaylocations', [FullDayLocationController::class, 'index'])->name('fulldaylocations');
	Route::get('/fulldaylocations/{fulldaylocation}', [FullDayLocationController::class, 'show'])->name('fulldaylocation.show');
	Route::post('/fulldaylocations', [FullDayLocationController::class, 'store'])->name('fulldaylocation.store');
	Route::post('/fulldaylocationUpdate', [FullDayLocationController::class, 'update'])->name('fulldaylocation.update');
	Route::get('/fulldaylocationRow', [FullDayLocationController::class, 'fulldaylocationRow'])->name('fulldaylocation.row');
	Route::delete('/fulldaylocationDelete', [FullDayLocationController::class, 'destroy'])->name('fulldaylocation.delete');

	Route::get('/labtypes', [LabtypeController::class, 'index'])->name('labtypes');
	Route::get('/labtypes/{labtype}', [LabtypeController::class, 'show'])->name('labtype.show');
	Route::post('/labtypes', [LabtypeController::class, 'store'])->name('labtype.store');
	Route::post('/labtypeUpdate', [LabtypeController::class, 'update'])->name('labtype.update');
	Route::get('/labtypeRow', [LabtypeController::class, 'labtypeRow'])->name('labtype.row');
	Route::delete('/labtypeDelete', [LabtypeController::class, 'destroy'])->name('labtype.delete');

	Route::get('/cohortRow', [CohortController::class, 'cohortRow'])->name('cohort.row');
	Route::post('/cohortUpdate', [CohortController::class, 'update'])->name('cohort.update');

	Route::post('/labs', [LabController::class, 'store'])->name('lab.store');

	Route::post('/lecturerooms', [LectureRoomController::class, 'store'])->name('lectureroom.store');

	Route::post('/schoolbuildings', [SchoolBuildingController::class, 'store'])->name('schoolbuilding.store');
	Route::delete('/schoolbuildingDelete', [SchoolBuildingController::class, 'destroy'])->name('schoolbuilding.destroy');

	Route::post('/schoolFullDayLocation', [SchoolFullDayLocationController::class, 'store'])->name('schoolFullDayLocation.store');
	Route::delete('/schoolFullDayLocationDelete', [SchoolFullDayLocationController::class, 'destroy'])->name('schoolFullDayLocation.destroy');

	Route::post('/schoollecturers', [SchoolLecturerController::class, 'store'])->name('schoollecturer.store');
	Route::delete('/schoollecturerDelete', [SchoolLecturerController::class, 'destroy'])->name('schoollecturer.destroy');

	Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('department.show');
	Route::post('/departments', [DepartmentController::class, 'store'])->name('department.store');
	Route::get('/departmentRow', [DepartmentController::class, 'departmentRow'])->name('department.row');
	Route::delete('/departmentDelete', [DepartmentController::class, 'destroy'])->name('department.destroy');

	Route::post('/programs', [ProgramController::class, 'store'])->name('program.store');
	Route::get('/programs/{program}', [ProgramController::class, 'show'])->name('program.show');
	Route::delete('/programDelete', [ProgramController::class, 'destroy'])->name('program.destroy');

	Route::get('/users', [UserController::class, 'index'])->name('users');

	Route::get('/preferences', [LecturerPreferredTimeController::class, 'index'])->name('preferences');
	Route::post('/lecturerpreferences', [LecturerPreferredTimeController::class, 'store'])->name('lecturerpreferences.store');
	Route::delete('/lecturerpreferencesDelete', [LecturerPreferredTimeController::class, 'destroy'])->name('lecturerpreferences.destroy');

	Route::delete('/unitPreferencesDelete', [UnitPreferenceController::class, 'destroy'])->name('unitPreferences.destroy');
	Route::post('/createUnitPreferences', [UnitPreferenceController::class, 'create'])->name('unitPreferences.create');
	Route::post('/unitPreferences', [UnitPreferenceController::class, 'store'])->name('unitPreferences.store');
	Route::delete('/unitPreferences', [UnitPreferenceController::class, 'destroy'])->name('unitPreferences.destroy2');

	Route::get('/schools', [SchoolController::class, 'index'])->name('schools');
	Route::get('/schools/{school}', [SchoolController::class, 'show'])->name('school.show');
	Route::post('/schools', [SchoolController::class, 'store'])->name('school.store');
	Route::post('/schoolUpdate', [SchoolController::class, 'update'])->name('school.update');
	Route::get('/schoolRow', [SchoolController::class, 'schoolRow'])->name('school.row');
	Route::delete('/schoolDelete', [SchoolController::class, 'destroy'])->name('school.delete');

    Route::get('/commonunits', [CommonUnitController::class, 'index'])->name('commonunits');
    Route::get('/commonunits/{commonunit}', [CommonUnitController::class, 'show'])->name('commonunit.show');
    Route::post('/commonunits', [CommonUnitController::class, 'store'])->name('commonunit.store');
    Route::get('/commonunitRow', [CommonUnitController::class, 'commonunitRow'])->name('commonunit.row');
    Route::post('/commonunitUpdate', [CommonUnitController::class, 'update'])->name('commonunit.update');
    Route::delete('/commonunitDelete', [CommonUnitController::class, 'destroy'])->name('commonunit.delete');

	Route::get('/units', [UnitController::class, 'index'])->name('units');
	Route::get('/units/{unit}', [UnitController::class, 'show'])->name('unit.show');
	Route::post('/units', [UnitController::class, 'store'])->name('unit.store');
	Route::get('/unitRow', [UnitController::class, 'unitRow'])->name('unit.row');
	Route::post('/unitUpdate', [UnitController::class, 'update'])->name('unit.update');
	Route::delete('/units/{unit}', [UnitController::class, 'destroy'])->name('unit.delete');

	Route::post('/unitAssignment', [UnitAssingmentController::class, 'store'])->name('unitAssignment.store');
    Route::post('/commonUnitAssingment', [UnitAssingmentController::class, 'storeCommon'])->name('commonUnitAssingment.store');
	Route::post('/unitAssignmentDelete', [UnitAssingmentController::class, 'destroy'])->name('unitAssignment.delete');

	Route::get('/timetables', [TimetableInstanceController::class, 'index'])->name('timetables');
    Route::get('/examTimetables', [TimetableInstanceController::class, 'examindex'])->name('examTimetables');
	Route::get('/mytimetables', [TimetableInstanceController::class, 'myindex'])->name('mytimetables');
	Route::get('/timetables/{timetable}', [TimetableInstanceController::class, 'show'])->name('timetable.show');
	Route::get('/timetableRow', [TimetableInstanceController::class, 'timetableRow'])->name('timetable.row');
	Route::post('/timetables', [TimetableInstanceController::class, 'store'])->name('timetable.store');
	Route::delete('/TimetableDelete', [TimetableInstanceController::class, 'destroy'])->name('timetable.delete');

	Route::post('/groupPDF', [PDFController::class, 'groupPDF'])->name('groupPDF');
	Route::post('/individualPDF', [PDFController::class, 'individualPDF'])->name('individualPDF');
});
