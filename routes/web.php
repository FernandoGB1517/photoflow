<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomeController::class)->name('home');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

//Rutas para el perfil  //subirlo aqui por el get/{user:username}
Route::get('/editar-perfil',[PerfilController::class, 'index'])->name('perfil.index');
Route::post('/editar-perfil',[PerfilController::class, 'store'])->name('perfil.store');

//Rutas de administrador
Route::get('/admin/{user:username}', [AdminController::class, 'index'])->name('admin.index');
Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
Route::get('/admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
Route::put('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
Route::get('/admin/users/{user}/ver', [AdminController::class, 'show'])->name('admin.users.show');
Route::get('/admin/users/create', [AdminController::class, 'create'])->name('admin.users.create');
Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');
Route::get('/admin/users/filtrar', [AdminController::class, 'filtrar'])->name('admin.users.filtrar');

Route::get('/posts/create',[PostController::class, 'create'])->name('posts.create');
Route::post('/posts',[PostController::class, 'store'])->name('posts.store');
Route::get('/{user:username}/posts/{post}',[PostController::class, 'show'])->name('posts.show');
Route::delete('/post/{post}',[PostController::class, 'destroy'])->name('posts.destroy');

Route::post('/{user:username}/posts/{post}',[ComentarioController::class, 'store'])->name('comentarios.store');

Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

// Like a las fotos
Route::post('/posts/{posts}/likes', [LikeController::class, 'store'])->name('posts.likes.store');
Route::delete('/posts/{posts}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');

//esto al final 
Route::get('/{user:username}',[PostController::class, 'index'])->name('posts.index');

//Siguiendo usuarios
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');

// Rutas para las comunidades, provincias y localidades
Route::get('/provincias/{comunidadId}', [LocationController::class, 'getProvincias']);
Route::get('/localidades/{provinciaId}', [LocationController::class, 'getLocalidades']);

