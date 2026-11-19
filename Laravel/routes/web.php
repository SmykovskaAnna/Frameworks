
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExhibitController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ExhibitionExhibitController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('exhibits', ExhibitController::class);
Route::resource('exhibitions', ExhibitionController::class);
Route::resource('visitors', VisitorController::class);
Route::resource('tickets', TicketController::class);
Route::resource('exhibition-exhibits', ExhibitionExhibitController::class);
