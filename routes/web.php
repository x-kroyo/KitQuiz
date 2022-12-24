<?php

use App\Http\Controllers\AnswerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\GroupAttachmentController;
use App\Http\Middleware\Auth;
use App\Http\Middleware\CanViewGroup;
use App\Http\Middleware\CheckOwnGroup;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', [ UserController::class, 'login' ])->name('login');
Route::post('login', [ UserController::class, 'auth' ])->name('auth');

Route::get('signup', [ UserController::class, 'create' ])->name('signup');
Route::post('signup', [ UserController::class, 'store' ])->name('user.create');

Route::get('logout', [ UserController::class, 'logout' ])->name('logout')->middleware('auth');

Route::name('group.')->group(function() {

    Route::get('exams', [ GroupController::class, 'index' ])->name('index');

    Route::prefix('exam')->group(function() {

        Route::middleware('prof')->group(function () {
        
            Route::get('create', [ GroupController::class, 'create' ])->name('create');
            Route::post('create', [ GroupController::class, 'store' ])->name('store');
            
            Route::middleware(CheckOwnGroup::class)->group(function() {
                Route::get('delete/{id}', [ GroupController::class, 'delete' ])->name('delete');
                Route::get('edit/{id}', [ GroupController::class, 'edit' ])->name('edit');
                Route::post('edit/{id}', [ GroupController::class, 'update' ])->name('update');
                
                Route::get('{id}/answers', [ AnswerController::class, 'index' ])->name('answers');
                Route::get('{id}/members', [ MemberController::class, 'index' ])->name('members');
                Route::get('{id}/members/delete/{member}', [ MemberController::class, 'delete' ])->name('members.delete');
        
                Route::get('{id}/answer/download/{answer}', [ AnswerController::class, 'download' ])->name('answer.download');

                Route::get('{id}/attachment/delete/{file}', [ GroupAttachmentController::class, 'delete' ])->name('attachment.delete');
            });

        });


        Route::middleware('student')->group(function () {
            Route::get('join', [ MemberController::class, 'add' ])->name('member.add');
            Route::post('join', [ MemberController::class, 'store' ])->name('member.store');
            
            Route::post('{id}/response', [ AnswerController::class, 'store' ])->name('answer')->middleware(CanViewGroup::class);
            Route::get('{id}/response/undo', [ AnswerController::class, 'delete' ])->name('answer.delete');

        });


        Route::middleware(CanViewGroup::class)->group(function() {
            Route::get('{id}', [ GroupController::class, 'show' ])->name('show');
            Route::get('{id}/attachment/download/{attachment}', [ GroupAttachmentController::class, 'download' ])->name('attachment.download');
        });
    


    });

})->middleware(Auth::class);



Route::get('/', fn() => auth()->check() ? view('home.index') : view('home.welcome'))->name('home');
