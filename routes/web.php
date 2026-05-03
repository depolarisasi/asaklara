<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\Admin\ContactSubmissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TeamController;
use Illuminate\Support\Facades\Route;
use Spatie\ResponseCache\Middlewares\CacheResponse;
use Spatie\ResponseCache\Middlewares\DoNotCacheResponse;
use App\Http\Controllers\DesignController;

// =========================================
// PUBLIC ROUTES
// =========================================

// Halaman statis — di-cache (konten jarang berubah)
Route::middleware([CacheResponse::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/services', [ServicesController::class, 'index'])->name('services');
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
    Route::get('/design', [DesignController::class, 'index'])->name('design');
});

// Contact — TIDAK di-cache karena ada flash message & CSRF form
Route::middleware([DoNotCacheResponse::class])->group(function () {
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit')->middleware('throttle:5,1');
});

// =========================================
// ADMIN ROUTES
// =========================================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Portfolio
    Route::resource('portfolio', AdminPortfolioController::class)->except(['show']);
    Route::get('portfolio/trash', [AdminPortfolioController::class, 'trash'])->name('portfolio.trash');
    Route::patch('portfolio/{id}/restore', [AdminPortfolioController::class, 'restore'])->name('portfolio.restore');
    Route::delete('portfolio/{id}/force-delete', [AdminPortfolioController::class, 'forceDelete'])->name('portfolio.force-delete');

    // Team
    Route::resource('team', TeamController::class)->except(['show']);
    Route::get('team/trash', [TeamController::class, 'trash'])->name('team.trash');
    Route::patch('team/{id}/restore', [TeamController::class, 'restore'])->name('team.restore');
    Route::delete('team/{id}/force-delete', [TeamController::class, 'forceDelete'])->name('team.force-delete');

    // Services
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::get('services/trash', [ServiceController::class, 'trash'])->name('services.trash');
    Route::patch('services/{id}/restore', [ServiceController::class, 'restore'])->name('services.restore');
    Route::delete('services/{id}/force-delete', [ServiceController::class, 'forceDelete'])->name('services.force-delete');
    Route::post('process-steps', [ServiceController::class, 'storeProcessStep'])->name('process-steps.store');
    Route::put('process-steps/{processStep}', [ServiceController::class, 'updateProcessStep'])->name('process-steps.update');
    Route::delete('process-steps/{processStep}', [ServiceController::class, 'destroyProcessStep'])->name('process-steps.destroy');

    // Contact Submissions
    Route::get('submissions', [ContactSubmissionController::class, 'index'])->name('submissions.index');
    Route::get('submissions/{submission}', [ContactSubmissionController::class, 'show'])->name('submissions.show');
    Route::patch('submissions/{submission}/read', [ContactSubmissionController::class, 'markRead'])->name('submissions.read');
    Route::delete('submissions/{submission}', [ContactSubmissionController::class, 'destroy'])->name('submissions.destroy');

    // Clients
    Route::resource('clients', \App\Http\Controllers\Admin\ClientController::class)->except(['show']);
    Route::get('clients-trash', [\App\Http\Controllers\Admin\ClientController::class, 'trash'])->name('clients.trash');
    Route::patch('clients/{id}/restore', [\App\Http\Controllers\Admin\ClientController::class, 'restore'])->name('clients.restore');
    Route::delete('clients/{id}/force-delete', [\App\Http\Controllers\Admin\ClientController::class, 'forceDelete'])->name('clients.force-delete');

    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
});

require __DIR__ . '/auth.php';
