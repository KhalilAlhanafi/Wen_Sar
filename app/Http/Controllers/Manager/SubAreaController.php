<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\SubArea;
use App\Models\District;
use Illuminate\Http\Request;

class SubAreaController extends Controller
{
    public function index(Request $request)
    {
        $query = District::with(['subAreas' => function($query) {
            $query->withCount('businesses')->latest();
        }, 'governorate'])->whereHas('subAreas');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhereHas('governorate', function($qg) use ($search) {
                      $qg->where('name', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('subAreas', function($qs) use ($search) {
                      $qs->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $districts = $query->latest()->get();
        return view('manager.sub-areas.index', compact('districts'));
    }

    public function create(Request $request)
    {
        $governorates = \App\Models\Governorate::all();
        $governorate_id = $request->input('governorate_id');
        $districts = [];

        if ($governorate_id) {
            $districts = District::where('governorate_id', $governorate_id)->get();
        }

        return view('manager.sub-areas.create', compact('governorates', 'districts', 'governorate_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
        ]);

        SubArea::create($request->only(['name', 'district_id']));

        return redirect()->route('manager.sub-areas.index')->with('success', __('Sub-area created successfully.'));
    }

    public function edit(SubArea $subArea)
    {
        $districts = District::with('governorate')->get();
        return view('manager.sub-areas.edit', compact('subArea', 'districts'));
    }

    public function update(Request $request, SubArea $subArea)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
        ]);

        $subArea->update($request->only(['name', 'district_id']));

        return redirect()->route('manager.sub-areas.index')->with('success', __('Sub-area updated successfully.'));
    }

    public function destroy(SubArea $subArea)
    {
        // Check if sub-area has businesses
        if ($subArea->businesses()->count() > 0) {
            return back()->with('error', __('Cannot delete sub-area with businesses. Move or delete businesses first.'));
        }

        $subArea->delete();

        return redirect()->route('manager.sub-areas.index')->with('success', __('Sub-area deleted successfully.'));
    }
}
