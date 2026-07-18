<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\Models\DrugInteraction;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $totalDrugs = Drug::count();
        $totalInteractions = DrugInteraction::count();
        $activeInteractions = DrugInteraction::where('is_active', true)->count();
        $totalUsers = User::count();
        $recentInteractions = DrugInteraction::query()
            ->with(['drugA', 'drugB', 'severity'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalDrugs',
            'totalInteractions',
            'activeInteractions',
            'totalUsers',
            'recentInteractions'
        ));
    }
}
