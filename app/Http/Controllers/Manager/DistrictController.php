<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Governorate;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        $query = District::with(['governorate'])->withCount(['subAreas', 'businesses']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('governorate', function($qg) use ($search) {
                      $qg->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $districts = $query->latest()->paginate(20)->withQueryString();
        return view('manager.districts.index', compact('districts'));
    }

    public function create()
    {
        $governorates = Governorate::all();
        return view('manager.districts.create', compact('governorates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'governorate_id' => 'required|exists:governorates,id',
        ]);

        District::create($request->only(['name', 'governorate_id']));

        return redirect()->route('manager.districts.index')->with('success', __('District created successfully.'));
    }

    public function edit(District $district)
    {
        $governorates = Governorate::all();
        return view('manager.districts.edit', compact('district', 'governorates'));
    }

    public function update(Request $request, District $district)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'governorate_id' => 'required|exists:governorates,id',
        ]);

        $district->update($request->only(['name', 'governorate_id']));

        return redirect()->route('manager.districts.index')->with('success', __('District updated successfully.'));
    }

    public function destroy(District $district)
    {
        // Check if district has sub-areas
        if ($district->subAreas()->count() > 0) {
            return back()->with('error', __('Cannot delete district with sub-areas. Delete sub-areas first.'));
        }

        // Check if district has businesses
        if ($district->businesses()->count() > 0) {
            return back()->with('error', __('Cannot delete district with businesses. Move or delete businesses first.'));
        }

        $district->delete();

        return redirect()->route('manager.districts.index')->with('success', __('District deleted successfully.'));
    }
}
