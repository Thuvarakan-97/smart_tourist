<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if(auth()->user()->role === 'tourist')
            Book Rooms - Smart Tourist
        @elseif(auth()->user()->role === 'room_owner')
            My Accommodations - Smart Tourist
        @elseif(auth()->user()->role === 'vehicle_owner')
            My Accommodations - Smart Tourist
        @elseif(auth()->user()->role === 'admin')
            All Accommodations - Smart Tourist
        @endif
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-800 text-white">
            <div class="p-4">
                <h1 class="text-xl font-bold">
                    @if(auth()->user()->role === 'tourist')
                        Tourist Menu
                    @elseif(auth()->user()->role === 'room_owner')
                        Room Owner Menu
                    @elseif(auth()->user()->role === 'vehicle_owner')
                        Vehicle Owner Menu
                    @elseif(auth()->user()->role === 'admin')
                        Admin Menu
                    @endif
                </h1>
            </div>
            <nav class="mt-8">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                    <i class="fas fa-home mr-3"></i>
                    Dashboard
                </a>
                @if(auth()->user()->role === 'tourist')
                    <a href="{{ route('destinations.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                        <i class="fas fa-globe mr-3"></i>
                        Destinations
                    </a>
                    <a href="{{ route('accommodations.index') }}" class="flex items-center px-4 py-3 bg-blue-700 text-white">
                        <i class="fas fa-bed mr-3"></i>
                        Book Rooms
                    </a>
                    <a href="{{ route('vehicles.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                        <i class="fas fa-car mr-3"></i>
                        Rent Vehicles
                    </a>
                @elseif(auth()->user()->role === 'room_owner')
                    <a href="{{ route('accommodations.create') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-3"></i>
                        Add Accommodation
                    </a>
                    <a href="{{ route('accommodations.index') }}" class="flex items-center px-4 py-3 bg-blue-700 text-white">
                        <i class="fas fa-list mr-3"></i>
                        My Accommodations
                    </a>
                    <a href="{{ route('bookings.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                        <i class="fas fa-calendar mr-3"></i>
                        Bookings
                    </a>
                @elseif(auth()->user()->role === 'vehicle_owner')
                    <a href="{{ route('vehicles.create') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-3"></i>
                        Add Vehicle
                    </a>
                    <a href="{{ route('vehicles.index') }}" class="flex items-center px-4 py-3 bg-blue-700 text-white">
                        <i class="fas fa-list mr-3"></i>
                        My Vehicles
                    </a>
                    <a href="{{ route('bookings.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                        <i class="fas fa-calendar mr-3"></i>
                        Bookings
                    </a>
                @endif
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
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    @if(auth()->user()->role === 'tourist')
                        Search Available Rooms
                    @elseif(auth()->user()->role === 'room_owner')
                        My Accommodations
                    @elseif(auth()->user()->role === 'vehicle_owner')
                        My Accommodations
                    @elseif(auth()->user()->role === 'admin')
                        All Accommodations
                    @endif
                </h2>

                @if(auth()->user()->role === 'tourist')
                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" placeholder="Search by location..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                @endif

                <!-- Accommodations Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($accommodations as $accommodation)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            @if($accommodation->image_url)
                                <img src="{{ Storage::url($accommodation->image_url) }}" alt="{{ $accommodation->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center">
                                    <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-500">No Image</p>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg text-gray-800 mb-2">{{ $accommodation->title }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $accommodation->description }}</p>
                            <p class="text-gray-600 text-sm mb-3">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                {{ $accommodation->destination->name }}
                            </p>
                            <div class="flex items-center justify-between">
                                <div class="text-green-600 font-semibold">
                                    LKR {{ number_format($accommodation->price_per_night, 2) }} / night
                                </div>
                                @if(auth()->user()->role === 'tourist')
                                    <div class="flex space-x-2">
                                        <a href="{{ route('accommodations.show', $accommodation) }}" class="bg-gray-600 text-white px-3 py-2 rounded text-sm hover:bg-gray-700 transition-colors">
                                            View Details
                                        </a>
                                        <button onclick="openBookingModal({{ $accommodation->id }}, '{{ $accommodation->title }}')" class="bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700 transition-colors">
                                            Book Now
                                        </button>
                                    </div>
                                @elseif(auth()->user()->role === 'room_owner')
                                    <div class="flex space-x-2">
                                        <a href="{{ route('accommodations.edit', $accommodation) }}" class="bg-yellow-500 text-white px-3 py-2 rounded text-sm hover:bg-yellow-600 transition-colors">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </a>
                                        <form method="POST" action="{{ route('accommodations.destroy', $accommodation) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded text-sm hover:bg-red-600 transition-colors" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash mr-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->role === 'tourist')
    <!-- Booking Modal -->
    <div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Book Accommodation</h3>
                <button onclick="closeBookingModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="bookingForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Accommodation</label>
                    <input type="text" id="accommodationName" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Check-in Date</label>
                    <input type="date" name="start_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Check-out Date</label>
                    <input type="date" name="end_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeBookingModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Confirm Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openBookingModal(accommodationId, accommodationName) {
            document.getElementById('accommodationName').value = accommodationName;
            document.getElementById('bookingForm').action = `/book-accommodation/${accommodationId}`;
            document.getElementById('bookingModal').classList.remove('hidden');
            document.getElementById('bookingModal').classList.add('flex');
        }

        function closeBookingModal() {
            document.getElementById('bookingModal').classList.add('hidden');
            document.getElementById('bookingModal').classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('bookingModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBookingModal();
            }
        });
    </script>
    @endif
</body>
</html>


