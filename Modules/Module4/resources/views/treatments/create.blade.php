<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Record New Treatment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-cyan-500 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <form action="{{ route('treatments.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Treatment Name -->
                        <div>
                            <label for="treatment_name" class="block text-sm font-medium text-white mb-2">
                                Treatment Name
                            </label>
                            <input type="text" id="treatment_name" name="treatment_name" 
                                    class="block w-full px-3 py-2 border border-cyan-300 bg-cyan-100 text-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-cyan-500 focus:border-cyan-500">
                                   value="{{ old('treatment_name') }}" placeholder="e.g., Physical Therapy" required>
                            @error('treatment_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Treatment Date -->
                        <div>
                            <label for="treatment_date" class="block text-sm font-medium text-white mb-2">
                                Treatment Date
                            </label>
                            <input type="date" id="treatment_date" name="treatment_date" 
                                   class="block w-full px-3 py-2 border border-teal-300 bg-teal-100 text-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                                   value="{{ old('treatment_date') }}" required>
                            @error('treatment_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Treatment Time -->
                        <div>
                            <label for="treatment_time" class="block text-sm font-medium text-white mb-2">
                                Treatment Time (Optional)
                            </label>
                            <input type="time" id="treatment_time" name="treatment_time" 
                                   class="block w-full px-3 py-2 border border-teal-300 bg-teal-100 text-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                                   value="{{ old('treatment_time') }}">
                            @error('treatment_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-white mb-2">
                                Description
                            </label>
                            <textarea id="description" name="description" rows="4"
                                      class="block w-full px-3 py-2 border border-cyan-300 bg-cyan-100 text-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-cyan-500 focus:border-cyan-500"
                                      placeholder="Describe the treatment...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-white mb-2">
                                Additional Notes
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="block w-full px-3 py-2 border border-teal-300 bg-teal-100 text-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                                      placeholder="Any additional information...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-4">
                            <button type="submit" class="px-4 py-2 bg-white text-teal-600 rounded-md hover:bg-teal-100 focus:outline-none focus:ring-2 focus:ring-white">
                                Record Treatment
                            </button>
                            <a href="{{ route('treatments.index') }}" class="px-4 py-2 bg-teal-400 text-white rounded-md hover:bg-teal-300">
                                Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
