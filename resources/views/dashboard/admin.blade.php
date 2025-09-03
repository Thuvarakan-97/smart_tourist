<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Smart Tourist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-800 text-white">
            <div class="p-4">
                <div class="flex items-center">
                    <i class="fas fa-shield-alt text-2xl mr-3"></i>
                    <h1 class="text-xl font-bold">Admin Panel</h1>
                </div>
            </div>
            <nav class="mt-8">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.destinations.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                    <i class="fas fa-map-marker-alt mr-3"></i>
                    Manage Destinations
                </a>
                <a href="{{ route('admin.accommodations.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                    <i class="fas fa-bed mr-3"></i>
                    Manage Rooms
                </a>
                <a href="{{ route('admin.vehicles.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                    <i class="fas fa-car mr-3"></i>
                    Manage Vehicles
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                    <i class="fas fa-users mr-3"></i>
                    User Accounts
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
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Welcome, Admin</h2>
                    <div class="flex items-center">
                        <i class="fas fa-user mr-2 text-gray-600"></i>
                        <span class="text-gray-600">Admin</span>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <i class="fas fa-users text-3xl text-blue-600 mr-4"></i>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $total_users }}</h3>
                                <p class="text-sm text-gray-600">Total Users</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-3xl text-green-600 mr-4"></i>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $total_destinations }}</h3>
                                <p class="text-sm text-gray-600">Destinations</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <i class="fas fa-bed text-3xl text-purple-600 mr-4"></i>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $total_accommodations }}</h3>
                                <p class="text-sm text-gray-600">Accommodations</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <i class="fas fa-car text-3xl text-orange-600 mr-4"></i>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $total_vehicles }}</h3>
                                <p class="text-sm text-gray-600">Vehicles</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-4">Recent Bookings</h3>
                    @if($recent_bookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tourist</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recent_bookings as $booking)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $booking->tourist->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ ucfirst($booking->item_type) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($booking->item_type === 'accommodation')
                                                {{ $booking->accommodation->title ?? 'N/A' }}
                                            @elseif($booking->item_type === 'vehicle')
                                                {{ $booking->vehicle ? ucfirst($booking->vehicle->type) : 'N/A' }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $booking->start_date->format('M d') }} - {{ $booking->end_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                                @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No recent bookings.</p>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="{{ route('admin.destinations.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-3xl text-green-600 mr-4"></i>
                            <div>
                                <h3 class="font-semibold text-gray-800">Manage Destinations</h3>
                                <p class="text-sm text-gray-600">Add, edit, or remove destinations</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('admin.accommodations.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center">
                            <i class="fas fa-bed text-3xl text-purple-600 mr-4"></i>
                            <div>
                                <h3 class="font-semibold text-gray-800">Manage Rooms</h3>
                                <p class="text-sm text-gray-600">View and manage accommodations</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('admin.vehicles.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center">
                            <i class="fas fa-car text-3xl text-orange-600 mr-4"></i>
                            <div>
                                <h3 class="font-semibold text-gray-800">Manage Vehicles</h3>
                                <p class="text-sm text-gray-600">View and manage vehicles</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
