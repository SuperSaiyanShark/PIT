<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Schedules</h3>
                        <a href="{{ route('schedules.create') }}"
                            class="bg-[#00B2D1] hover:bg-[#134E5E] text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                            + Add New Schedule
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Staff Member</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">End Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Shift</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($schedules as $schedule)
                                    <tr>
                                        <td class="px-6 py-4 font-semibold">{{ $schedule->staff->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">{{ $schedule->start_date?->format('M d, Y') }}</td>
                                        <td class="px-6 py-4">{{ $schedule->end_date?->format('M d, Y') }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-block bg-purple-100 text-purple-800 px-2 py-1 rounded text-sm">{{ $schedule->shift_type ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-block bg-{{ $schedule->status === 'active' ? 'green' : 'gray' }}-100 text-{{ $schedule->status === 'active' ? 'green' : 'gray' }}-800 px-2 py-1 rounded text-sm">{{ ucfirst($schedule->status) }}</span>
                                            <a href="{{ route('schedules.show', $schedule->id) }}"
                                                class="text-blue-600 hover:text-blue-900">View</a>
                                            <a href="{{ route('schedules.edit', $schedule->id) }}"
                                                class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                            <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No schedules found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
