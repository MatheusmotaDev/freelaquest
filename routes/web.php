<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CommentController;


Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::resource('projects', ProjectController::class);

    Route::resource('expenses', ExpenseController::class)->only(['create', 'store']);

    Route::get('/projects/{project}/invoices/create', [InvoiceController::class, 'create'])->name('projects.invoices.create');
    Route::post('/projects/{project}/invoices', [InvoiceController::class, 'store'])->name('projects.invoices.store');

    Route::post('/invoices/{invoice}/pay', [InvoiceController::class, 'markAsPaid'])->name('invoices.pay');

    Route::get('/badges', function () {
        return view('badges.index', [
            'user' => Auth::user()->load('badges'),
            'allBadges' => App\Models\Badge::all()
        ]);
    })->middleware(['auth'])->name('badges.index');

    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

  
    Route::resource('clients', ClientController::class);


    Route::resource('quotes', QuoteController::class);
    Route::post('/quotes/{quote}/convert', [QuoteController::class, 'convert'])->name('quotes.convert');
    Route::post('/quotes/{quote}/reject', [QuoteController::class, 'reject'])->name('quotes.reject');

    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    Route::put('/goal/update', [GoalController::class, 'update'])->name('goal.update');
    Route::get('/goals', [GoalController::class, 'index'])->name('goals.index'); 
    Route::post('/goals', [GoalController::class, 'store'])->name('goals.store'); 
    Route::post('/goals/{goal}/complete', [GoalController::class, 'complete'])->name('goals.complete');
    Route::post('/goals/{goal}/archive', [GoalController::class, 'archive'])->name('goals.archive'); 

    Route::patch('/projects/{project}/status', [App\Http\Controllers\ProjectController::class, 'updateStatus'])->name('projects.update-status');

    Route::get('/projects/{project}/invoice', [App\Http\Controllers\ProjectController::class, 'invoice'])->name('projects.invoice');

    Route::resource('announcements', AnnouncementController::class)->only(['index', 'create', 'store']);

    Route::post('/announcements/{announcement}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::resource('announcements', App\Http\Controllers\AnnouncementController::class)->only(['index', 'create', 'store', 'destroy']);



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
