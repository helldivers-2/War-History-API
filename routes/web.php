<?php

use App\Http\Controllers\Api\PlanetStatusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return "This service is for API requests only. Contact helldivers@kejax.net for further information<br>This Service is not endorsed by, neither affiliated with Arrow Games Studios or Playstation Studios in any way";
});


