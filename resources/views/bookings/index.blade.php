@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">
            @if(auth()->user()->role === 'room_owner')
                Accommodation Bookings
            @elseif(auth()->user()->role === 'vehicle_owner')
                Vehicle Bookings
            @else
                All Bookings
            @endif
        </h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <i class="fas fa-calendar text-3xl text-blue-600 mr-4"></i>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $bookings->count() }}</h3>
                    <p class="text-sm text-gray-600">Total Bookings</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <i class="fas fa-clock text-3xl text-yellow-600 mr-4"></i>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $bookings->where('status', 'pending')->count() }}</h3>
                    <p class="text-sm text-gray-600">Pending</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <i class="fas fa-check text-3xl text-green-600 mr-4"></i>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $bookings->where('status', 'confirmed')->count() }}</h3>
                    <p class="text-sm text-gray-600">Confirmed</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <i class="fas fa-times text-3xl text-red-600 mr-4"></i>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $bookings->where('status', 'cancelled')->count() }}</h3>
                    <p class="text-sm text-gray-600">Cancelled</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Booking Requests</h2>
        </div>

        @if($bookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tourist</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                @if(auth()->user()->role === 'room_owner')
                                    Accommodation
                                @elseif(auth()->user()->role === 'vehicle_owner')
                                    Vehicle
                                @else
                                    Item
                                @endif
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($bookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $booking->tourist->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->tourist->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    @if($booking->item_type === 'accommodation')
                                        {{ $booking->accommodation->title ?? 'N/A' }}
                                    @elseif($booking->item_type === 'vehicle')
                                        {{ $booking->vehicle ? ucfirst($booking->vehicle->type) : 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="text-sm text-gray-500">
                                    @if($booking->item_type === 'accommodation')
                                        {{ $booking->accommodation->destination->name ?? 'N/A' }}
                                    @elseif($booking->item_type === 'vehicle')
                                        {{ $booking->vehicle ? Str::limit($booking->vehicle->description, 50) : 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $booking->start_date->format('M d, Y') }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    to {{ $booking->end_date->format('M d, Y') }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $booking->start_date->diffInDays($booking->end_date) }} days
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                    @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($booking->status === 'pending')
                                    <div class="flex space-x-2">
                                        <form method="POST" action="{{ route('bookings.update-status', $booking) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="bg-green-500 text-white px-3 py-2 rounded text-sm hover:bg-green-600 transition-colors">
                                                <i class="fas fa-check mr-1"></i>Approve
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('bookings.update-status', $booking) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded text-sm hover:bg-red-600 transition-colors">
                                                <i class="fas fa-times mr-1"></i>Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-400">
                                        @if($booking->status === 'confirmed')
                                            <i class="fas fa-check text-green-600 mr-1"></i>Approved
                                        @else
                                            <i class="fas fa-times text-red-600 mr-1"></i>Rejected
                                        @endif
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-8 text-center">
                <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No bookings yet</h3>
                <p class="text-gray-500">
                    @if(auth()->user()->role === 'room_owner')
                        When tourists book your accommodations, they will appear here for your approval.
                    @elseif(auth()->user()->role === 'vehicle_owner')
                        When tourists rent your vehicles, they will appear here for your approval.
                    @else
                        No bookings found.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
@endsection

