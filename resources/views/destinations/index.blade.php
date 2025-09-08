@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
    </div>

    <h2 class="text-3xl font-bold text-gray-800 mb-6">Explore Destinations</h2>

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
@endsection

