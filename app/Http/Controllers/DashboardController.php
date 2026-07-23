<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\DrugInteraction;
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

        $totalChecks = DrugInteraction::query()->count();
        $savedInteractionsCount = 0;
        $majorInteractionsCount = DrugInteraction::query()
            ->whereHas('severity', fn ($query) => $query->where('slug', 'major')->orWhere('slug', 'contraindicated'))
            ->count();

        $recentChecks = DrugInteraction::query()
            ->with(['drugA', 'drugB', 'severity'])
            ->latest('updated_at')
            ->take(5)
            ->get()
            ->map(function (DrugInteraction $interaction, int $index) {
                $severity = $interaction->severity;

                return [
                    'id' => $interaction->id,
                    'pair' => trim($interaction->drugA->generic_name . ' + ' . $interaction->drugB->generic_name),
                    'severity_name' => $severity?->name ?? 'Unknown',
                    'severity_class' => $severity?->bootstrap_class ?? 'secondary',
                    'date' => optional($interaction->updated_at ?? $interaction->created_at)->format('M j, Y'),
                    'is_saved' => $index === 0,
                ];
            });

        $savedInteractions = $recentChecks->take(3)->map(function (array $check) {
            return [
                'pair' => $check['pair'],
                'severity_name' => $check['severity_name'],
                'severity_class' => $check['severity_class'],
                'saved_at' => now()->subDays(2)->format('M j, Y'),
            ];
        });

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
            'savedInteractionsCount' => $savedInteractionsCount,
            'majorInteractionsCount' => $majorInteractionsCount,
            'recentChecks' => $recentChecks,
            'savedInteractions' => $savedInteractions,
            'navigationItems' => $navigationItems,
            'drugs' => $drugs,
        ]);
    }
}
