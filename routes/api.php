<?php

use App\Http\Controllers\ShelfController;
use App\Http\Controllers\UserController;
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

Route::controller(UserController::class)->group(function () {

    // Get the details of the user
    Route::get('get_user/{id}', 'show');
    // Create the user in Database
    Route::post('create_user', 'store');
    // Soft delete the user
    Route::delete('delete_user/{id}', 'destroy');
    // Get all users in paginated manner
    Route::get('get_users', 'getAllUsers');

});

Route::controller(ShelfController::class)->group(function() {

    //get the details of the shelf
    Route::get('get_shelf/{id}', 'show');
    // give the book to the user and attach to his shelf
    Route::post('create_shelf', 'store');
    // give the book to the user and attach to his shelf
    Route::post('assign_book', 'assignBook');
    // get all shelves in paginated matter
    Route::get('get_shelves', 'getAllShelves');

});
