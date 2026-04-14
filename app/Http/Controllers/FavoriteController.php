<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $favorites = $user->favorites()
            ->with(['category', 'subArea', 'reviews'])
            ->latest()
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Business $business)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        if ($user->favorites()->where('business_id', $business->id)->exists()) {
            $user->favorites()->detach($business->id);
            return response()->json(['status' => 'removed']);
        }
        $user->favorites()->attach($business->id);
        return response()->json(['status' => 'added']);
    }

    public function store(Business $business)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->favorites()->where('business_id', $business->id)->exists()) {
            return back()->with('info', 'هذا المكان موجود في المفضلة بالفعل');
        }

        $user->favorites()->attach($business->id);
        return back()->with('success', 'تم إضافة المكان إلى المفضلة بنجاح');
    }

    public function destroy(Business $business)
    {
        /** @var User $user */
        $user = Auth::user();

        $user->favorites()->detach($business->id);
        return back()->with('success', 'تم إزالة المكان من المفضلة');
    }
}
