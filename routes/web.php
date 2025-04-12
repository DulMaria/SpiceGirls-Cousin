<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Ruta para la página principal
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cursosUser', [HomeController::class, 'Cursos'])->name('pag_visitante.cursosUser');
Route::get('/news', [HomeController::class, 'Promociones'])->name('pag_visitante.news');
Route::get('/contacto', [HomeController::class, 'showContact'])->name('pag_visitante.contacto');
Route::get('/sobreNosotros', [HomeController::class, 'History'])->name('pag_visitante.sobreNosotros');

//Rutas para el administrador
use App\Http\Controllers\AdminController;
Route::prefix('administrador')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('administrador.prinAdmi'); 
    Route::get('/areas', [AdminController::class, 'areas'])->name('.areaIndex');
    Route::get('/cursos', [AdminController::class, 'cursos'])->name('administrador.cursos');
    Route::get('/docentes', [AdminController::class, 'docentes'])->name('administrador.docentes');
    Route::get('/estudiantes', [AdminController::class, 'estudiantes'])->name('administrador.estudiantes');
});
