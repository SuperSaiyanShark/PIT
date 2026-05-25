<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">{{ $department->name }}</h3>
                        <div class="space-x-2">
                            <a href="{{ route('departments.edit', $department->id) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                                Edit
                            </a>
                            <a href="{{ route('departments.index') }}"
                                class="bg-gray-400 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-gray-600 text-sm">Description</p>
                            <p class="font-semibold">{{ $department->description ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Department Head</p>
                            <p class="font-semibold">{{ $department->head->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Building</p>
                            <p class="font-semibold">{{ $department->building ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Phone</p>
                            <p class="font-semibold">{{ $department->phone ?? 'N/A' }}</p>
                        </div>
                    </div>

                    @if($department->wards->count() > 0)
                        <div class="mt-8">
                            <h4 class="text-lg font-semibold mb-4">Wards</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ward Name</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Capacity</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($department->wards as $ward)
                                            <tr>
                                                <td class="px-6 py-4">{{ $ward->wardName }}</td>
                                                <td class="px-6 py-4">{{ $ward->location ?? 'N/A' }}</td>
                                                <td class="px-6 py-4">{{ $ward->capacity }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
