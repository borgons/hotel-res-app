<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\GuestController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ResHeadDetController;

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

Route::middleware('cors')->group(function(){
    
    //======PUBLIC ROUTES
    Route::post('/guest', [GuestController::class, 'store']);
    Route::post('/resDetail', [ResHeadDetController::class, 'store']);
    //AUTH
    Route::post('/register', [AuthController::class, 'register']); 
    Route::post('/login', [AuthController::class, 'login']); 

    //====PRIVATE ROUTES
    //Protected Group
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::get('/room/{id}', [RoomController::class, 'show']);
    Route::get('/room/reserve/{rmNo}', [RoomController::class, 'rmReserve']);
    Route::get('/room/search/{rmNo}', [RoomController::class, 'search']);
    Route::post('/room', [RoomController::class, 'store']);
    Route::delete('/room/{id}', [RoomController::class, 'destroy']);
    Route::put('/room/{id}', [RoomController::class, 'update']);

    Route::get('/guests', [GuestController::class, 'index']);
    Route::delete('/guest/{id}', [GuestController::class, 'destroy']);
    Route::get('/guest/{id}', [GuestController::class, 'show']);
    Route::put('/guest/{id}', [GuestController::class, 'update']);

    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employee', [EmployeeController::class, 'store']);
    Route::delete('/employee/{id}', [EmployeeController::class, 'destroy']);
    Route::get('/employee/{id}', [EmployeeController::class, 'show']);
    Route::put('/employee/{id}', [EmployeeController::class, 'update']);

    Route::get('/resDetails', [ResHeadDetController::class, 'index']);
    Route::get('/resDetails/AllGuest', [ResHeadDetController::class, 'AllGuest']);
    Route::get('/resDetails/srchRoom/{rmNo}', [ResHeadDetController::class, 'srchRoom']);
    Route::get('/resDetails/guestDetail/{resDetailGuestID}', [ResHeadDetController::class, 'showSingleGuests']);
    Route::post('/resDetails/srchGuest/{guestID}', [ResHeadDetController::class, 'srchGuest']);
    Route::put('/resDetails/checkOut/{resDetailGuestID}', [ResHeadDetController::class, 'guestChkOut']);
    
    Route::post('/logout', [AuthController::class, 'logout']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/resDetails/{resDetNum}', [EmployeeController::class, 'showDetail']);