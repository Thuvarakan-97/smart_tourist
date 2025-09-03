<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Accommodation;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin sees all bookings
            $bookings = Booking::with(['tourist', 'accommodation', 'vehicle'])->latest()->get();
        } elseif ($user->role === 'room_owner') {
            // Room owners see bookings for their accommodations
            $bookings = Booking::whereHas('accommodation', function($query) use ($user) {
                $query->where('owner_id', $user->id);
            })->with(['tourist', 'accommodation'])->latest()->get();
        } elseif ($user->role === 'vehicle_owner') {
            // Vehicle owners see bookings for their vehicles
            $bookings = Booking::whereHas('vehicle', function($query) use ($user) {
                $query->where('owner_id', $user->id);
            })->with(['tourist', 'vehicle'])->latest()->get();
        } else {
            // Tourists see their own bookings
            $bookings = Booking::where('tourist_id', $user->id)->with(['accommodation', 'vehicle'])->latest()->get();
        }

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        return view('bookings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_type' => 'required|in:accommodation,vehicle',
            'item_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $booking = Booking::create([
            'tourist_id' => Auth::id(),
            'item_type' => $request->item_type,
            'item_id' => $request->item_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking created successfully!');
    }

    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        return view('bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $booking->update($request->only(['start_date', 'end_date']));

        return redirect()->route('dashboard')->with('success', 'Booking updated successfully!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('dashboard')->with('success', 'Booking cancelled successfully!');
    }

    // Book accommodation
    public function bookAccommodation(Request $request, Accommodation $accommodation)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Check if accommodation is available for the selected dates
        $conflictingBooking = Booking::where('item_type', 'accommodation')
            ->where('item_id', $accommodation->id)
            ->where('status', '!=', 'cancelled')
            ->where(function($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                      ->orWhere(function($q) use ($request) {
                          $q->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                      });
            })->first();

        if ($conflictingBooking) {
            return back()->with('error', 'This accommodation is not available for the selected dates.');
        }

        $booking = Booking::create([
            'tourist_id' => Auth::id(),
            'item_type' => 'accommodation',
            'item_id' => $accommodation->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Accommodation booked successfully! Please wait for owner approval.');
    }

    // Book vehicle
    public function bookVehicle(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Check if vehicle is available for the selected dates
        $conflictingBooking = Booking::where('item_type', 'vehicle')
            ->where('item_id', $vehicle->id)
            ->where('status', '!=', 'cancelled')
            ->where(function($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                      ->orWhere(function($q) use ($request) {
                          $q->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                      });
            })->first();

        if ($conflictingBooking) {
            return back()->with('error', 'This vehicle is not available for the selected dates.');
        }

        $booking = Booking::create([
            'tourist_id' => Auth::id(),
            'item_type' => 'vehicle',
            'item_id' => $vehicle->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Vehicle booked successfully! Please wait for owner approval.');
    }

    // Update booking status (for owners)
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:confirmed,cancelled',
        ]);

        // Check if user is the owner of the accommodation or vehicle
        $isOwner = false;

        if ($booking->item_type === 'accommodation') {
            $isOwner = $booking->accommodation && $booking->accommodation->owner_id === Auth::id();
        } elseif ($booking->item_type === 'vehicle') {
            $isOwner = $booking->vehicle && $booking->vehicle->owner_id === Auth::id();
        }

        if (!$isOwner) {
            abort(403, 'Unauthorized action.');
        }

        $booking->update(['status' => $request->status]);

        $statusText = $request->status === 'confirmed' ? 'approved' : 'rejected';
        return redirect()->route('dashboard')->with('success', "Booking {$statusText} successfully!");
    }
}
