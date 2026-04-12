<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
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
}
