<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover Places - Smart Tourist Guide</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-orange-500 text-2xl mr-3"></i>
                        <span class="text-xl font-bold text-gray-800">Smart Tourist Guide</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-orange-500 transition-colors">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                    <a href="{{ route('discover.places') }}" class="text-orange-500 font-semibold">
                        <i class="fas fa-globe mr-2"></i>Discover Places
                    </a>
                    <a href="#" class="text-gray-600 hover:text-orange-500 transition-colors">
                        <i class="fas fa-bed mr-2"></i>Accommodations
                    </a>
                    <a href="#" class="text-gray-600 hover:text-orange-500 transition-colors">
                        <i class="fas fa-car mr-2"></i>Vehicles
                    </a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 transition-colors">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-orange-500 to-yellow-500 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Discover Amazing Places in Sri Lanka</h1>
            <p class="text-xl opacity-90">Explore beautiful destinations across all districts of Sri Lanka</p>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="bg-white py-8 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('discover.places') }}" class="flex flex-col md:flex-row gap-4 items-end">
                <!-- Search Input -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Places</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Search by name or description..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- District Filter -->
                <div class="md:w-64">
                    <label for="district" class="block text-sm font-medium text-gray-700 mb-2">Filter by District</label>
                    <select name="district" id="district"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        <option value="">All Districts</option>
                        @foreach($districts as $district)
                            <option value="{{ $district }}" {{ request('district') == $district ? 'selected' : '' }}>
                                {{ $district }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Button -->
                <div>
                    <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-md hover:bg-orange-600 transition-colors">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                </div>

                <!-- Clear Filters -->
                @if(request('search') || request('district'))
                    <div>
                        <a href="{{ route('discover.places') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition-colors">
                            <i class="fas fa-times mr-2"></i>Clear
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </section>

    <!-- Results Section -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Results Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        @if(request('district'))
                            Places in {{ request('district') }}
                        @elseif(request('search'))
                            Search Results for "{{ request('search') }}"
                        @else
                            All Destinations
                        @endif
                    </h2>
                    <p class="text-gray-600 mt-1">
                        {{ $destinations->total() }} {{ Str::plural('destination', $destinations->total()) }} found
                    </p>
                </div>
            </div>

            <!-- Destinations Grid -->
            @if($destinations->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($destinations as $destination)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <!-- Image -->
                            <div class="h-48 overflow-hidden">
                                @if($destination->image_url)
                                    <img src="{{ asset('storage/' . $destination->image_url) }}"
                                         alt="{{ $destination->name }}"
                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                        <i class="fas fa-image text-4xl text-gray-400"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $destination->name }}</h3>

                                @if($destination->district)
                                    <div class="flex items-center text-sm text-gray-600 mb-2">
                                        <i class="fas fa-map-marker-alt mr-2 text-orange-500"></i>
                                        <span>{{ $destination->district }}</span>
                                    </div>
                                @endif

                                @if($destination->rating)
                                    <div class="flex items-center text-sm text-gray-600 mb-3">
                                        <div class="flex text-yellow-400 mr-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $destination->rating ? '' : 'text-gray-300' }}"></i>
                                            @endfor
                                        </div>
                                        <span>{{ number_format($destination->rating, 1) }}/5</span>
                                    </div>
                                @endif

                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit($destination->description, 100) }}
                                </p>

                                <div class="flex justify-between items-center">
                                    <a href="{{ route('destinations.show', $destination) }}"
                                       class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 transition-colors text-sm">
                                        <i class="fas fa-eye mr-1"></i>View Details
                                    </a>

                                    @if($destination->latitude && $destination->longitude)
                                        <div class="flex space-x-1">
                                            <button onclick="showOnGoogleMaps({{ $destination->latitude }}, {{ $destination->longitude }}, '{{ $destination->name }}')"
                                                    class="text-blue-600 hover:text-blue-800 transition-colors"
                                                    title="Open in Google Maps">
                                                <i class="fas fa-map"></i>
                                            </button>
                                            <button onclick="showOnAppleMaps({{ $destination->latitude }}, {{ $destination->longitude }}, '{{ $destination->name }}')"
                                                    class="text-gray-600 hover:text-gray-800 transition-colors"
                                                    title="Open in Apple Maps">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </button>
                                            <button onclick="copyCoordinates({{ $destination->latitude }}, {{ $destination->longitude }})"
                                                    class="text-green-600 hover:text-green-800 transition-colors"
                                                    title="Copy Coordinates">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $destinations->appends(request()->query())->links() }}
                </div>
            @else
                <!-- No Results -->
                <div class="text-center py-12">
                    <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No destinations found</h3>
                    <p class="text-gray-500 mb-6">
                        @if(request('search') || request('district'))
                            Try adjusting your search criteria or filters.
                        @else
                            No destinations are available at the moment.
                        @endif
                    </p>
                    @if(request('search') || request('district'))
                        <a href="{{ route('discover.places') }}"
                           class="bg-orange-500 text-white px-6 py-2 rounded-md hover:bg-orange-600 transition-colors">
                            <i class="fas fa-refresh mr-2"></i>View All Destinations
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center mb-4">
                <i class="fas fa-map-marker-alt text-orange-500 text-2xl mr-3"></i>
                <span class="text-xl font-bold">Smart Tourist Guide</span>
            </div>
            <p class="text-gray-400">&copy; 2024 Sri Lanka Tourism. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function showOnGoogleMaps(lat, lng, name) {
            // Open Google Maps with the destination coordinates
            const url = `https://www.google.com/maps?q=${lat},${lng}&z=15`;
            window.open(url, '_blank');
        }

        function showOnAppleMaps(lat, lng, name) {
            // Open Apple Maps with the destination coordinates
            const url = `https://maps.apple.com/?q=${lat},${lng}&z=15`;
            window.open(url, '_blank');
        }

        function copyCoordinates(lat, lng) {
            // Copy coordinates to clipboard
            const coordinates = `${lat}, ${lng}`;
            navigator.clipboard.writeText(coordinates).then(function() {
                // Show success message
                showNotification('Coordinates copied to clipboard!', 'success');
            }).catch(function() {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = coordinates;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showNotification('Coordinates copied to clipboard!', 'success');
            });
        }

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white ${
                type === 'success' ? 'bg-green-500' : 'bg-blue-500'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check' : 'info'}-circle mr-2"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Auto-submit form when district changes
        document.getElementById('district').addEventListener('change', function() {
            this.form.submit();
        });
    </script>
</body>
</html>
