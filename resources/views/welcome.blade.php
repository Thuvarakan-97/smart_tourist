<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Smart Tourist Guide</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-gray-50">
        <!-- Header -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-blue-600">Smart Tourist Guide</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        @endif
                        <button class="text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative bg-cover bg-center h-96" style="background-image: url('https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <div class="relative z-10 flex items-center justify-center h-full">
                <div class="text-center text-white">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4">Welcome!!! Ready for Your Next Adventure?</h1>
                    <p class="text-xl mb-8">Plan your trips, manage bookings, and discover amazing destinations in Sri Lanka.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                            Start Exploring
                        </a>
                        <a href="#bookings" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition duration-300">
                            View Bookings
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Your Current Bookings Section -->
        <div id="bookings" class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Your Current Bookings</h2>
                    <p class="text-gray-600">Manage your upcoming trips and accommodations.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                    <!-- Upcoming Trip Card -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Upcoming Trip</h3>
                        <div class="space-y-2 text-gray-600">
                            <p><strong>Destination:</strong> Colombo</p>
                            <p><strong>Dates:</strong> 2020-12-01 to 2020-12-13</p>
                            <p><strong>Itinerary:</strong> City tour, Beach visit</p>
                        </div>
                        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                            View
                        </button>
                    </div>
                    <!-- Accommodation Card -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Accommodation</h3>
                        <div class="space-y-2 text-gray-600">
                            <p><strong>Name:</strong> Hilton Colombo</p>
                            <p><strong>Check-in:</strong> 2020-12-01</p>
                            <p><strong>Check-out:</strong> 2020-12-13</p>
                        </div>
                        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                            View
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Explore Sri Lanka</h2>
                    <p class="text-gray-600">Discover the beautiful destinations across the island</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="h-96 bg-gray-200 flex items-center justify-center relative">
                        <!-- Map Container -->
                        <div id="map" class="w-full h-full"></div>
                        <!-- Map Overlay with Destinations -->
                        <div class="absolute top-4 left-4 bg-white rounded-lg shadow-lg p-4 max-w-xs">
                            <h3 class="font-semibold text-gray-900 mb-2">Popular Destinations</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                    <span class="text-gray-700">Colombo</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                    <span class="text-gray-700">Negombo</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                    <span class="text-gray-700">Galle</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                                    <span class="text-gray-700">Sigiriya</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-purple-500 rounded-full mr-2"></div>
                                    <span class="text-gray-700">Kandy</span>
                                </div>
                            </div>
                        </div>
                        <!-- Map Controls -->
                        <div class="absolute top-4 right-4 bg-white rounded-lg shadow-lg p-2">
                            <div class="flex flex-col space-y-1">
                                <button class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded flex items-center justify-center text-gray-600">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                                <button class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded flex items-center justify-center text-gray-600">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Suggested Tourist Destinations Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Suggested Tourist Destinations</h2>
                    <p class="text-gray-600">Discover the most popular places to visit in Sri Lanka.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Sigiriya Rock Card -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="h-48 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Sigiriya Rock</h3>
                            <p class="text-gray-600 mb-2">Central Province • ★ 4.8/5</p>
                            <p class="text-gray-600 mb-4">Explore the ancient rock fortress and its beautiful surroundings.</p>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                                Learn More
                            </button>
                        </div>
                    </div>
                    <!-- Mirissa Beach Card -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="h-48 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Mirissa Beach</h3>
                            <p class="text-gray-600 mb-2">Southern Province • ★ 4.7/5</p>
                            <p class="text-gray-600 mb-4">Enjoy the stunning beaches and a lively atmosphere with whale tours.</p>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                                Learn More
                            </button>
                        </div>
                    </div>
                    <!-- Temple of the Tooth Card -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="h-48 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Temple of the Tooth</h3>
                            <p class="text-gray-600 mb-2">Kandy • ★ 4.9/5</p>
                            <p class="text-gray-600 mb-4">Visit the revered temple and explore Kandy's cultural heritage.</p>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                                Learn More
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accommodations Section -->
        <div class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Accommodations</h2>
                    <p class="text-gray-600">Browse the best hotels and guesthouses across Sri Lanka.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Hilton Colombo Card -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="h-48 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Hilton Colombo</h3>
                            <p class="text-gray-600 mb-2">Colombo • ★ 4.5/5</p>
                            <p class="text-gray-600 mb-4">Modern luxury hotel located in the heart of Colombo.</p>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                                Book Now
                            </button>
                        </div>
                    </div>
                    <!-- Hotel Sigiriya Card -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="h-48 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2060&q=80');">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Hotel Sigiriya</h3>
                            <p class="text-gray-600 mb-2">Sigiriya • ★ 4.6/5</p>
                            <p class="text-gray-600 mb-4">A serene stay near the world-famous Sigiriya Rock Fortress.</p>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                                Book Now
                            </button>
                        </div>
                    </div>
                    <!-- Jetwing Lighthouse Card -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="h-48 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Jetwing Lighthouse</h3>
                            <p class="text-gray-600 mb-2">Galle • ★ 4.7/5</p>
                            <p class="text-gray-600 mb-4">Stunning beachfront resort with panoramic ocean views.</p>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vehicle Rentals Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Vehicle Rentals</h2>
                    <p class="text-gray-600">Choose from a wide range of vehicles to explore Sri Lanka comfortably.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Tuk Tuk Card -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="h-48 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tuk Tuk</h3>
                            <p class="text-gray-600 mb-4">Perfect for short city rides and a unique travel experience.</p>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                                Book Now
                            </button>
                        </div>
                    </div>
                    <!-- Van Card -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="h-48 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1549924231-f129b911e442?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Van</h3>
                            <p class="text-gray-600 mb-4">Ideal for group travel, family trips, or airport transfers.</p>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                                Book Now
                            </button>
                        </div>
                    </div>
                    <!-- Sedan Card -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="h-48 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1549924231-f129b911e442?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Sedan</h3>
                            <p class="text-gray-600 mb-4">Comfortable and efficient option for city travel and family tours.</p>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Quick Actions</h2>
                    <p class="text-gray-600">Book vehicles and search accommodations.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <!-- Vehicle Booking Card -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Vehicle Booking</h3>
                        <p class="text-gray-600 mb-4">Book cars, tuk-tuks, vans, and buses for yourself or your clients.</p>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                            Book a Vehicle
                        </button>
                    </div>
                    <!-- Room Search Card -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Room Search</h3>
                        <p class="text-gray-600 mb-4">Search for hotels, guesthouses, and resorts across Sri Lanka.</p>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                            Search Rooms
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications and Alerts Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Notifications and Alerts</h2>
                </div>
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                        <div class="space-y-4">
                            <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                                <i class="fas fa-bell text-blue-600 mr-3"></i>
                                <span class="text-gray-700">Upcoming Booking: Colombo Trip - Check-in on 2020-12-01</span>
                            </div>
                            <div class="flex items-center p-3 bg-green-50 rounded-lg">
                                <i class="fas fa-gift text-green-600 mr-3"></i>
                                <span class="text-gray-700">Special Offer: 20% off on your next booking!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-blue-600 text-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Sri Lanka Explorer -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Sri Lanka Explorer</h3>
                        <p class="text-blue-100">Your gateway to discovering the beautiful island of Sri Lanka.</p>
                    </div>
                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2 text-blue-100">
                            <li><a href="#" class="hover:text-white transition duration-300">Tourist Places</a></li>
                            <li><a href="#" class="hover:text-white transition duration-300">Accommodations</a></li>
                            <li><a href="#" class="hover:text-white transition duration-300">Vehicle Rentals</a></li>
                            <li><a href="#" class="hover:text-white transition duration-300">Contact Us</a></li>
                        </ul>
                    </div>
                    <!-- For Business -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">For Business</h3>
                        <ul class="space-y-2 text-blue-100">
                            <li><a href="#" class="hover:text-white transition duration-300">List Your Property</a></li>
                            <li><a href="#" class="hover:text-white transition duration-300">List Your Vehicle</a></li>
                            <li><a href="#" class="hover:text-white transition duration-300">Admin Panel</a></li>
                        </ul>
                    </div>
                    <!-- Social Media -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Follow Us</h3>
                        <p class="text-blue-100 mb-4">Facebook | Instagram | Twitter</p>
                        <p class="text-blue-100 text-sm">© 2023 Sri Lanka Tourism. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Map Script -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            // Initialize map when page loads
            document.addEventListener('DOMContentLoaded', function() {
                // Create map centered on Sri Lanka
                var map = L.map('map').setView([7.8731, 80.7718], 8);

                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Add markers for popular destinations
                var destinations = [
                    {name: 'Colombo', lat: 6.9271, lng: 79.8612, color: '#ef4444'},
                    {name: 'Negombo', lat: 7.2095, lng: 79.8384, color: '#3b82f6'},
                    {name: 'Galle', lat: 6.0535, lng: 80.2210, color: '#10b981'},
                    {name: 'Sigiriya', lat: 7.9570, lng: 80.7600, color: '#f59e0b'},
                    {name: 'Kandy', lat: 7.2906, lng: 80.6337, color: '#8b5cf6'}
                ];

                destinations.forEach(function(dest) {
                    var marker = L.circleMarker([dest.lat, dest.lng], {
                        radius: 8,
                        fillColor: dest.color,
                        color: '#fff',
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.8
                    }).addTo(map);

                    marker.bindPopup('<b>' + dest.name + '</b><br>Click to explore this destination');
                });

                // Add zoom controls functionality
                document.querySelector('.fa-plus').parentElement.addEventListener('click', function() {
                    map.zoomIn();
                });

                document.querySelector('.fa-minus').parentElement.addEventListener('click', function() {
                    map.zoomOut();
                });
            });
        </script>
    </body>
</html>