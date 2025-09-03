@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('destinations.index') }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i>Back to Destinations
            </a>
        </div>

        <!-- Destination Header -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="h-64 bg-gray-200 flex items-center justify-center">
                @if($destination->image_url)
                    <img src="{{ asset('storage/' . $destination->image_url) }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
                @else
                    <div class="text-center">
                        <i class="fas fa-image text-6xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500 text-lg">No Image Available</p>
                    </div>
                @endif
            </div>
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $destination->name }}</h1>
                        <div class="flex items-center mb-2">
                            @if($destination->rating)
                                <div class="flex items-center mr-4">
                                    <i class="fas fa-star text-yellow-500 mr-1"></i>
                                    <span class="text-gray-700">{{ $destination->rating }}/5</span>
                                </div>
                            @endif
                            @if($destination->latitude && $destination->longitude)
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    <span>{{ $destination->latitude }}, {{ $destination->longitude }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-map mr-2"></i>View on Map
                    </button>
                </div>

                <p class="text-gray-700 text-lg leading-relaxed mb-6">{{ $destination->description }}</p>
            </div>
        </div>

        <!-- Available Accommodations -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Available Accommodations</h2>
            @if($destination->accommodations->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($destination->accommodations as $accommodation)
                    <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="h-32 bg-gray-200 flex items-center justify-center">
                            @if($accommodation->image_url)
                                <img src="{{ asset('storage/' . $accommodation->image_url) }}" alt="{{ $accommodation->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center">
                                    <i class="fas fa-bed text-2xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-2">{{ $accommodation->title }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($accommodation->description, 100) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-green-600">${{ number_format($accommodation->price_per_night, 2) }}/night</span>
                                <a href="{{ route('accommodations.show', $accommodation) }}" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition-colors">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No accommodations available at this destination yet.</p>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('accommodations.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow text-center">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-bed text-4xl text-green-600"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Find Accommodations</h3>
                <p class="text-sm text-gray-600">Browse all available places to stay</p>
            </a>

            <a href="{{ route('vehicles.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow text-center">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-car text-4xl text-blue-600"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Rent Vehicles</h3>
                <p class="text-sm text-gray-600">Find transportation for your trip</p>
            </a>
        </div>
    </div>
</div>
@endsection




