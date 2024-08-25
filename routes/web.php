<?php

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaptopController;
use App\Http\Controllers\AssignDetailsController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/download-assign-details-pdf/{id}', [AssignDetailsController::class, 'downloadPdf'])->name('download.assign.details.pdf');
Route::get('/view-assign-details/{id}', [AssignDetailsController::class, 'view'])->name('view.assign.details');
