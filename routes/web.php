<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\C_Discover;
use App\Http\Controllers\C_Search;
use App\Http\Controllers\C_Game;

Route::get('/', [C_Discover::class, 'index'])->name('discover');
Route::get('/discover', [C_Discover::class, 'index'])->name('discover');
Route::get('/search', [C_Search::class, 'index'])->name('search');

Route::get('/games/create', [C_Game::class, 'create'])->name('games.create');
Route::post('/games', [C_Game::class, 'store'])->name('games.store');
