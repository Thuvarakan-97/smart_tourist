<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Test route to check authentication
// Test route to check data
Route::get('/test-data', function() {
    return [
        'accommodations' => \App\Models\Accommodation::count(),
        'vehicles' => \App\Models\Vehicle::count(),
        'accommodations_data' => \App\Models\Accommodation::with('destination')->get()->toArray(),
        'vehicles_data' => \App\Models\Vehicle::all()->toArray(),
    ];
});

Route::get('/test-auth', function () {
    if (auth()->check()) {
        return response()->json([
            'authenticated' => true,
            'user' => [
                'id' => auth()->user()->id,
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'role' => auth()->user()->role,
            ]
        ]);
    }
    return response()->json(['authenticated' => false]);
})->middleware('auth');

// Test route to check users in database
Route::get('/test-users', function () {
    $users = \App\Models\User::select('id', 'name', 'email', 'role', 'created_at')->get();
    return response()->json($users);
});

// Debug route to test vehicle owner dashboard
Route::get('/debug-vehicle-owner', function () {
    $user = \App\Models\User::where('role', 'vehicle_owner')->first();
    if ($user) {
        Auth::login($user);
        return redirect()->route('dashboard');
    }
    return 'No vehicle owner found';
});

// Comprehensive debug route
Route::get('/debug-dashboard', function () {
    if (!auth()->check()) {
        return 'Not logged in';
    }

    $user = auth()->user();
    $role = $user->role;

    return response()->json([
        'user_id' => $user->id,
        'user_name' => $user->name,
        'user_email' => $user->email,
        'user_role' => $role,
        'role_type' => gettype($role),
        'role_length' => strlen($role),
        'role_trimmed' => trim($role),
        'is_vehicle_owner' => $role === 'vehicle_owner',
        'is_vehicle_owner_trimmed' => trim($role) === 'vehicle_owner',
        'switch_case' => match($role) {
            'admin' => 'admin case',
            'tourist' => 'tourist case',
            'room_owner' => 'room_owner case',
            'vehicle_owner' => 'vehicle_owner case',
            default => 'default case: ' . $role
        }
    ]);
})->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Destinations
    Route::resource('destinations', DestinationController::class);

    // Accommodations
    Route::resource('accommodations', AccommodationController::class);

    // Vehicles
    Route::resource('vehicles', VehicleController::class);

    // Bookings
    Route::resource('bookings', BookingController::class);

    // Tourist specific routes
    Route::middleware('role:tourist')->group(function () {
        Route::post('/book-accommodation/{accommodation}', [BookingController::class, 'bookAccommodation'])->name('book.accommodation');
        Route::post('/book-vehicle/{vehicle}', [BookingController::class, 'bookVehicle'])->name('book.vehicle');
    });

    // Owner specific routes
    Route::middleware('role:room_owner,vehicle_owner')->group(function () {
        Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');
    });

    // Admin specific routes
    Route::middleware('role:admin')->group(function () {
        Route::resource('admin/destinations', App\Http\Controllers\Admin\DestinationController::class, ['as' => 'admin']);
        Route::resource('admin/accommodations', App\Http\Controllers\Admin\AccommodationController::class, ['as' => 'admin']);
        Route::resource('admin/vehicles', App\Http\Controllers\Admin\VehicleController::class, ['as' => 'admin']);
        Route::resource('admin/users', App\Http\Controllers\Admin\UserController::class, ['as' => 'admin']);
    });
});

require __DIR__.'/auth.php';
