<?php

use Illuminate\Support\Facades\Route;

// routes/web.php
use App\Http\Controllers\AuthController;


use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\AdminController;
use App\Http\Controllers\SuperAdmin\RecentActivityController;
use App\Http\Controllers\SuperAdmin\PaymentController;


use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\StudentController;

use App\Http\Controllers\Teacher\DashboardController as TeacherDashboard;
use App\Http\Controllers\Teacher\StudentController as teacherStudentController;

Route::get('/', function () {
     return view('welcome');
});

// Public login
Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',  [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);


// Super-Admin protected
Route::prefix('superadmin')
     ->name('superadmin.')
     ->middleware(['auth', 'role:' . \App\Models\User::ROLE_SUPER_ADMIN])
     ->group(function () {
          Route::get('dashboard', [DashboardController::class, 'index'])
               ->name('dashboard');

          Route::get('admins', [AdminController::class, 'index'])
               ->name('admins.index');
          Route::post('admin/new', [AdminController::class, 'create'])
               ->name('admin.create');
          Route::put('admin/{id}', [AdminController::class, 'update'])
               ->name('admin.update');

          Route::get('payment', [PaymentController::class, 'index'])
               ->name('payment.index');

          Route::get('recent_activity', [RecentActivityController::class, 'index'])
               ->name('recent_activity.index');
});





 
Route::prefix('admin')
     ->name('admin.')
     ->middleware(['auth', 'role:' . \App\Models\User::ROLE_ADMIN])
     ->group(function () {
          Route::get('dashboard', [AdminDashboard::class, 'index'])
               ->name('dashboard');

            Route::get('teachers', [TeacherController::class, 'index'])
                  ->name('teacher.index');
            Route::post('teacher/new', [TeacherController::class, 'create'])
                  ->name('teacher.create');

            Route::get('students', [StudentController::class, 'index'])
                  ->name('student.index');
            Route::post('student/new', [StudentController::class, 'create'])
                  ->name('student.create');
            Route::post('student/update', [StudentController::class, 'update'])
                  ->name('student.update');
            Route::post('students/delete', [StudentController::class, 'destroy'])
                  ->name('student.delete');

            Route::post('student/assign/teacher', [StudentController::class, 'assignTeacher'])
                  ->name('student.assign-teacher');
            Route::post('student/remove/teacher', [StudentController::class, 'removeTeacher'])
                  ->name('student.remove-teacher');
});





 
Route::prefix('teacher')
     ->name('teacher.')
     ->middleware(['auth', 'role:' . \App\Models\User::ROLE_TEACHER])
     ->group(function () {
          Route::get('dashboard', [TeacherDashboard::class, 'index'])
               ->name('dashboard');

          Route::get('students', [teacherStudentController::class, 'studentsList'])
               ->name('students.index');



});
