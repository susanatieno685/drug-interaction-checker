<?php

use App\Models\Drug;
use App\Models\DrugInteraction;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DrugController;
use App\Http\Controllers\Admin\DrugInteractionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Requests\CheckInteractionRequest;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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

    if ($request->user()) {
        $request->user()->interactionChecks()->create([
            'drug_a_id' => $selectedDrugA->id,
            'drug_b_id' => $selectedDrugB->id,
            'drug_interaction_id' => $interaction?->id,
        ]);
    }

    if ($request->user()) {
        $result = [
            'interaction_id' => $interaction?->id,
            'message' => $message,
            'drug_a' => $selectedDrugA->generic_name,
            'drug_b' => $selectedDrugB->generic_name,
        ];

        if ($interaction) {
            $result['severity'] = $interaction->severity?->name;
            $result['clinical_effect'] = $interaction->clinical_effect;
            $result['mechanism'] = $interaction->mechanism;
            $result['management'] = $interaction->management;
            $result['monitoring_advice'] = $interaction->monitoring_advice;
            $result['evidence_level'] = $interaction->evidence_level;
            $result['reference'] = $interaction->reference;
        }

        return redirect()->route('dashboard')->with('interaction_result', $result);
    }

    return view('results.show', [
        'drugs' => $drugs,
        'interaction' => $interaction,
        'message' => $message,
        'selectedDrugA' => $selectedDrugA,
        'selectedDrugB' => $selectedDrugB,
    ]);
})->name('interaction.check');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->intended(route('dashboard').'?verified=1');
    })->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $key = 'email-verification:'.$request->user()->getKey();

        if (RateLimiter::tooManyAttempts($key, 6)) {
            return back()->withErrors([
                'email' => 'Please wait before requesting another verification email.',
            ]);
        }

        RateLimiter::hit($key, 60);
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::resource('drugs', DrugController::class)->except(['show']);
        Route::resource('interactions', DrugInteractionController::class);
    });
