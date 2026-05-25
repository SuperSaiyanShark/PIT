<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Schedule Details</h3>
                        <div class="space-x-2">
                            <a href="{{ route('schedules.edit', $schedule->id) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                                Edit
                            </a>
                            <a href="{{ route('schedules.index') }}"
                                class="bg-gray-400 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600 text-sm">Staff Member</p>
                            <p class="font-semibold text-lg">{{ $schedule->staff->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Department</p>
                            <p class="font-semibold text-lg">{{ $schedule->department->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Start Date</p>
                            <p class="font-semibold text-lg">{{ $schedule->start_date?->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">End Date</p>
                            <p class="font-semibold text-lg">{{ $schedule->end_date?->format('M d, Y') ?? 'Ongoing' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Shift</p>
                            <p class="font-semibold text-lg">
                                <span class="inline-block bg-purple-100 text-purple-800 px-3 py-1 rounded">{{ $schedule->shift ?? 'N/A' }}</span>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
