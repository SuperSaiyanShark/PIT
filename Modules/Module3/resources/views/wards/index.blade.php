<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Ward Management</h3>
                        <a href="{{ route('module3.my-wards.create') }}"
                            class="bg-[#00B2D1] hover:bg-[#134E5E] text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                            {{-- FIXED: Using correct module3.my-wards.create route --}}
                            + Add New Ward
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ward
                                        Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ward
                                        Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Beds /
                                        Capacity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($wards as $ward)
                                    <tr>
                                        <td class="px-6 py-4">{{ $ward->wardName }}</td>
                                        <td class="px-6 py-4">{{ $ward->wardNumber }}</td>
                                        <td class="px-6 py-4">{{ $ward->location ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">
                                            <span class="font-bold text-[#00B2D1]">{{ $ward->beds->count() }}</span> /
                                            {{ $ward->capacity }}
                                        </td>
                                        <td class="px-6 py-4 space-x-2">
                                            <a href="{{ route('module3.my-wards.beds', $ward->wardNumber) }}"
                                                class="text-green-600 hover:text-green-900">View Beds</a>
                                            <a href="{{ route('module3.my-wards.edit', $ward->allocationid) }}"
                                                class="text-blue-600 hover:text-blue-900">Edit</a>
                                            <form action="{{ route('module3.my-wards.destroy', $ward->allocationid) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($wards->isEmpty())
                        <p class="text-center text-gray-500 py-4">No wards found. Click "Add New Ward" to create one.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>