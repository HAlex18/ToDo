<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\FolderController;
use App\Http\Controllers\ToDoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Folder;
use App\Models\Todo;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route to Home
Auth::routes();

Route::group([ 'middleware' => 'auth'], function(){

  Route::get('/', [ToDoController::class, 'index']);

  Route::get('/index', [ToDoController::class, 'index'])->name('index');
  Route::get('/folders/{id}/todos', [ToDoController::class, 'selectFolders'])->name('select_folders');

  //Folders
  Route::get('/users/{user}/folders/create', [FolderController::class, 'showCreateForm'])->name('create_form');
  Route::post('/users/{user}/folders/create', [FolderController::class, 'create'])->name('folders_create');
  Route::post('/users/{user}/folders/{id}', [FolderController::class, 'delete'])->name('folders_delete');

  //ToDos
  Route::get('/folders/{id}/todos/create', [ToDoController::class, 'showCreateForm'])->name('todos_create_form');
  Route::post('/folders/{id}/todos/create', [ToDoController::class, 'create'])->name('todos_create');
  Route::get('/todos/{id}', [ToDoController::class, 'showEditForm'])->name('todos_edit_form');
  Route::post('/todos/{id}/edit', [ToDoController::class, 'edit'])->name('todos_edit');
  Route::post('/todos/{id}/delete', [ToDoController::class, 'delete'])->name('todos_delete');

});