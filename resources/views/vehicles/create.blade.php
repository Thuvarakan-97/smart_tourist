<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle - Smart Tourist</title>
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
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-white hover:bg-blue-700 transition-colors">
                    <i class="fas fa-home mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('vehicles.create') }}" class="flex items-center px-4 py-3 bg-blue-700 text-white">
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
                <div class="max-w-2xl mx-auto">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Vehicle</h2>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <form method="POST" action="{{ route('vehicles.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Vehicle Type -->
                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Vehicle Type</label>
                                    <select name="type" id="type" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">Select Vehicle Type</option>
                                        <option value="car" {{ old('type') == 'car' ? 'selected' : '' }}>Car</option>
                                        <option value="van" {{ old('type') == 'van' ? 'selected' : '' }}>Van</option>
                                        <option value="tuk-tuk" {{ old('type') == 'tuk-tuk' ? 'selected' : '' }}>Tuk-Tuk</option>
                                    </select>
                                    @error('type')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Price per Day -->
                                <div>
                                    <label for="price_per_day" class="block text-sm font-medium text-gray-700 mb-2">Price per Day (LKR)</label>
                                    <input type="number" name="price_per_day" id="price_per_day" value="{{ old('price_per_day') }}" step="0.01" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    @error('price_per_day')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="md:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea name="description" id="description" rows="3" required
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Available From -->
                                <div>
                                    <label for="available_from" class="block text-sm font-medium text-gray-700 mb-2">Available From</label>
                                    <input type="date" name="available_from" id="available_from" value="{{ old('available_from') }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    @error('available_from')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Available To -->
                                <div>
                                    <label for="available_to" class="block text-sm font-medium text-gray-700 mb-2">Available To</label>
                                    <input type="date" name="available_to" id="available_to" value="{{ old('available_to') }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    @error('available_to')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Image Upload -->
                                <div class="md:col-span-2">
                                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Vehicle Image</label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                        <input type="file" name="image" id="image" accept="image/*"
                                               class="hidden" onchange="previewImage(this)">
                                        <label for="image" class="cursor-pointer">
                                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                            <p class="text-gray-600">Click to upload image or drag and drop</p>
                                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG up to 5MB</p>
                                        </label>
                                    </div>
                                    <div id="imagePreview" class="mt-4 hidden">
                                        <img id="preview" src="" alt="Preview" class="max-w-xs rounded-lg shadow-md">
                                    </div>
                                    @error('image')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="flex justify-end space-x-3 mt-6">
                                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                                    Cancel
                                </a>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    <i class="fas fa-save mr-2"></i>Save Vehicle
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            const previewDiv = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewDiv.classList.remove('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Drag and drop functionality
        const dropZone = document.querySelector('.border-dashed');

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-blue-500', 'bg-blue-50');
        });

        dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-blue-500', 'bg-blue-50');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-blue-500', 'bg-blue-50');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('image').files = files;
                previewImage(document.getElementById('image'));
            }
        });
    </script>
</body>
</html>


