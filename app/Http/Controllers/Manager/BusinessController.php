<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Category;
use App\Models\District;
use App\Models\SubArea;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        $query = Business::where('status', 'approved')
            ->with(['owner', 'category', 'district', 'subArea', 'approvedBy']);

        // Filter by search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by district
        if ($request->has('district_id') && $request->district_id) {
            $query->where('district_id', $request->district_id);
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by contract status
        if ($request->has('contract_status')) {
            switch ($request->contract_status) {
                case 'active':
                    $query->where('contract_ends_at', '>', now());
                    break;
                case 'expired':
                    $query->where('contract_ends_at', '<=', now());
                    break;
                case 'expiring_soon':
                    $query->where('contract_ends_at', '<=', now()->addDays(3))
                          ->where('contract_ends_at', '>=', now());
                    break;
            }
        }

        $businesses = $query->latest()->paginate(20);
        $categories = Category::all();
        $districts = District::all();

        return view('manager.businesses.index', compact('businesses', 'categories', 'districts'));
    }

    public function show(Business $business)
    {
        $business->load(['owner', 'category', 'district', 'subArea', 'approvedBy']);
        return view('manager.businesses.show', compact('business'));
    }

    public function edit(Business $business)
    {
        $categories = Category::all();
        $districts = District::with('subAreas')->get();
        $subAreas = SubArea::where('district_id', $business->district_id)->get();

        return view('manager.businesses.edit', compact('business', 'categories', 'districts', 'subAreas'));
    }

    public function update(Request $request, Business $business)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'english_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'district_id' => 'required|exists:districts,id',
            'sub_area_id' => 'nullable|exists:sub_areas,id',
            'category_id' => 'required|exists:categories,id',
            'phone' => 'required|string',
            'opening_time' => 'nullable|date_format:H:i',
            'closing_time' => 'nullable|date_format:H:i',
            'address' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);

        $business->update($validated);

        return redirect()->route('manager.businesses.index')->with('success', __('Business updated successfully.'));
    }

    public function destroy(Business $business)
    {
        // Delete associated images
        if ($business->logo) {
            \Storage::disk('public')->delete($business->logo);
        }
        if ($business->images) {
            foreach ($business->images as $image) {
                \Storage::disk('public')->delete($image);
            }
        }

        $business->delete();

        return redirect()->route('manager.businesses.index')->with('success', __('Business deleted successfully.'));
    }
}
