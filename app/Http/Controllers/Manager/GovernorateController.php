<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Governorate;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{
    public function index()
    {
        $governorates = Governorate::withCount('districts')->latest()->paginate(20);
        return view('manager.governorates.index', compact('governorates'));
    }

    public function create()
    {
        return view('manager.governorates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:governorates',
        ]);

        Governorate::create($request->only('name'));

        return redirect()->route('manager.governorates.index')->with('success', __('Governorate created successfully.'));
    }

    public function edit(Governorate $governorate)
    {
        return view('manager.governorates.edit', compact('governorate'));
    }

    public function update(Request $request, Governorate $governorate)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:governorates,name,' . $governorate->id,
        ]);

        $governorate->update($request->only('name'));

        return redirect()->route('manager.governorates.index')->with('success', __('Governorate updated successfully.'));
    }

    public function destroy(Governorate $governorate)
    {
        // Check if governorate has districts
        if ($governorate->districts()->count() > 0) {
            return back()->with('error', __('Cannot delete governorate with districts. Delete districts first.'));
        }

        $governorate->delete();

        return redirect()->route('manager.governorates.index')->with('success', __('Governorate deleted successfully.'));
    }
}
