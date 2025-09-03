<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Accommodation;
use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Debug: Log the user role
        \Log::info('User role detected: ' . $user->role . ' for user: ' . $user->name);

        switch ($user->role) {
            case 'admin':
                return $this->adminDashboard();
            case 'tourist':
                return $this->touristDashboard();
            case 'room_owner':
                return $this->roomOwnerDashboard();
            case 'vehicle_owner':
                return $this->vehicleOwnerDashboard();
            default:
                // If user has no valid role, logout and redirect to login
                Auth::logout();
                return redirect()->route('login')->with('error', 'Invalid user role: ' . $user->role . '. Please contact administrator.');
        }
    }

    private function adminDashboard()
    {
        $data = [
            'total_users' => \App\Models\User::count(),
            'total_destinations' => Destination::count(),
            'total_accommodations' => Accommodation::count(),
            'total_vehicles' => Vehicle::count(),
            'total_bookings' => Booking::count(),
            'recent_bookings' => Booking::with(['tourist', 'accommodation', 'vehicle'])->latest()->take(5)->get(),
        ];

        return view('dashboard.admin', $data);
    }

    private function touristDashboard()
    {
        $user = Auth::user();
        $data = [
            'destinations' => Destination::all(),
            'accommodations' => Accommodation::with('destination')->where('available_from', '<=', now())->where('available_to', '>=', now())->get(),
            'vehicles' => Vehicle::where('available_from', '<=', now())->where('available_to', '>=', now())->get(),
            'my_bookings' => Booking::where('tourist_id', $user->id)
                ->with(['accommodation', 'vehicle'])
                ->latest()
                ->get(),
        ];

        return view('dashboard.tourist', $data);
    }

    private function roomOwnerDashboard()
    {
        $user = Auth::user();
        $data = [
            'accommodations' => Accommodation::where('owner_id', $user->id)->with('destination')->get(),
            'bookings' => Booking::whereHas('accommodation', function($query) use ($user) {
                $query->where('owner_id', $user->id);
            })->with(['tourist', 'accommodation'])->latest()->get(),
        ];

        return view('dashboard.room_owner', $data);
    }

    private function vehicleOwnerDashboard()
    {
        $user = Auth::user();
        $data = [
            'vehicles' => Vehicle::where('owner_id', $user->id)->get(),
            'bookings' => Booking::whereHas('vehicle', function($query) use ($user) {
                $query->where('owner_id', $user->id);
            })->with(['tourist', 'vehicle'])->latest()->get(),
        ];

        return view('dashboard.vehicle_owner', $data);
    }
}
