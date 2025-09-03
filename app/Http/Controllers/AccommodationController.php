<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AccommodationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // If user is admin or tourist, show all accommodations
        if ($user->role === 'admin' || $user->role === 'tourist') {
            $accommodations = Accommodation::with('destination', 'owner')->get();
        } else {
            // For room owners, show only their accommodations
            $accommodations = Accommodation::where('owner_id', $user->id)->with('destination')->get();
        }

        return view('accommodations.index', compact('accommodations'));
    }

    public function create()
    {
        $destinations = Destination::all();
        return view('accommodations.create', compact('destinations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'dest_id' => 'required|exists:destinations,id',
            'price_per_night' => 'required|numeric|min:0',
            'available_from' => 'required|date',
            'available_to' => 'required|date|after:available_from',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB max
        ]);

        $data = $request->all();
        $data['owner_id'] = Auth::id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('accommodations', 'public');
            $data['image_url'] = $imagePath;
        }

        Accommodation::create($data);

        return redirect()->route('dashboard')->with('success', 'Accommodation created successfully!');
    }

    public function show(Accommodation $accommodation)
    {
        return view('accommodations.show', compact('accommodation'));
    }

    public function edit(Accommodation $accommodation)
    {
        // Check if user owns this accommodation
        if ($accommodation->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $destinations = Destination::all();
        return view('accommodations.edit', compact('accommodation', 'destinations'));
    }

    public function update(Request $request, Accommodation $accommodation)
    {
        // Check if user owns this accommodation
        if ($accommodation->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'dest_id' => 'required|exists:destinations,id',
            'price_per_night' => 'required|numeric|min:0',
            'available_from' => 'required|date',
            'available_to' => 'required|date|after:available_from',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = $request->except('image');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($accommodation->image_url) {
                Storage::disk('public')->delete($accommodation->image_url);
            }

            $imagePath = $request->file('image')->store('accommodations', 'public');
            $data['image_url'] = $imagePath;
        }

        $accommodation->update($data);

        return redirect()->route('dashboard')->with('success', 'Accommodation updated successfully!');
    }

    public function destroy(Accommodation $accommodation)
    {
        // Check if user owns this accommodation
        if ($accommodation->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete image if exists
        if ($accommodation->image_url) {
            Storage::disk('public')->delete($accommodation->image_url);
        }

        $accommodation->delete();

        return redirect()->route('dashboard')->with('success', 'Accommodation deleted successfully!');
    }
}
