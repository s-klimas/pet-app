<?php

use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PetController::class, 'index'])->name('home');
Route::get('/addPet', [PetController::class, 'addPetForm'])->name('pet.add.form');
Route::post('/addPet', [PetController::class, 'addPet'])->name('pet.add');
Route::get('/pet/{id}', [PetController::class, 'getPet'])->name('pet.get');
Route::put('/pet/{id}', [PetController::class, 'updatePet'])->name('pet.update');
Route::delete('/pet/{id}', [PetController::class, 'deletePet'])->name('pet.delete');
