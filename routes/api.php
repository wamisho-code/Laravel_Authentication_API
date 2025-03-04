<?php

use App\Http\Controllers\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthManager::class,"login"]);
Route::post('/register', [AuthManager::class, "register"]);
Route::post("/list", [AuthManager::class,"list"]);