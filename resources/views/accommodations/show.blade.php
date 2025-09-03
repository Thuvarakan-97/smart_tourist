@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('accommodations.index') }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i>Back to Accommodations
            </a>
        </div>

        <!-- Accommodation Header -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="h-64 bg-gray-200 flex items-center justify-center">
                @if($accommodation->image_url)
                    <img src="{{ asset('storage/' . $accommodation->image_url) }}" alt="{{ $accommodation->title }}" class="w-full h-full object-cover">
                @else
                    <div class="text-center">
                        <i class="fas fa-bed text-6xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500 text-lg">No Image Available</p>
                    </div>
                @endif
            </div>
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $accommodation->title }}</h1>
                        <div class="flex items-center mb-2">
                            <div class="flex items-center mr-4">
                                <i class="fas fa-map-marker-alt text-gray-600 mr-1"></i>
                                <span class="text-gray-700">{{ $accommodation->destination->name ?? 'Unknown Location' }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-dollar-sign text-green-600 mr-1"></i>
                                <span class="text-lg font-bold text-green-600">${{ number_format($accommodation->price_per_night, 2) }}/night</span>
                            </div>
                        </div>
                    </div>
                    @if(auth()->user()->role === 'tourist')
                        <button onclick="openBookingModal()" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-calendar-plus mr-2"></i>Book Now
                        </button>
                    @endif
                </div>

                <p class="text-gray-700 text-lg leading-relaxed mb-6">{{ $accommodation->description }}</p>

                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <strong>Available From:</strong> {{ $accommodation->available_from->format('M d, Y') }}
                    </div>
                    <div>
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <strong>Available To:</strong> {{ $accommodation->available_to->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->role === 'tourist')
        <!-- Booking Modal -->
        <div id="bookingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Book Accommodation</h3>
                        <form action="{{ route('book.accommodation', $accommodation) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Check-in Date</label>
                                <input type="date" name="start_date" required min="{{ $accommodation->available_from->format('Y-m-d') }}" max="{{ $accommodation->available_to->format('Y-m-d') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Check-out Date</label>
                                <input type="date" name="end_date" required min="{{ $accommodation->available_from->format('Y-m-d') }}" max="{{ $accommodation->available_to->format('Y-m-d') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="closeBookingModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Book Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function openBookingModal() {
    document.getElementById('bookingModal').classList.remove('hidden');
}

function closeBookingModal() {
    document.getElementById('bookingModal').classList.add('hidden');
}
</script>
@endsection



