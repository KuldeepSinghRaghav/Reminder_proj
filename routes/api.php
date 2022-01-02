<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\ForgotPassword;
use App\Http\Controllers\ReminderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('login',[ApiController::class,'authenticate']);
Route::post('register', [ApiController::class, 'register']);
Route::post('reset_password_link',[NewPasswordController::class,'forgotPassword']);

Route::get('/get_reset_token',[NewPasswordController::class,'resetToken']);
Route::post('reset_password',[NewPasswordController::class,'reset']);




Route::group(['middleware' => ['jwt.verify']], function() 
{ 
  Route::get('reminder_dropdown_data',[ReminderController::class,'datafordropdown']);
  Route::post('create_reminder',[ReminderController::class,'createreminder']);
  Route::get('get_reminder',[ReminderController::class,'getreminder']);
  Route::get('view_reminder/{id}',[ReminderController::class,'viewReminderUpdatePageStatus']);
  Route::put('update_reminder',[ReminderController::class,'updatereminder']);
  Route::delete('delete_reminder/{id}',[ReminderController::class,'deletereminder']);
  Route::post('find_reminder',[ReminderController::class,'searchByDate']);

  Route::get('find_open_reminder',[ReminderController::class,'allopendata']);
  Route::get('find_close_reminder',[ReminderController::class,'allclosedata']);


  
  Route::delete('delete_selected',[ReminderController::class,'selectDataDelete']);
  Route::delete('delete_completed',[ReminderController::class,'deletedAllCompleted']);
});