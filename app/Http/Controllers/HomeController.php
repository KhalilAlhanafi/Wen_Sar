<?php

namespace App\Http\Controllers;

use App\Models\Governorate;
use App\Models\Category;
use App\Models\Business;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $governorates = Governorate::with('districts')->get();
        $categories = Category::whereNull('parent_id')->get();
        $featuredBusinesses = Business::where('is_featured', true)
            ->with(['category', 'subArea'])
            ->orderBy('featured_rank')
            ->take(6)
            ->get();

        return view('home', compact('governorates', 'categories', 'featuredBusinesses'));
    }
}
