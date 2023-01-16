<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route register pelamar
Route::prefix('pelamar')->group(function(){

    //register
    Route::post('/register', [App\Http\Controllers\Api\Pelamar\PelamarController::class, 'register', ['as' => 'pelamar']]);

    //login
    Route::post('/login', [App\Http\Controllers\Api\Pelamar\PelamarController::class, 'login', ['as' => 'pelamar']]);

    //getPelamar
    Route::get('/data-pelamar', [App\Http\Controllers\Api\Pelamar\PelamarController::class, 'getUser', ['as' => 'pelamar']]);

    //refresh token
    Route::post('/refresh-token', [App\Http\Controllers\Api\Pelamar\PelamarController::class, 'refreshToken', ['as' => 'pelamar']]);

    //logout
    Route::post('/logout', [App\Http\Controllers\Api\Pelamar\PelamarController::class, 'logout', ['as' => 'pelamar']]);

    //add seleksi
    Route::post('/add-seleksi', [App\Http\Controllers\Api\Pelamar\SeleksiController::class, 'addSeleksi', ['as' => 'pelamar']]);

    //get seleksi by id pelamar
    Route::get('/get-seleksi/pelamar/{id}', [App\Http\Controllers\Api\Pelamar\SeleksiController::class, 'getSeleksiByIdPelamar', ['as' => 'pelamar']]);

    //checkRegistered
    Route::post('/check-registered', [App\Http\Controllers\Api\Pelamar\SeleksiController::class, 'checkRegistered', ['as' => 'pelamar']]);

    //detail seleksi
    Route::get('/detail-seleksi/{id}', [App\Http\Controllers\Api\Pelamar\SeleksiController::class, 'detailSeleksi', ['as' => 'pelamar']]);

    //delete seleksi
    Route::delete('/delete-seleksi/{id}', [App\Http\Controllers\Api\Pelamar\SeleksiController::class, 'deleteSeleksi', ['as' => 'pelamar']]);

    //get getInterviewWhereIdSeleksiByIdPelamar
    Route::get('/interview/{id}', [App\Http\Controllers\Api\Pelamar\InterviewController::class, 'getInterviewWhereIdSeleksiByIdPelamar', ['as' => 'pelamar']]);
});

//route for HRD
Route::prefix('hrd')->group(function(){

    //login
    Route::post('/login', [App\Http\Controllers\Api\HRD\HrdController::class, 'login', ['as' => 'hrd']]);

    //getHrd
    Route::get('/data-hrd', [App\Http\Controllers\Api\HRD\HrdController::class, 'getUser', ['as' => 'hrd']]);

    //refresh token
    Route::post('/refresh-token', [App\Http\Controllers\Api\HRD\HrdController::class, 'refreshToken', ['as' => 'hrd']]);

    //logout
    Route::post('/logout', [App\Http\Controllers\Api\HRD\HrdController::class, 'logout', ['as' => 'hrd']]);

    // add category
    Route::post('/add-category', [App\Http\Controllers\Api\HRD\CategoryController::class, 'addCategory', ['as' => 'hrd']]); 

    //edit category
    Route::post('/edit-category/{id}', [App\Http\Controllers\Api\HRD\CategoryController::class, 'editCategory', ['as' => 'hrd']]);

    //delete category
    Route::post('/delete-category/{id}', [App\Http\Controllers\Api\HRD\CategoryController::class, 'deleteCategory', ['as' => 'hrd']]);

    //get category by id
    Route::get('/get-category/{id}', [App\Http\Controllers\Api\HRD\CategoryController::class, 'getCategoryById', ['as' => 'hrd']]);

    //get category
    Route::get('/get-category', [App\Http\Controllers\Api\HRD\CategoryController::class, 'getCategory', ['as' => 'hrd']]);

    // add loker
    Route::post('/add-loker', [App\Http\Controllers\Api\HRD\LokerController::class, 'addLoker', ['as' => 'hrd']]);

    //get loker
    Route::get('/get-loker', [App\Http\Controllers\Api\HRD\LokerController::class, 'getLoker', ['as' => 'hrd']]);

    //get loker by id
    Route::get('/get-loker/{id}', [App\Http\Controllers\Api\HRD\LokerController::class, 'getLokerById', ['as' => 'hrd']]);

    //delete loker
    Route::post('/delete-loker/{id}', [App\Http\Controllers\Api\HRD\LokerController::class, 'deleteLoker', ['as' => 'hrd']]);

    //get loker status open
    Route::get('/get-loker/status/open', [App\Http\Controllers\Api\HRD\LokerController::class, 'getLokerStatusOpen', ['as' => 'hrd']]);

    //get loker by id category
    Route::get('/get-loker/category/{id}', [App\Http\Controllers\Api\HRD\LokerController::class, 'getLokerByIdCategory', ['as' => 'hrd']]);

    //update loker
    Route::post('/update-loker/{id}', [App\Http\Controllers\Api\HRD\LokerController::class, 'updateLoker', ['as' => 'hrd']]);

    //list seleksi
    Route::get('/list-seleksi', [App\Http\Controllers\Api\HRD\SeleksiController::class, 'listSeleksi', ['as' => 'hrd']]);

    //detail seleksi
    Route::get('/detail-seleksi/{id}', [App\Http\Controllers\Api\HRD\SeleksiController::class, 'detailSeleksi', ['as' => 'hrd']]);

    //getSeleksiByIdCategory
    Route::get('/get-seleksi/category/{id}', [App\Http\Controllers\Api\HRD\SeleksiController::class, 'getSeleksiWhereCategoryLoker', ['as' => 'hrd']]);

    //update seleksi    
    Route::post('/update-seleksi/{id}', [App\Http\Controllers\Api\HRD\SeleksiController::class, 'updateSeleksi', ['as' => 'hrd']]);

    //get seleksi by status
    Route::get('/get-seleksi/status/{status}', [App\Http\Controllers\Api\HRD\SeleksiController::class, 'getSeleksiByStatus', ['as' => 'hrd']]);

    //add interview
    Route::post('/add-interview', [App\Http\Controllers\Api\HRD\InterviewController::class, 'addInterview', ['as' => 'hrd']]);

    //update interview
    Route::post('/update-interview/{id}', [App\Http\Controllers\Api\HRD\InterviewController::class, 'updateInterview', ['as' => 'hrd']]);

    //delete interview
    Route::post('/delete-interview/{id}', [App\Http\Controllers\Api\HRD\InterviewController::class, 'deleteInterview', ['as' => 'hrd']]);

    //list interview
    Route::get('/list-interview', [App\Http\Controllers\Api\HRD\InterviewController::class, 'listInterview', ['as' => 'hrd']]);

    //detail interview
    Route::get('/detail-interview/{id}', [App\Http\Controllers\Api\HRD\InterviewController::class, 'detailInterview', ['as' => 'hrd']]);

    //checkPelamarInterview
    Route::get('/check-pelamar-interview/{id}', [App\Http\Controllers\Api\HRD\InterviewController::class, 'checkPelamarInterview', ['as' => 'hrd']]);
});





