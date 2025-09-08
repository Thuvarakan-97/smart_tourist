<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Owner Dashboard - Smart Tourist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-800 text-white">
            <div class="p-4">
                <h1 class="text-xl font-bold">Vehicle Owner Menu</h1>
            </div>
            <nav class="mt-8">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 bg-blue-700 text-white">
                    <i class="fas fa-home mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('vehicles.create') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-3"></i>
                    Add Vehicle
                </a>
                <a href="{{ route('vehicles.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                    <i class="fas fa-list mr-3"></i>
                    My Vehicles
                </a>
                <a href="{{ route('bookings.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                    <i class="fas fa-calendar mr-3"></i>
                    Bookings
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

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <i class="fas fa-car text-3xl text-blue-600 mr-4"></i>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $vehicles->count() }}</h3>
                                <p class="text-sm text-gray-600">My Vehicles</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-check text-3xl text-green-600 mr-4"></i>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $bookings->where('status', 'confirmed')->count() }}</h3>
                                <p class="text-sm text-gray-600">Confirmed Bookings</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-3xl text-yellow-600 mr-4"></i>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $bookings->where('status', 'pending')->count() }}</h3>
                                <p class="text-sm text-gray-600">Pending Bookings</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- My Vehicles -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">My Vehicles</h3>
                        <a href="{{ route('vehicles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Add New
                        </a>
                    </div>
                    @if($vehicles->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($vehicles as $vehicle)
                            <div class="border rounded-lg overflow-hidden">
                                <div class="h-48 bg-gray-200 flex items-center justify-center">
                                    @if($vehicle->image_url)
                                        <img src="{{ asset('storage/' . $vehicle->image_url) }}" alt="{{ ucfirst($vehicle->type) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="text-center">
                                            <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                            <p class="text-gray-500">No Image</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h4 class="font-semibold text-lg">{{ ucfirst($vehicle->type) }}</h4>
                                    <p class="text-gray-600 text-sm mb-2">{{ $vehicle->description }}</p>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-green-600 font-semibold">LKR {{ number_format($vehicle->price_per_day, 2) }}/day</span>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('vehicles.edit', $vehicle) }}" class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600">
                                                <i class="fas fa-edit mr-1"></i>Edit
                                            </a>
                                            <form method="POST" action="{{ route('vehicles.destroy', $vehicle) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash mr-1"></i>Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Available: {{ $vehicle->available_from->format('M d') }} - {{ $vehicle->available_to->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No vehicles yet. <a href="{{ route('vehicles.create') }}" class="text-blue-500">Add your first vehicle</a></p>
                    @endif
                </div>

                <!-- Recent Bookings -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-4">Recent Bookings</h3>
                    @if($bookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tourist</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($bookings->take(5) as $booking)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $booking->tourist->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ ucfirst($booking->vehicle->type) }}
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($booking->status === 'pending')
                                                <form method="POST" action="{{ route('bookings.update-status', $booking) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-xs mr-2 hover:bg-green-600">
                                                        <i class="fas fa-check mr-1"></i>Approve
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('bookings.update-status', $booking) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">
                                                        <i class="fas fa-times mr-1"></i>Reject
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No bookings yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
