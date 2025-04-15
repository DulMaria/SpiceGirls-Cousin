<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Ruta para la página principal
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news', [HomeController::class, 'Promociones'])->name('pag_visitante.news');
Route::get('/contacto', [HomeController::class, 'showContact'])->name('pag_visitante.contacto');
Route::get('/sobreNosotros', [HomeController::class, 'History'])->name('pag_visitante.sobreNosotros');

//Ruta de promociones y ofertas para el visitante
use App\Http\Controllers\PromocionController;

Route::get('/becasEstudiante', [PromocionController::class, 'mostrarBecas']);
Route::get('/ofertasEstudiante', [PromocionController::class, 'mostrarOfertas']);

//Ruta de areas para el visitante
use App\Http\Controllers\AreaController;
Route::get('/cursosUser', [AreaController::class, 'index'])->name('pag_visitante.cursosUser');


//Rutas para el administrador
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CursoController;

Route::prefix('administrador')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('administrador.prinAdmi');
    // Rutas para áreas
    Route::get('/areas', [AdminController::class, 'areas'])->name('admin.areas.index');
    Route::post('/areas/guardar', [AdminController::class, 'guardarArea'])->name('admin.areas.guardar');
    Route::get('/areas/editar/{id}', [AdminController::class, 'editar'])->name('admin.areas.editar');
    Route::put('/areas/actualizar/{id}', [AdminController::class, 'actualizar'])->name('admin.areas.actualizar');
    Route::get('/cursos', [CursoController::class, 'index'])->name('ruta.a.lista.de.cursos');

    // Ruta para mostrar el formulario de añadir curso
    Route::get('/cursos/crear', [CursoController::class, 'mostrarFormularioCurso'])->name('ruta.a.formulario.curso');
    // Ruta para almacenar el nuevo curso
    Route::post('/cursos', [CursoController::class, 'store'])->name('ruta.del.controlador');
    // Ruta para obtener los datos del curso a editar
    Route::get('/cursos/{id}/edit', [CursoController::class, 'edit'])->name('curso.edit');
    // Ruta para actualizar un curso
    Route::put('/cursos/{id}', [CursoController::class, 'update'])->name('curso.update');
    // Ruta para eliminar un curso
    Route::delete('/cursos/{id}', [CursoController::class, 'destroy'])->name('curso.destroy');
    // Agrega esta ruta
    Route::post('/administrador/cursos/{id}/cambiar-estado', [CursoController::class, 'cambiarEstado'])
        ->name('curso.cambiarEstado');

    //Ruta de cursos ascociados a un area, pero este por parte de visitante
    Route::get('/cursosUser/{id}', [CursoController::class, 'mostrarPorArea'])->name('pag_visitante.curso_asociado');
});
