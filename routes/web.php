<?php

use App\Models\Drug;
use App\Models\DrugInteraction;
use App\Http\Requests\CheckInteractionRequest;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DrugInteractionController;
use App\Http\Controllers\Admin\DrugController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Services\DrugPairNormalizer;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $drugs = Drug::query()
        ->where('is_active', true)
        ->orderBy('generic_name')
        ->get(['id', 'generic_name', 'brand_name']);

    return view('home.copy', compact('drugs'));
})->name('home');

Route::post('/interaction-check', function (CheckInteractionRequest $request, DrugPairNormalizer $normalizer) {
    $drugs = Drug::query()
        ->where('is_active', true)
        ->orderBy('generic_name')
        ->get(['id', 'generic_name', 'brand_name']);

    $selectedDrugA = Drug::query()->findOrFail((int) $request->validated('drug_a_id'));
    $selectedDrugB = Drug::query()->findOrFail((int) $request->validated('drug_b_id'));

    [$drugAId, $drugBId] = $normalizer->normalize($selectedDrugA->id, $selectedDrugB->id);

    $interaction = DrugInteraction::query()
        ->with(['drugA', 'drugB', 'severity'])
        ->where('drug_a_id', $drugAId)
        ->where('drug_b_id', $drugBId)
        ->where('is_active', true)
        ->first();

    $message = $interaction
        ? null
        : "No interaction was found in this application's current database.";

    return view('results.show', [
        'drugs' => $drugs,
        'interaction' => $interaction,
        'message' => $message,
        'selectedDrugA' => $selectedDrugA,
        'selectedDrugB' => $selectedDrugB,
    ]);
})->name('interaction.check');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::resource('drugs', DrugController::class)->except(['show']);
        Route::resource('interactions', DrugInteractionController::class);
    });
