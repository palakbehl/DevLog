<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\ProjectApiController;

Route::apiResource('posts', PostApiController::class);

Route::apiResource('projects', ProjectApiController::class); // This line defines a set of API routes for the 'projects' resource, which will be handled by the 'ProjectApiController'. The 'apiResource' method automatically generates routes for standard CRUD operations (Create, Read, Update, Delete) for the 'projects' resource. These routes will be prefixed with '/api/projects' and will respond to HTTP requests such as GET, POST, PUT/PATCH, and DELETE.