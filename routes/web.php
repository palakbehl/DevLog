<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;

Route::middleware('auth')->group(function(){ // This line defines a group of routes that require the user to be authenticated. The 'auth' middleware checks if the user is logged in before allowing access to any of the routes defined within this group. If the user is not authenticated, they will be redirected to the login page.
// group means a collection of routes that share the same middleware
// if user is not authenticated, they will be redirected to the login page , how ? , because the 'auth' middleware is applied to this group of routes, and it automatically handles the redirection to the login page for unauthenticated users.

    Route::resource(
        'posts',
        PostController::class
    );
       Route::resource('projects', ProjectController::class);
 
});

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [DashboardController::class, 'index']) // This line defines a route for the '/dashboard' URL. When a user visits this URL, the 'index' method of the 'DashboardController' will be executed. The 'index' method is responsible for handling the request and returning the appropriate response, which is typically a view that displays the dashboard to the user.
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
