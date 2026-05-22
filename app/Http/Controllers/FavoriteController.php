<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::where('user_id', Auth::id())
            ->with('property.agent')
            ->latest()
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function toggle($propertyId)
    {
        $userId = Auth::id();
        $exists = Favorite::where('user_id', $userId)->where('property_id', $propertyId)->first();

        if ($exists) {
            $exists->delete();
            $msg = 'Removed from favorites.';
        } else {
            Favorite::create([
                'user_id' => $userId,
                'property_id' => $propertyId
            ]);
            $msg = 'Added to favorites.';
        }

        return back()->with('success', $msg);
    }
}