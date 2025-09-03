<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\Destination;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{
    public function index()
    {
        $accommodations = Accommodation::with(['owner', 'destination'])->get();

        return view('admin.accommodations.index', compact('accommodations'));
    }

    public function create()
    {
        $destinations = Destination::all();
        return view('admin.accommodations.create', compact('destinations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:users,id',
            'dest_id' => 'required|exists:destinations,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'image_url' => 'nullable|string',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date|after:available_from',
        ]);

        Accommodation::create($validated);

        return redirect()->route('admin.accommodations.index')->with('success', 'Accommodation created successfully.');
    }

    public function edit(Accommodation $accommodation)
    {
        $destinations = Destination::all();
        return view('admin.accommodations.edit', compact('accommodation', 'destinations'));
    }

    public function update(Request $request, Accommodation $accommodation)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:users,id',
            'dest_id' => 'required|exists:destinations,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'image_url' => 'nullable|string',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date|after:available_from',
        ]);

        $accommodation->update($validated);

        return redirect()->route('admin.accommodations.index')->with('success', 'Accommodation updated successfully.');
    }

    public function destroy(Accommodation $accommodation)
    {
        $accommodation->delete();

        return redirect()->route('admin.accommodations.index')->with('success', 'Accommodation deleted successfully.');
    }
}
