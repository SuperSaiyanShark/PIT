<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-medium mb-6">Edit Schedule</h3>

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('schedules.update', $schedule->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Staff Member</label>
                            <select name="staff_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00B2D1]" required>
                                <option value="">Select Staff Member</option>
                                @foreach($staff as $member)
                                    <option value="{{ $member->id }}" {{ old('staff_id', $schedule->staff_id) == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                @endforeach
                            </select>
                            @error('staff_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                            <select name="department_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00B2D1]" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id', $schedule->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                            <input type="date" name="start_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00B2D1]"
                                value="{{ old('start_date', $schedule->start_date?->format('Y-m-d')) }}" required>
                            @error('start_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                            <input type="date" name="end_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00B2D1]"
                                value="{{ old('end_date', $schedule->end_date?->format('Y-m-d')) }}">
                            @error('end_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Shift</label>
                            <select name="shift" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00B2D1]">
                                <option value="">Select Shift</option>
                                <option value="Morning" {{ old('shift', $schedule->shift) == 'Morning' ? 'selected' : '' }}>Morning</option>
                                <option value="Afternoon" {{ old('shift', $schedule->shift) == 'Afternoon' ? 'selected' : '' }}>Afternoon</option>
                                <option value="Night" {{ old('shift', $schedule->shift) == 'Night' ? 'selected' : '' }}>Night</option>
                            </select>
                            @error('shift')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="bg-[#00B2D1] hover:bg-[#134E5E] text-white px-6 py-2 rounded-lg font-bold transition">
                                Update Schedule
                            </button>
                            <a href="{{ route('schedules.index') }}" class="bg-gray-400 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-bold transition">
                                Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
