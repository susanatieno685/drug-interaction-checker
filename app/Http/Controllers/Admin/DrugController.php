<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDrugRequest;
use App\Http\Requests\UpdateDrugRequest;
use App\Models\Drug;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DrugController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $drugs = Drug::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($nestedQuery) use ($search) {
                    $nestedQuery->where('generic_name', 'like', "%{$search}%")
                        ->orWhere('brand_name', 'like', "%{$search}%");
                });
            })
            ->orderBy('generic_name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.drugs.index', compact('drugs', 'search'));
    }

    public function create(): View
    {
        return view('admin.drugs.create');
    }

    public function store(StoreDrugRequest $request): RedirectResponse
    {
        Drug::create($request->validated());

        return redirect()
            ->route('admin.drugs.index')
            ->with('success', 'Drug created successfully.');
    }

    public function edit(Drug $drug): View
    {
        return view('admin.drugs.edit', compact('drug'));
    }

    public function update(UpdateDrugRequest $request, Drug $drug): RedirectResponse
    {
        $drug->update($request->validated());

        return redirect()
            ->route('admin.drugs.index')
            ->with('success', 'Drug updated successfully.');
    }

    public function destroy(Drug $drug): RedirectResponse
    {
        if ($drug->isReferencedByAnyInteraction()) {
            return redirect()
                ->route('admin.drugs.index')
                ->with('warning', 'This drug is used in one or more interactions. Deactivate it instead of deleting it.');
        }

        $drug->delete();

        return redirect()
            ->route('admin.drugs.index')
            ->with('success', 'Drug deleted successfully.');
    }
}
