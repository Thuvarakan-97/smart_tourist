<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // If user is admin or tourist, show all vehicles
        if ($user->role === 'admin' || $user->role === 'tourist') {
            $vehicles = Vehicle::with('owner')->get();
        } else {
            // For vehicle owners, show only their vehicles
            $vehicles = Vehicle::where('owner_id', $user->id)->get();
        }

        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:car,van,tuk-tuk',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'available_from' => 'required|date',
            'available_to' => 'required|date|after:available_from',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB max
        ]);

        $data = $request->all();
        $data['owner_id'] = Auth::id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('vehicles', 'public');
            $data['image_url'] = $imagePath;
        }

        Vehicle::create($data);

        return redirect()->route('dashboard')->with('success', 'Vehicle created successfully!');
    }

    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        // Check if user owns this vehicle
        if ($vehicle->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        // Check if user owns this vehicle
        if ($vehicle->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'type' => 'required|in:car,van,tuk-tuk',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'available_from' => 'required|date',
            'available_to' => 'required|date|after:available_from',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = $request->except('image');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($vehicle->image_url) {
                Storage::disk('public')->delete($vehicle->image_url);
            }

            $imagePath = $request->file('image')->store('vehicles', 'public');
            $data['image_url'] = $imagePath;
        }

        $vehicle->update($data);

        return redirect()->route('dashboard')->with('success', 'Vehicle updated successfully!');
    }

    public function destroy(Vehicle $vehicle)
    {
        // Check if user owns this vehicle
        if ($vehicle->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete image if exists
        if ($vehicle->image_url) {
            Storage::disk('public')->delete($vehicle->image_url);
        }

        $vehicle->delete();

        return redirect()->route('dashboard')->with('success', 'Vehicle deleted successfully!');
    }
}
