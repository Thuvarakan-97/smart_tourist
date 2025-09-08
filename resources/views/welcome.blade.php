<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourist Dashboard - Sri Lanka Tourism Explorer</title>
    <meta name="description" content="Your personalized tourist dashboard for Sri Lanka travel planning, bookings, and destination recommendations.">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<style>
  /* Reset and Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Colors */
:root {
    --orange: #e67e22;
    --green: #27ae60;
    --gold: #f39c12;
    --maroon: #8b0000;
    --light-gray: #f8f9fa;
    --dark-gray: #2c3e50;
    --white: #ffffff;
    --shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Typography */
h1, h2, h3, h4, h5, h6 {
    font-weight: 600;
    line-height: 1.3;
}

h1 { font-size: 3rem; }
h2 { font-size: 2.5rem; }
h3 { font-size: 2rem; }
h4 { font-size: 1.5rem; }
h5 { font-size: 1.25rem; }
h6 { font-size: 1rem; }

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
}

.btn-primary {
    background: var(--orange);
    color: white;
}

.btn-primary:hover {
    background: #d35400;
    transform: translateY(-2px);
}

.btn-secondary {
    background: var(--green);
    color: white;
}

.btn-secondary:hover {
    background: #229954;
    transform: translateY(-2px);
}

.btn-outline {
    background: transparent;
    color: white;
    border: 2px solid white;
}

.btn-outline:hover {
    background: white;
    color: var(--orange);
}

.btn-danger {
    background: #e74c3c;
    color: white;
}

.btn-danger:hover {
    background: #c0392b;
}

/* Navigation */
.navbar {
    background: white;
    box-shadow: var(--shadow);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.navbar .container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 20px;
}

.nav-brand {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--orange);
}

.nav-brand i {
    color: var(--orange);
}

.nav-menu {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.nav-link {
    text-decoration: none;
    color: #333;
    font-weight: 500;
    transition: color 0.3s ease;
    position: relative;
}

.nav-link:hover,
.nav-link.active {
    color: var(--orange);
}

.nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 100%;
    height: 2px;
    background: var(--orange);
}

.hamburger {
    display: none;
    flex-direction: column;
    cursor: pointer;
}

.hamburger span {
    width: 25px;
    height: 3px;
    background: #333;
    margin: 3px 0;
    transition: 0.3s;
}

/* Hero Section */
.hero {
    background: linear-gradient(135deg, var(--orange), var(--gold));
    color: white;
    padding: 8rem 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.hero-content {
    max-width: 800px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

.hero h1 {
    margin-bottom: 1.5rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.hero p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.hero-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Features Grid */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.feature-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    text-align: center;
    box-shadow: var(--shadow);
    transition: transform 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: rgba(230, 126, 34, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.feature-icon i {
    font-size: 2rem;
    color: var(--orange);
}

.feature-card h3 {
    margin-bottom: 1rem;
    color: var(--dark-gray);
}

/* Destinations Grid */
.destinations-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.destination-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: transform 0.3s ease;
}

.destination-card:hover {
    transform: translateY(-5px);
}

.destination-image {
    height: 250px;
    overflow: hidden;
}

.destination-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.destination-card:hover .destination-image img {
    transform: scale(1.1);
}

.destination-content {
    padding: 1.5rem;
}

.destination-content h3 {
    margin-bottom: 0.5rem;
    color: var(--dark-gray);
}

.location {
    color: #666;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.rating i {
    color: var(--gold);
}

.description {
    color: #666;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

/* Sections */
.features,
.destinations,
.stats {
    padding: 5rem 0;
}

.features {
    background: var(--light-gray);
}

.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-header h2 {
    margin-bottom: 1rem;
    color: var(--dark-gray);
}

.section-header p {
    font-size: 1.1rem;
    color: #666;
    max-width: 600px;
    margin: 0 auto;
}

/* Stats Grid */
.stats {
    background: var(--dark-gray);
    color: white;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    text-align: center;
}

.stat-number {
    font-size: 3rem;
    font-weight: bold;
    color: var(--orange);
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 1.1rem;
    opacity: 0.9;
}

/* CTA Section */
.cta {
    background: var(--green);
    color: white;
    padding: 5rem 0;
    text-align: center;
}

.cta h2 {
    margin-bottom: 1rem;
}

.cta p {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

/* Footer */
.footer {
    background: var(--dark-gray);
    color: white;
    padding: 3rem 0 1rem;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.footer-brand {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--orange);
    margin-bottom: 1rem;
}

.footer-section h4 {
    margin-bottom: 1rem;
    color: var(--orange);
}

.footer-section ul {
    list-style: none;
}

.footer-section ul li {
    margin-bottom: 0.5rem;
}

.footer-section ul li a {
    color: #ccc;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-section ul li a:hover {
    color: var(--orange);
}

.social-links {
    display: flex;
    gap: 1rem;
}

.social-links a {
    width: 40px;
    height: 40px;
    background: var(--orange);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: transform 0.3s ease;
}

.social-links a:hover {
    transform: translateY(-2px);
}

.footer-bottom {
    text-align: center;
    padding-top: 2rem;
    border-top: 1px solid #444;
    color: #ccc;
}

/* Form Styles */
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--dark-gray);
}

.form-control {
    width: 100%;
    padding: 12px;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--orange);
}

.form-control.error {
    border-color: #e74c3c;
}

.error-message {
    color: #e74c3c;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.success-message {
    color: var(--green);
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

/* Cards */
.card {
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow);
    overflow: hidden;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid #eee;
}

.card-body {
    padding: 1.5rem;
}

.card-footer {
    padding: 1.5rem;
    border-top: 1px solid #eee;
    background: var(--light-gray);
}

/* Status Badges */
.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-pending {
    background-color: #fef3c7;
    color: #92400e;
}

.status-confirmed {
    background-color: #d1fae5;
    color: #065f46;
}

.status-cancelled {
    background-color: #fee2e2;
    color: #991b1b;
}

/* Utility Classes */
.text-center { text-align: center; }
.text-left { text-align: left; }
.text-right { text-align: right; }

.mb-1 { margin-bottom: 0.5rem; }
.mb-2 { margin-bottom: 1rem; }
.mb-3 { margin-bottom: 1.5rem; }
.mb-4 { margin-bottom: 2rem; }

.mt-1 { margin-top: 0.5rem; }
.mt-2 { margin-top: 1rem; }
.mt-3 { margin-top: 1.5rem; }
.mt-4 { margin-top: 2rem; }

.d-none { display: none; }
.d-block { display: block; }
.d-flex { display: flex; }
.d-grid { display: grid; }

/* Loading Spinner */
.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid var(--orange);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 20px auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .hamburger {
        display: flex;
    }

    .nav-menu {
        display: none;
        flex-direction: column;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: white;
        box-shadow: var(--shadow);
        padding: 1rem;
    }

    .nav-menu.active {
        display: flex;
    }

    .hero h1 {
        font-size: 2.5rem;
    }

    .hero-buttons {
        flex-direction: column;
        align-items: center;
    }

    .features-grid,
    .destinations-grid {
        grid-template-columns: 1fr;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .footer-content {
        grid-template-columns: 1fr;
        text-align: center;
    }

    h1 { font-size: 2rem; }
    h2 { font-size: 1.75rem; }
    h3 { font-size: 1.5rem; }
}

@media (max-width: 480px) {
    .container {
        padding: 0 15px;
    }

    .hero {
        padding: 6rem 0;
    }

    .features,
    .destinations,
    .stats,
    .cta {
        padding: 3rem 0;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .btn {
        padding: 10px 20px;
        font-size: 0.9rem;
    }
}
</style>
<body>
    <!-- Navigation -->
    <nav class="navbar">
      <div class="container">
          <div class="nav-brand">
              <i class="fas fa-map-marker-alt"></i>
              <span>Smart Tourist Guide</span>
          </div>
          <div class="nav-menu" id="nav-menu">
              <a href="{{ url('/') }}" class="nav-link">Home</a>
              <a href="{{ route('discover.places') }}" class="nav-link">Discover Places</a>
              @auth
                  <a href="{{ route('accommodations.index') }}" class="nav-link">Accommodations</a>
                  <a href="{{ route('vehicles.index') }}" class="nav-link">Vehicles</a>
              @else
                  <a href="{{ route('login') }}" class="nav-link">Accommodations</a>
                  <a href="{{ route('login') }}" class="nav-link">Vehicles</a>
              @endauth
              <div class="nav-auth" id="nav-auth">
                  @if (Route::has('login'))
                      @auth
                          <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                      @else
                          <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
                          @if (Route::has('register'))
                              <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                          @endif
                      @endauth
                  @endif
              </div>
          </div>
          <div class="hamburger" id="hamburger">
              <span></span>
              <span></span>
              <span></span>
          </div>
      </div>
  </nav>

    <!-- Dashboard Header -->
    <section class="hero" style="padding: 3rem 0; background: linear-gradient(135deg, var(--orange), var(--gold));">
        <div class="hero-content">
            <h1 id="welcome-message">Welcome!!! Ready for your next adventure?</h1>
            <p>Plan your trips, manage bookings, and discover amazing destinations in Sri Lanka.</p>
        </div>
    </section>

    <!-- Dashboard Content -->
    <div class="container" style="padding: 2rem 0;">
        <!-- Current Bookings -->
        @auth
        <section class="destinations" style="padding: 2rem 0;">
            <div class="section-header">
                <h2>Your Current Bookings</h2>
                <p>Manage your upcoming trips and accommodations</p>
            </div>
            <div class="features-grid">
                @forelse($userBookings as $booking)
                    <div class="feature-card">
                        <div class="feature-icon">
                            @if($booking->item_type === 'accommodation')
                                <i class="fas fa-hotel"></i>
                            @else
                                <i class="fas fa-car"></i>
                            @endif
                        </div>
                        <h3>
                            @if($booking->item_type === 'accommodation')
                                Accommodation Booking
                            @else
                                Vehicle Rental
                            @endif
                        </h3>

                        @if($booking->item_type === 'accommodation' && $booking->accommodation)
                            <p><strong>Property:</strong> {{ $booking->accommodation->title }}</p>
                            @if($booking->accommodation->destination)
                                <p><strong>Location:</strong> {{ $booking->accommodation->destination->name }}</p>
                            @endif
                            <p><strong>Price:</strong> LKR {{ number_format($booking->accommodation->price_per_night) }}/night</p>
                        @elseif($booking->item_type === 'vehicle' && $booking->vehicle)
                            <p><strong>Vehicle:</strong> {{ ucfirst($booking->vehicle->type) }}</p>
                            <p><strong>Description:</strong> {{ Str::limit($booking->vehicle->description, 50) }}</p>
                            <p><strong>Price:</strong> LKR {{ number_format($booking->vehicle->price_per_day) }}/day</p>
                        @endif

                        <p><strong>Check-in:</strong> {{ $booking->start_date->format('M d, Y') }}</p>
                        <p><strong>Check-out:</strong> {{ $booking->end_date->format('M d, Y') }}</p>
                        <p><strong>Status:</strong>
                            <span class="status-badge status-{{ $booking->status }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </p>

                        <div style="margin-top: 1rem;">
                            <a href="{{ route('bookings.index') }}" class="btn btn-primary">View/Modify</a>
                        </div>
                    </div>
                @empty
                    <div class="feature-card" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                        <div class="feature-icon" style="margin: 0 auto 1rem;">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <h3>No Current Bookings</h3>
                        <p>You don't have any upcoming bookings yet. Start exploring and book your next adventure!</p>
                        <div style="margin-top: 1.5rem;">
                            <a href="{{ route('discover.places') }}" class="btn btn-primary">Discover Places</a>
                            <a href="{{ route('accommodations.index') }}" class="btn btn-secondary" style="margin-left: 0.5rem;">Book Accommodation</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>
        @else
        <section class="destinations" style="padding: 2rem 0;">
            <div class="section-header">
                <h2>Plan Your Next Adventure</h2>
                <p>Discover amazing destinations and book your perfect trip</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>Discover Places</h3>
                    <p>Explore beautiful destinations across Sri Lanka with our interactive map and detailed information.</p>
                    <a href="{{ route('discover.places') }}" class="btn btn-primary">Explore Now</a>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bed"></i>
                    </div>
                    <h3>Find Accommodation</h3>
                    <p>Browse and book comfortable accommodations for your stay in Sri Lanka.</p>
                    <a href="#" class="btn btn-primary">Browse Rooms</a>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <h3>Rent Vehicles</h3>
                    <p>Find the perfect vehicle for your Sri Lankan adventure - cars, vans, or tuk-tuks.</p>
                    <a href="#" class="btn btn-primary">Find Vehicles</a>
                </div>
            </div>
        </section>
        @endauth

        <!-- Tourist Place Locator -->
        <section class="features">
            <div class="section-header">
                <h2>Tourist Place Locator</h2>
                <p>Explore destinations on our interactive map</p>
            </div>
            <div style="height: 400px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow);">
                <div id="map" style="height: 100%; width: 100%;"></div>
            </div>
        </section>

        <!-- Suggested Destinations -->
        <section class="destinations">
            <div class="section-header">
                <h2>Suggested Tourist Destinations</h2>
                <p>Discover the most popular places to visit in Sri Lanka</p>
            </div>
            <div class="destinations-grid">
                @forelse($destinations as $destination)
                <div class="destination-card">
                    <div class="destination-image">
                        @if($destination->image_url)
                            <img src="{{ asset('storage/' . $destination->image_url) }}" alt="{{ $destination->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image" style="font-size: 3rem; color: #6c757d;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="destination-content">
                        <h3>{{ $destination->name }}</h3>
                        <div class="location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $destination->latitude ? 'Lat: ' . $destination->latitude : 'Sri Lanka' }}</span>
                        </div>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <span>{{ $destination->rating ? number_format($destination->rating, 1) . '/5' : 'No rating' }}</span>
                        </div>
                        <p class="description">{{ Str::limit($destination->description, 120) }}</p>
                        <a href="{{ route('destinations.show', $destination) }}" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
                @empty
                <div class="destination-card" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                    <div class="feature-icon" style="margin: 0 auto 1rem;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>No Destinations Available</h3>
                    <p>Destinations will appear here once they are added to the database.</p>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('destinations.create') }}" class="btn btn-primary">Add First Destination</a>
                        @endif
                    @endauth
                </div>
                @endforelse
            </div>
        </section>

        <!-- Quick Actions -->
        <section class="features">
            <div class="section-header">
                <h2>Quick Actions</h2>
                <p>Book services and search accommodations</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <h3>Vehicle Booking</h3>
                    <p>Book cars, tuk-tuks, vans, and buses for your Sri Lankan adventure.</p>
                    <a href="#" class="btn btn-secondary">Book a Vehicle</a>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>Room Search</h3>
                    <div style="margin-bottom: 1rem;">
                        <input type="text" id="room-search" placeholder="Search for rooms..." style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 1rem;">
                        <button onclick="searchRooms()" class="btn btn-primary" style="width: 100%;">Search Rooms</button>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3>Notifications and Alerts</h3>
                    <div id="notifications" style="text-align: left;">
                        <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 0.5rem; border-left: 4px solid var(--orange);">
                            <p style="margin: 0; font-size: 0.9rem;">Upcoming Booking: Colombo Trip - Check-in on 2024-12-01</p>
                        </div>
                        <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; border-left: 4px solid var(--green);">
                            <p style="margin: 0; font-size: 0.9rem;">Special Offer: 20% off on your next booking!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-brand">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Sri Lanka Explorer</span>
                    </div>
                    <p>Your gateway to discovering the beautiful island of Sri Lanka.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#">Tourist Places</a></li>
                        <li><a href="#">Accommodations</a></li>
                        <li><a href="#">Vehicle Rentals</a></li>
                        <li><a href="#contact">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>For Business</h4>
                    <ul>
                        <li><a href="#">List Your Property</a></li>
                        <li><a href="#">List Your Vehicle</a></li>
                        <li><a href="#">Admin Panel</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Sri Lanka Tourism. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            initializeDashboard();
        });

        function initializeDashboard() {
            // Initialize map for dashboard
            initializeDashboardMap();
        }

        function initializeDashboardMap() {
            const mapContainer = document.getElementById('map');
            if (mapContainer) {
                // Initialize Leaflet map centered on Sri Lanka
                const map = L.map('map').setView([7.8731, 80.7718], 7);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Add markers for destinations from database
                const destinations = @json($destinations);
                const colors = ['#ef4444', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4', '#84cc16'];

                destinations.forEach(function(dest, index) {
                    if (dest.latitude && dest.longitude) {
                        const marker = L.circleMarker([dest.latitude, dest.longitude], {
                            radius: 8,
                            fillColor: colors[index % colors.length],
                            color: '#fff',
                            weight: 2,
                            opacity: 1,
                            fillOpacity: 0.8
                        }).addTo(map);

                        marker.bindPopup('<b>' + dest.name + '</b><br>' +
                                      (dest.rating ? 'Rating: ' + dest.rating + '/5<br>' : '') +
                                      '<a href="/destinations/' + dest.id + '" class="text-blue-600">View Details</a>');
                    }
                });

                // Add fallback markers for popular Sri Lankan cities if no destinations have coordinates
                if (destinations.length === 0 || !destinations.some(d => d.latitude && d.longitude)) {
                    const fallbackDestinations = [
                        {name: 'Colombo', lat: 6.9271, lng: 79.8612, color: '#ef4444'},
                        {name: 'Negombo', lat: 7.2095, lng: 79.8384, color: '#3b82f6'},
                        {name: 'Galle', lat: 6.0535, lng: 80.2210, color: '#10b981'},
                        {name: 'Sigiriya', lat: 7.9570, lng: 80.7600, color: '#f59e0b'},
                        {name: 'Kandy', lat: 7.2906, lng: 80.6337, color: '#8b5cf6'}
                    ];

                    fallbackDestinations.forEach(function(dest) {
                        const marker = L.circleMarker([dest.lat, dest.lng], {
                            radius: 8,
                            fillColor: dest.color,
                            color: '#fff',
                            weight: 2,
                            opacity: 1,
                            fillOpacity: 0.8
                        }).addTo(map);

                        marker.bindPopup('<b>' + dest.name + '</b><br>Popular destination in Sri Lanka');
                    });
                }
            }
        }

        function searchRooms() {
            const searchQuery = document.getElementById('room-search').value;
            if (searchQuery.trim()) {
                alert('Searching for: ' + searchQuery);
            } else {
                alert('Please enter a search term');
            }
        }

        // Mobile menu toggle
        document.getElementById('hamburger').addEventListener('click', function() {
            const navMenu = document.getElementById('nav-menu');
            navMenu.classList.toggle('active');
        });
    </script>
</body>
</html>
