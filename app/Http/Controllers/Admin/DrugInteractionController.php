<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDrugInteractionRequest;
use App\Http\Requests\UpdateDrugInteractionRequest;
use App\Models\Drug;
use App\Models\DrugInteraction;
use App\Models\InteractionSeverity;
use App\Services\DrugPairNormalizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DrugInteractionController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $severityId = $request->query('severity_id');

        $interactions = DrugInteraction::query()
            ->with(['drugA', 'drugB', 'severity'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($nestedQuery) use ($search) {
                    $nestedQuery->whereHas('drugA', function ($drugQuery) use ($search) {
                        $drugQuery->where('generic_name', 'like', "%{$search}%")
                            ->orWhere('brand_name', 'like', "%{$search}%");
                    })->orWhereHas('drugB', function ($drugQuery) use ($search) {
                        $drugQuery->where('generic_name', 'like', "%{$search}%")
                            ->orWhere('brand_name', 'like', "%{$search}%");
                    });
                });
            })
            ->when($severityId, function ($query) use ($severityId) {
                $query->where('interaction_severity_id', $severityId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $severities = InteractionSeverity::query()
            ->orderBy('priority')
            ->get(['id', 'name']);

        return view('admin.interactions.index', compact('interactions', 'search', 'severityId', 'severities'));
    }

    public function create(): View
    {
        $drugs = Drug::query()
            ->where('is_active', true)
            ->orderBy('generic_name')
            ->get(['id', 'generic_name', 'brand_name']);

        $severities = InteractionSeverity::query()
            ->orderBy('priority')
            ->get(['id', 'name', 'bootstrap_class']);

        return view('admin.interactions.create', compact('drugs', 'severities'));
    }

    public function store(StoreDrugInteractionRequest $request, DrugPairNormalizer $normalizer): RedirectResponse
    {
        $data = $request->validated();

        [$drugAId, $drugBId] = $normalizer->normalize((int) $data['drug_a_id'], (int) $data['drug_b_id']);

        DrugInteraction::create([
            'drug_a_id' => $drugAId,
            'drug_b_id' => $drugBId,
            'interaction_severity_id' => $data['interaction_severity_id'],
            'mechanism' => $data['mechanism'],
            'clinical_effect' => $data['clinical_effect'],
            'management' => $data['management'],
            'monitoring_advice' => $data['monitoring_advice'] ?? null,
            'evidence_level' => $data['evidence_level'] ?? null,
            'reference' => $data['reference'] ?? null,
            'notes' => $data['notes'] ?? null,
            'is_active' => $data['is_active'],
        ]);

        return redirect()
            ->route('admin.interactions.index')
            ->with('success', 'Interaction created successfully.');
    }

    public function show(DrugInteraction $interaction): View
    {
        $interaction->load(['drugA', 'drugB', 'severity']);

        return view('admin.interactions.show', compact('interaction'));
    }

    public function edit(DrugInteraction $interaction): View
    {
        $interaction->load(['drugA', 'drugB', 'severity']);

        $drugs = Drug::query()
            ->where('is_active', true)
            ->orderBy('generic_name')
            ->get(['id', 'generic_name', 'brand_name']);

        $severities = InteractionSeverity::query()
            ->orderBy('priority')
            ->get(['id', 'name', 'bootstrap_class']);

        return view('admin.interactions.edit', compact('interaction', 'drugs', 'severities'));
    }

    public function update(UpdateDrugInteractionRequest $request, DrugInteraction $interaction, DrugPairNormalizer $normalizer): RedirectResponse
    {
        $data = $request->validated();

        [$drugAId, $drugBId] = $normalizer->normalize((int) $data['drug_a_id'], (int) $data['drug_b_id']);

        $interaction->update([
            'drug_a_id' => $drugAId,
            'drug_b_id' => $drugBId,
            'interaction_severity_id' => $data['interaction_severity_id'],
            'mechanism' => $data['mechanism'],
            'clinical_effect' => $data['clinical_effect'],
            'management' => $data['management'],
            'monitoring_advice' => $data['monitoring_advice'] ?? null,
            'evidence_level' => $data['evidence_level'] ?? null,
            'reference' => $data['reference'] ?? null,
            'notes' => $data['notes'] ?? null,
            'is_active' => $data['is_active'],
        ]);

        return redirect()
            ->route('admin.interactions.index')
            ->with('success', 'Interaction updated successfully.');
    }

    public function destroy(DrugInteraction $interaction): RedirectResponse
    {
        $interaction->delete();

        return redirect()
            ->route('admin.interactions.index')
            ->with('success', 'Interaction deleted successfully.');
    }
}
