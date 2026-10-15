<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();
        $drugs = Drug::query()
            ->where('is_active', true)
            ->orderBy('generic_name')
            ->get(['id', 'generic_name', 'brand_name']);

        $checks = $user->interactionChecks()
            ->with(['drugA', 'drugB', 'interaction.severity'])
            ->latest()
            ->get();

        $totalChecks = $checks->count();
        $majorInteractionsCount = $checks->filter(function ($check) {
            return in_array($check->interaction?->severity?->slug, ['major', 'contraindicated'], true);
        })->count();

        $recentChecks = $checks
            ->take(5)
            ->map(function ($check) {
                $severity = $check->interaction?->severity;

                return [
                    'id' => $check->id,
                    'pair' => trim($check->drugA->generic_name . ' + ' . $check->drugB->generic_name),
                    'severity_name' => $severity?->name ?? 'No match recorded',
                    'severity_class' => $severity?->bootstrap_class ?? 'secondary',
                    'date' => optional($check->created_at)->format('M j, Y'),
                ];
            });

        $savedInteractions = collect();

        $navigationItems = [
            ['label' => 'Dashboard', 'href' => route('dashboard')],
            ['label' => 'Check Interaction', 'href' => route('home') . '#checker'],
            ['label' => 'Search Medicines', 'href' => route('home') . '#checker'],
            ['label' => 'Saved Interactions', 'href' => '#saved-interactions'],
            ['label' => 'History', 'href' => '#recent-checks'],
            ['label' => 'Profile', 'href' => '#profile'],
            ['label' => 'Log Out', 'href' => route('logout')],
        ];

        return view('dashboard', [
            'user' => $user,
            'totalChecks' => $totalChecks,
            'savedInteractionsCount' => $savedInteractions->count(),
            'majorInteractionsCount' => $majorInteractionsCount,
            'recentChecks' => $recentChecks,
            'savedInteractions' => $savedInteractions,
            'navigationItems' => $navigationItems,
            'drugs' => $drugs,
            'interactionResult' => session('interaction_result'),
        ]);
    }
}
