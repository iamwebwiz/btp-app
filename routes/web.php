<?php

use App\Http\Controllers\FieldsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscribersController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::get('/', [SubscribersController::class, 'index']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/subscribers', [SubscribersController::class, 'index'])->name('subscribers.index');
    Route::get('/subscribers/create', [SubscribersController::class, 'create']);
    Route::get('/subscribers/{subscriber}', [SubscribersController::class, 'show']);

    Route::get('/fields', [FieldsController::class, 'index'])->name('fields.index');
    Route::get('/fields/create', [FieldsController::class, 'create']);
    Route::get('/fields/{field}', [FieldsController::class, 'show']);
});

require __DIR__ . '/auth.php';
