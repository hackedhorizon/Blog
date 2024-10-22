<?php

use App\Livewire\AdminPanel\Dashboard;
use App\Livewire\AdminPanel\Posts\Create;
use App\Livewire\AdminPanel\Posts\Index as PostsIndex;
use App\Livewire\Home;
use App\Livewire\Posts\Index;
use App\Livewire\Posts\Show;
use App\Livewire\User\Settings;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['translate'])->group(function () {
    Route::get('/', Home::class)->name('home');
    Route::get('/posts', Index::class)->name('posts');
    Route::get('/posts/{id}', Show::class)->name('posts.show');
    Route::get('/settings', Settings::class)->name('guest.settings');
});

// routes/web.php

Route::middleware(['auth', 'admin', 'translate'])->prefix('admin/dashboard')->group(function () {
    // Admin Dashboard
    Route::get('/', Dashboard::class)->name('admin.dashboard');

    // Post Management
    Route::get('/posts/create', Create::class)->name('admin.dashboard.posts.create');
    Route::get('/posts/all', PostsIndex::class)->name('admin.dashboard.posts.table');
});

require __DIR__.'/auth.php';
