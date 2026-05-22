<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query();

        if ($request->filled('type')) {
            $query->where('property_type', $request->type);
        }
        if ($request->filled('location')) {
            $loc = $request->location;
            $query->where(function ($q) use ($loc) {
                $q->where('city', 'LIKE', "%{$loc}%")->orWhere('address', 'LIKE', "%{$loc}%");
            });
        }
        if ($request->filled('maxPrice')) {
            $query->where('price', '<=', $request->maxPrice);
        }

        $properties = $query->latest()->paginate(6)->withQueryString();
        return view('properties.index', compact('properties'));
    }

    public function show($id)
    {
        $property = Property::with(['agent', 'images'])->findOrFail($id);
        $isFavorited = auth()->check() ? auth()->user()->favorites()->where('property_id', $id)->exists() : false;
        $reservationFee = $property->price * 0.01;

        return view('properties.show', compact('property', 'isFavorited', 'reservationFee'));
    }

    public function create()
    {
        return view('properties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'property_type' => 'required',
            'price' => 'required|numeric',
            'featured_image' => 'required|url',
            'floor_area' => 'required|integer',
            'lot_area' => 'required|integer',
            'address' => 'required',
            'city' => 'required',
        ]);

        Property::create(array_merge($request->all(), [
            'agent_id' => auth()->id(),
            'status' => 'available'
        ]));

        return redirect()->route('dashboard')->with('success', 'Property listed successfully!');
    }

    public function edit($id)
    {
        $property = Property::findOrFail($id);
        if (auth()->user()->role !== 'admin' && auth()->id() !== $property->agent_id) {
            abort(403);
        }
        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        if (auth()->user()->role !== 'admin' && auth()->id() !== $property->agent_id) {
            abort(403);
        }

        $property->update($request->all());
        return redirect()->route('dashboard')->with('success', 'Property updated!');
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        if (auth()->user()->role !== 'admin' && auth()->id() !== $property->agent_id) {
            abort(403);
        }
        $property->delete();
        return back()->with('success', 'Property removed.');
    }
}