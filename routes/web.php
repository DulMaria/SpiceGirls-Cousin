<?php

use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\PromocionController;


// Ruta para la página principal
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news', [HomeController::class, 'Promociones'])->name('pag_visitante.news');
Route::get('/contacto', [HomeController::class, 'showContact'])->name('pag_visitante.contacto');
Route::get('/sobreNosotros', [HomeController::class, 'History'])->name('pag_visitante.sobreNosotros');
Route::get('/', [HomeController::class, 'totalCurso'])->name('home');
Route::get('/certificados', [HomeController::class, 'Certificaiones'])->name('pag_visitante.certificados');
//Ruta de promociones y ofertas para el visitante
Route::get('/becasEstudiante', [PromocionController::class, 'mostrarBecas']);
Route::get('/ofertasEstudiante', [PromocionController::class, 'mostrarOfertas']);
//Ruta de areas para el visitante
Route::get('/cursosUser', [AreaController::class, 'index'])->name('pag_visitante.cursosUser');

//Rutas de Logeo
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/verify-2fa', function () {return view('emails.auth.two-factor');})->name('verify-2fa');
Route::post('/verify-2fa', [AuthController::class, 'verify2fa'])->name('verify-2fa.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/2fa', [TwoFactorController::class, 'show'])->name('2fa.show');
Route::post('/2fa', [TwoFactorController::class, 'verify'])->name('2fa.verify');
Route::post('/2fa/resend', [TwoFactorController::class, 'resend'])->name('2fa.resend');
// // Mostrar formulario de "Olvidé mi contraseña"
// Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
// // Enviar el enlace de recuperación al correo del usuario
// Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
// // Mostrar formulario para restablecer la contraseña
// Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
// // Procesar el restablecimiento de la contraseña
// Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Rutas para el administrador con middleware auth y verificacion de 2 pasos
Route::prefix('administrador')->middleware(CheckRole::class . ':1')->group(function () {

    Route::get('/', [AdminController::class, 'dashboard'])->name('administrador.prinAdmi');

    // Rutas para áreas
    Route::get('/areas', [AdminController::class, 'areas'])->name('admin.areas.index');
    Route::post('/areas/guardar', [AdminController::class, 'guardarArea'])->name('admin.areas.guardar');
    Route::get('/areas/editar/{id}', [AdminController::class, 'editar'])->name('admin.areas.editar');
    Route::put('/areas/actualizar/{id}', [AdminController::class, 'actualizar'])->name('admin.areas.actualizar');

    //Ruta para Cursos
    Route::get('/cursos', [CursoController::class, 'index'])->name('ruta.a.lista.de.cursos');
    Route::get('/cursos/crear', [CursoController::class, 'mostrarFormularioCurso'])->name('ruta.a.formulario.curso');
    Route::post('/cursos', [CursoController::class, 'store'])->name('ruta.del.controlador');
    Route::get('/cursos/{id}/edit', [CursoController::class, 'edit'])->name('curso.edit');
    Route::put('/cursos/{id}', [CursoController::class, 'update'])->name('curso.update');
    Route::delete('/cursos/{id}', [CursoController::class, 'destroy'])->name('curso.destroy');
    Route::post('/administrador/cursos/{id}/cambiar-estado', [CursoController::class, 'cambiarEstado'])
        ->name('curso.cambiarEstado');
    Route::get('/curso_asociado/{id}', [CursoController::class, 'mostrarPorArea'])->name('pag_visitante.curso_asociado');

    // Rutas para docentes 
    Route::get('/docentes', [DocenteController::class, 'index'])->name('admin.docentes.index');
    Route::post('/docentes', [DocenteController::class, 'store'])->name('docentes.store');
    Route::get('/docentes/{codigoDocente}/{ID_Usuario}/edit', [DocenteController::class, 'edit'])->name('docentes.edit');
    Route::put('/docentes/{codigoDocente}', [DocenteController::class, 'update'])->name('docentes.update');
    Route::post('/docentes/{codigoDocente}/cambiar-estado', [DocenteController::class, 'cambiarEstado'])->name('docentes.cambiarEstado');

    // Rutas para Estudiantes
    Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('administrador.estudiantes.index');
    Route::post('/estudiantes', [EstudianteController::class, 'store'])->name('estudiantes.store');
    Route::get('/estudiantes/{codigoEstudiantil}/{ID_Usuario}/edit', [EstudianteController::class, 'edit'])->name('estudiantes.edit');
    Route::put('/estudiantes/{codigoEstudiantil}', [EstudianteController::class, 'update'])->name('estudiantes.update');
    Route::post('/estudiantes/{codigoEstudiantil}/cambiar-estado', [EstudianteController::class, 'cambiarEstado'])
    ->name('estudiantes.cambiarEstado');    

    // Rutas para promociones
    Route::get('/promociones', [PromocionController::class, 'index'])->name('administrador.promociones.index');
    Route::post('/promociones', [PromocionController::class, 'store'])->name('promocion.store');
    Route::post('/promociones/{id}/cambiar-estado', [PromocionController::class, 'cambiarEstado'])->name('promocion.cambiarEstado');
    Route::get('/promociones/{id}/edit', [PromocionController::class, 'edit'])->name('promocion.edit');
    Route::put('/promociones/{id}', [PromocionController::class, 'update'])->name('promocion.update');
    Route::get('/cursos-disponibles', [App\Http\Controllers\CursoController::class, 'getCursosDisponibles'])->name('cursos.disponibles');
});

// rutas para el administrador estadisticas
use App\Http\Controllers\EstadisticasController;
Route::get('/administrador', [EstadisticasController::class, 'index'])->name('administrador.prinAdmi');
