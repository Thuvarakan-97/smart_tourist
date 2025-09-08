<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinations = Destination::all();
        return view('destinations.index', compact('destinations'));
    }

    /**
     * Discover places with district filtering
     */
    public function discover(Request $request)
    {
        $query = Destination::query();

        // Filter by district if provided
        if ($request->has('district') && $request->district) {
            $query->where('district', $request->district);
        }

        // Filter by search term if provided
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $destinations = $query->orderBy('rating', 'desc')->paginate(12);

        // Get all districts for filter dropdown
        $districts = Destination::select('district')
            ->whereNotNull('district')
            ->distinct()
            ->orderBy('district')
            ->pluck('district');

        return view('discover-places', compact('destinations', 'districts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only admins can create destinations
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('destinations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only admins can create destinations
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        Destination::create($validated);

        return redirect()->route('destinations.index')->with('success', 'Destination created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Destination $destination)
    {
        return view('destinations.show', compact('destination'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destination $destination)
    {
        // Only admins can edit destinations
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('destinations.edit', compact('destination'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Destination $destination)
    {
        // Only admins can update destinations
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $destination->update($validated);

        return redirect()->route('destinations.index')->with('success', 'Destination updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination)
    {
        // Only admins can delete destinations
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $destination->delete();

        return redirect()->route('destinations.index')->with('success', 'Destination deleted successfully.');
    }
}
