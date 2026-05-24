<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Staff Member') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-cyan-500 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <form action="{{ route('module4.staff.update', $staff) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-white mb-2">
                                Full Name
                            </label>
                            <input type="text" id="name" name="name" 
                                   class="block w-full px-3 py-2 border border-teal-300 bg-teal-100 text-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                                   value="{{ $staff->name }}" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-white mb-2">
                                Email
                            </label>
                            <input type="email" id="email" name="email" 
                                   class="block w-full px-3 py-2 border border-teal-300 bg-teal-100 text-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                                   value="{{ $staff->email }}" required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-white mb-2">
                                Role
                            </label>
                            <select id="role" name="role" 
                                    class="block w-full px-3 py-2 border border-teal-300 bg-teal-100 text-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500">
                                <option value="doctor" {{ $staff->role === 'doctor' ? 'selected' : '' }}>Doctor</option>
                                <option value="nurse" {{ $staff->role === 'nurse' ? 'selected' : '' }}>Nurse</option>
                                <option value="administrator" {{ $staff->role === 'administrator' ? 'selected' : '' }}>Administrator</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Specialization -->
                        <div>
                            <label for="specialization" class="block text-sm font-medium text-white mb-2">
                                Specialization (Optional)
                            </label>
                            <input type="text" id="specialization" name="specialization" 
                                   class="block w-full px-3 py-2 border border-teal-300 bg-teal-100 text-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                                   value="{{ $staff->specialization }}">
                            @error('specialization')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- License Number -->
                        <div>
                            <label for="license_number" class="block text-sm font-medium text-white mb-2">
                                License Number (Optional)
                            </label>
                            <input type="text" id="license_number" name="license_number" 
                                   class="block w-full px-3 py-2 border border-teal-300 bg-teal-100 text-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                                   value="{{ $staff->license_number }}">
                            @error('license_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div>
                            <label for="bio" class="block text-sm font-medium text-white mb-2">
                                Biography (Optional)
                            </label>
                            <textarea id="bio" name="bio" rows="4"
                                      class="block w-full px-3 py-2 border border-teal-300 bg-teal-100 text-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500">{{ $staff->bio }}</textarea>
                            @error('bio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Active Status -->
                        <div>
                            <label for="is_active" class="flex items-center">
                                <input type="checkbox" id="is_active" name="is_active" value="1" 
                                       class="rounded bg-teal-100 border-teal-300 text-white focus:ring-teal-500"
                                       {{ $staff->is_active ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-white">Active</span>
                            </label>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-4">
                            <button type="submit" class="px-4 py-2 bg-white text-teal-600 rounded-md hover:bg-teal-100 focus:outline-none focus:ring-2 focus:ring-white">
                                Update Staff Member
                            </button>
                            <a href="{{ route('module4.staff.show', $staff) }}" class="px-4 py-2 bg-teal-400 text-white rounded-md hover:bg-teal-300">
                                Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
