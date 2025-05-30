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
use App\Http\Controllers\Admin\SubjectController;

use App\Http\Controllers\Teacher\DashboardController as TeacherDashboard;
use App\Http\Controllers\Teacher\StudentController as teacherStudentController;
use App\Http\Controllers\Teacher\ClassController as teacherClassController;

use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Student\ClassController as studentClassController;

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
            Route::post('admin/delete', [AdminController::class, 'delete'])
                  ->name('admin.delete');

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
            Route::get('request', [AdminDashboard::class, 'ReqComp'])
                  ->name('request.index');
            Route::post('request/{id}/complete', [AdminDashboard::class, 'completeRequest'])->name('admin.request.complete');
            Route::post('request/{id}/cancel', [AdminDashboard::class, 'cancelRequest'])->name('admin.request.cancel');
            Route::get('request/{id}/view', [AdminDashboard::class, 'viewRequest'])->name('admin.request.view');


            Route::get('teachers', [TeacherController::class, 'index'])
                  ->name('teacher.index');
            Route::post('teacher/new', [TeacherController::class, 'create'])
                  ->name('teacher.create');
            Route::post('teacher/update', [TeacherController::class, 'update'])
                  ->name('teacher.update');
            Route::post('teacher/delete', [TeacherController::class, 'destroy'])
                  ->name('teacher.delete');
            Route::post('teacher/assign-subject', [TeacherController::class, 'assignSubject'])
                  ->name('teacher.assign-subject');
            Route::post('teacher/remove-subject', [TeacherController::class, 'removeSubject'])
                  ->name('teacher.remove-subject');



            Route::get('students', [StudentController::class, 'index'])
                  ->name('student.index');
            Route::post('student/new', [StudentController::class, 'create'])
                  ->name('student.create');
            Route::post('student/update', [StudentController::class, 'update'])
                  ->name('student.update');
            Route::post('students/delete', [StudentController::class, 'destroy'])
                  ->name('student.delete');
            Route::post('student/assign-subject', [StudentController::class, 'assignSubject'])
                  ->name('student.assign-subject');
            Route::post('student/remove-subject', [StudentController::class, 'removeSubject'])
                  ->name('student.remove-subject');
            Route::post('admin/student/subjects', [StudentController::class, 'getSubjectsForStudent'])->name('student.subjects');



            Route::post('student/assign/teacher', [StudentController::class, 'assignTeacher'])
                  ->name('student.assign-teacher');
            Route::post('student/remove/teacher', [StudentController::class, 'removeTeacher'])
                  ->name('student.remove-teacher');

            Route::get('subjects', [SubjectController::class, 'index'])
                  ->name('subject.index');
            Route::post('subject/new', [SubjectController::class, 'create'])
                  ->name('subject.create');
            Route::post('subject/update', [SubjectController::class, 'update'])
                  ->name('subject.update');
            Route::post('subject/delete', [SubjectController::class, 'destroy'])
                  ->name('subject.delete');




      });






Route::prefix('teacher')
      ->name('teacher.')
      ->middleware(['auth', 'role:' . \App\Models\User::ROLE_TEACHER])
      ->group(function () {
            Route::get('dashboard', [TeacherDashboard::class, 'index'])
                  ->name('dashboard');

            Route::get('students', [teacherStudentController::class, 'studentsList'])
                  ->name('students.index');
            Route::post('student/assign-class', [teacherStudentController::class, 'assignClass'])
                  ->name('student.assign-class');
            Route::post('student/assign-class', [teacherStudentController::class, 'assignClass'])
                  ->name('student.assign-class');
            Route::post('student/remove-class', [teacherStudentController::class, 'removeClass'])
                  ->name('student.remove-class');
            Route::get('class', [teacherClassController::class, 'classList'])
                  ->name('class.index');
            Route::post('request/send', [TeacherDashboard::class, 'storeReqComp'])
                  ->name('request.store');

            Route::post('/class/{id}/start', [teacherClassController::class, 'startClass'])->name('class.start');
            
      });
Route::get('/webrtc/class/{code}', [teacherClassController::class, 'webrtcRoom']);



Route::prefix('student')
      ->name('student.')
      ->middleware(['auth', 'role:' . \App\Models\User::ROLE_STUDENT])
      ->group(function () {
            Route::get('dashboard', [StudentDashboard::class, 'index'])
                  ->name('dashboard');
            Route::get('class', [studentClassController::class, 'classList'])
                  ->name('class.index');
            Route::post('request/send', [TeacherDashboard::class, 'storeReqComp'])
                  ->name('request.store');
      });
