<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $favorites = Auth::user()->favorites()
            ->with(['business.category', 'business.subArea', 'business.reviews'])
            ->latest()
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function store(Request $request, Business $business)
    {
        $user = Auth::user();

        // Check if already favorited
        if ($user->favorites()->where('business_id', $business->id)->exists()) {
            return back()->with('info', 'هذا المكان موجود في المفضلة بالفعل');
        }

        Favorite::create([
            'user_id' => $user->id,
            'business_id' => $business->id,
        ]);

        return back()->with('success', 'تم إضافة المكان إلى المفضلة بنجاح');
    }

    public function destroy(Business $business)
    {
        $user = Auth::user();

        $favorite = $user->favorites()->where('business_id', $business->id)->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'تم إزالة المكان من المفضلة');
        }

        return back()->with('info', 'هذا المكان غير موجود في المفضلة');
    }
}
