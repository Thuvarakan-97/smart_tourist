<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourist Dashboard - Smart Tourist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-800 text-white">
            <div class="p-4">
                <h1 class="text-xl font-bold">Tourist Menu</h1>
            </div>
            <nav class="mt-8">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                    <i class="fas fa-home mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('destinations.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                    <i class="fas fa-globe mr-3"></i>
                    Destinations
                </a>
                <a href="{{ route('accommodations.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                    <i class="fas fa-bed mr-3"></i>
                    Book Rooms
                </a>
                <a href="{{ route('vehicles.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                    <i class="fas fa-car mr-3"></i>
                    Rent Vehicles
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                    @csrf
                    <button type="submit" class="flex items-center px-4 py-3 text-red-400 hover:bg-blue-700 transition-colors w-full">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Logout
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Welcome, {{ Auth::user()->name }}!</h2>

                <!-- My Bookings Section -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">My Bookings</h3>
                    @if($my_bookings->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($my_bookings as $booking)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-sm font-medium text-gray-600">
                                        {{ ucfirst($booking->item_type) }}
                                    </span>
                                    <span class="px-2 py-1 text-xs rounded-full
                                        @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                                <h4 class="font-semibold text-gray-800">
                                    @if($booking->item_type === 'accommodation')
                                        {{ $booking->accommodation->title ?? 'N/A' }}
                                    @elseif($booking->item_type === 'vehicle')
                                        {{ $booking->vehicle ? ucfirst($booking->vehicle->type) : 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </h4>
                                <p class="text-sm text-gray-600">
                                    {{ $booking->start_date->format('M d') }} - {{ $booking->end_date->format('M d, Y') }}
                                </p>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No bookings yet. Start exploring destinations and book your first accommodation or vehicle!</p>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <a href="{{ route('destinations.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center">
                            <i class="fas fa-globe text-3xl text-blue-600 mr-4"></i>
                            <div>
                                <h3 class="font-semibold text-gray-800">Explore Destinations</h3>
                                <p class="text-sm text-gray-600">Discover amazing places</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('accommodations.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center">
                            <i class="fas fa-bed text-3xl text-green-600 mr-4"></i>
                            <div>
                                <h3 class="font-semibold text-gray-800">Book Accommodations</h3>
                                <p class="text-sm text-gray-600">Find perfect places to stay</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('vehicles.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center">
                            <i class="fas fa-car text-3xl text-orange-600 mr-4"></i>
                            <div>
                                <h3 class="font-semibold text-gray-800">Rent Vehicles</h3>
                                <p class="text-sm text-gray-600">Get around easily</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>
                    <div class="space-y-3">
                        @if($my_bookings->count() > 0)
                            @foreach($my_bookings->take(3) as $booking)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <i class="fas fa-calendar-check text-blue-600 mr-3"></i>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">
                                        Booked {{ ucfirst($booking->item_type) }} -
                                        @if($booking->item_type === 'accommodation')
                                            {{ $booking->accommodation->title ?? 'N/A' }}
                                        @elseif($booking->item_type === 'vehicle')
                                            {{ $booking->vehicle ? ucfirst($booking->vehicle->type) : 'N/A' }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-600">{{ $booking->created_at->diffForHumans() }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                    @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                            @endforeach
                        @else
                            <p class="text-gray-500">No recent activity. Start exploring to see your bookings here!</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
