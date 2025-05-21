<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\C_Discover;
use App\Http\Controllers\C_Search;
use App\Http\Controllers\C_Game;

Route::get('/', [C_Discover::class, 'index'])->name('discover');
Route::get('/discover', [C_Discover::class, 'index'])->name('discover');
Route::get('/search', [C_Search::class, 'index'])->name('search');

Route::resource('games', C_Game::class)->except(['show']);
Route::delete('/game-images/{image}', [C_Game::class, 'destroyImage'])
     ->name('game-images.destroy');

/*
Route::get('/games/create', [C_Game::class, 'create'])->name('games.create');
Route::post('/games', [C_Game::class, 'store'])->name('games.store');
Route::resource('games', C_Game::class);
Route::get('/games/{game}/edit', [C_Game::class, 'edit'])->name('games.edit');
Route::put('/games/{game}', [C_Game::class, 'update'])->name('games.update');
Route::delete('/games/{game}', [C_Game::class, 'destroy'])->name('games.destroy');
Route::delete('/game-images/{image}', [C_Game::class, 'destroyImage'])->name('game-images.destroy');
*/
