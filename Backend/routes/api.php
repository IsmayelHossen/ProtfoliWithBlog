<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\adminHome;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [LoginController::class, 'login']);
Route::post('/registration', [LoginController::class, 'Register']);
Route::get('/getdata', [LoginController::class, 'Getdata']);

//chat api
Route::post('/message', [MessageController::class, 'message']);
Route::get('/getAllMsg', [MessageController::class, 'getAllMsg']);

//mail
Route::post('/mail', [MailController::class, 'Mail']);
//frontend controller
Route::get('/profileinfo', [FrontendController::class, 'profileinfo']);
Route::get('/getTechnologieData', [FrontendController::class, 'getTechnologieData']);
Route::get('/getProjectData', [FrontendController::class, 'getProjectData']);
Route::get('/geteducationalData', [FrontendController::class, 'geteducationalData']);
Route::get('/EducationalData', [FrontendController::class, 'EducationalData']);

//admin
Route::post('/profile', [adminHome::class, 'profile']);
//laravel formData not supported in put or patch mathod,same work done using post mathod
Route::post('/update_profile/{id}', [adminHome::class, 'update_profile']);
Route::delete('/delete_profileinfo/{id}', [adminHome::class, 'delete_profileinfo']);
// technology data entry
Route::post('/technologyadd', [adminHome::class, 'technologyadd']);
Route::put('/updateTechnologyData/{id}', [adminHome::class, 'updateTechnologyData']);
Route::delete('/deleteTechnologyData/{id}', [adminHome::class, 'deleteTechnologyData']);
//project data


Route::post('/projectadd', [adminHome::class, 'projectadd']);
Route::get('/getprojectData', [adminHome::class, 'getprojectData']);
Route::put('/updateProjectData/{id}', [adminHome::class, 'updateProjectData']);
Route::delete('/deleteProjectData/{id}', [adminHome::class, 'deleteProjectData']);
//
// about data

Route::get('/aboutData', [AboutController::class, 'aboutData']);
Route::post('/SaveaboutData', [AboutController::class, 'SaveaboutData']);
Route::post('/update_about/{id}', [AboutController::class, 'update_about']);
Route::delete('/delete_aboutinfo/{id}', [AboutController::class, 'delete_aboutinfo']);

//educational

Route::post('/saveeducational', [AboutController::class, 'saveeducational']);
Route::put('/updateEducationalData/{id}', [AboutController::class, 'updateEducationalData']);
Route::delete('/deleteEducationalData/{id}', [AboutController::class, 'deleteEducationalData']);
