<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Destinations - Smart Tourist</title>
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
                <a href="{{ route('destinations.index') }}" class="flex items-center px-4 py-3 bg-blue-700 text-white">
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
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Explore Destinations</h2>

                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" placeholder="Search by name..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- Destinations Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($destinations as $destination)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            @if($destination->image_url)
                                <img src="{{ Storage::url($destination->image_url) }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center">
                                    <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-500">No Image</p>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg text-gray-800 mb-2">{{ $destination->name }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ $destination->description }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    @if($destination->rating)
                                        <i class="fas fa-star text-yellow-500 mr-1"></i>
                                        <span class="text-sm text-gray-600">{{ $destination->rating }}/5</span>
                                    @else
                                        <span class="text-sm text-gray-500">No rating</span>
                                    @endif
                                </div>
                                <a href="{{ route('destinations.show', $destination) }}" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition-colors">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</body>
</html>
