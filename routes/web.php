<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowBookController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Book routes
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');

Route::get('new-borrow/{user}/{book}', [BorrowBookController::class, 'new']);
Route::get('list-books/{user}', [BorrowBookController::class, 'listBooks']);
Route::get('delete-borrow/{user}/{book}', [BorrowBookController::class, 'delete']);

// ─── Rutas sistema de bicicletas ───

use App\Http\Controllers\EstacionController;
use App\Http\Controllers\BicicletaController;
use App\Http\Controllers\TrayectoController;
use App\Http\Controllers\UserController;

// Estaciones
Route::get('/estaciones', [EstacionController::class, 'index'])->name('estaciones.index');
Route::get('/estaciones/{id}', [EstacionController::class, 'show'])->name('estaciones.show');

// Bicicletas
Route::get('/bicicletas/{id}', [BicicletaController::class, 'show'])->name('bicicletas.show');

// Trayectos
Route::get('/trayectos/{user}', [TrayectoController::class, 'index'])->name('trayectos.index');
Route::post('/trayectos/iniciar', [TrayectoController::class, 'iniciar'])->name('trayectos.iniciar');
Route::post('/trayectos/{trayecto}/finalizar', [TrayectoController::class, 'finalizar'])->name('trayectos.finalizar');

// Usuarios
Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('users.show');
Route::post('/trayectos/{trayecto}/favorito', [TrayectoController::class, 'toggleFavorito'])->name('trayectos.favorito');
