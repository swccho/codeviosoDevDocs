<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DocController as DashboardDocController;
use App\Http\Controllers\Public\DocController as PublicDocController;
use App\Http\Controllers\Public\HomeController;
use App\Models\Doc;
use Illuminate\Support\Facades\Route;

// ——— Public routes (no auth)
Route::get('/', HomeController::class)->name('home');
Route::get('/docs/{slug}', [PublicDocController::class, 'show'])->name('docs.show');

// ——— Auth routes (guest for login/register; auth for logout)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ——— Dashboard routes (auth middleware; policy enforced in controller)
Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', DashboardController::class)->name('index');
    Route::get('/docs', [DashboardDocController::class, 'index'])->name('docs.index');
    Route::get('/docs/create', [DashboardDocController::class, 'create'])->name('docs.create');
    Route::post('/docs', [DashboardDocController::class, 'store'])->name('docs.store');
    Route::get('/docs/{doc}/edit', [DashboardDocController::class, 'edit'])->name('docs.edit');
    Route::put('/docs/{doc}', [DashboardDocController::class, 'update'])->name('docs.update');
    Route::delete('/docs/{doc}', [DashboardDocController::class, 'destroy'])->name('docs.destroy');
    Route::post('/docs/{doc}/publish', [DashboardDocController::class, 'publish'])->name('docs.publish');
    Route::post('/docs/{doc}/unpublish', [DashboardDocController::class, 'unpublish'])->name('docs.unpublish');
});

// Dashboard {doc} binding: only current user's docs (404 if not owner)
Route::bind('doc', function (string $value) {
    $user = auth()->user();
    if (! $user) {
        abort(404);
    }
    return Doc::where('id', $value)->where('user_id', $user->id)->firstOrFail();
});

