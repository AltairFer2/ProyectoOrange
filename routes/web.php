<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\OrangeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [OrangeController::class, 'index'])->name('home');
Route::get('/blog', [OrangeController::class, 'blog'])->name('blog');
Route::get('/admin/posts', [PostController::class, 'index'])->name('admin.posts.index');
Route::get('/admin/posts/add', [PostController::class, 'add'])->name('admin.posts.add');

Route::post('/admin/posts/add', [PostController::class, 'store']);
Route::get('/blog', [BlogController::class, 'index'])->name('orange.blog');
Route::delete('/blog/{no_post}', [BlogController::class, 'destroy'])->name('blog.destroy');

// Ruta para mostrar el formulario de edición
Route::get('/admin/posts/edit/{no_post}', [BlogController::class, 'edit'])->name('admin.posts.edit');

// Asegúrate de cambiar a PATCH si eso es lo que deseas
Route::patch('/admin/posts/update/{no_post}', [BlogController::class, 'update'])->name('admin.posts.update');