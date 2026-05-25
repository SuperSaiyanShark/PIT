<x-app-layout>
    <div class="min-h-screen bg-[#F5F9FA] p-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-[#134E5E]">Bed Management</h2>
                    <p class="text-sm text-gray-500">Manage beds in {{ $ward->wardName }} ({{ $ward->wardNumber }})</p>
                </div>
                <a href="{{ route('my-wards.index') }}"
                    class="text-[#00B2D1] font-bold text-sm uppercase tracking-widest hover:underline">
                    ← Back to Wards
                </a>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-50 p-4 rounded-xl text-center">
                        <p class="text-sm text-gray-600">Total Beds</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $beds->count() }}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-xl text-center">
                        <p class="text-sm text-gray-600">Available</p>
                        <p class="text-2xl font-bold text-green-600">{{ $beds->where('status', 'Available')->count() }}
                        </p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-xl text-center">
                        <p class="text-sm text-gray-600">Occupied</p>
                        <p class="text-2xl font-bold text-red-600">{{ $beds->where('status', 'Occupied')->count() }}</p>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-xl text-center">
                        <p class="text-sm text-gray-600">Maintenance</p>
                        <p class="text-2xl font-bold text-yellow-600">
                            {{ $beds->where('status', 'Maintenance')->count() }}
                        </p>
                    </div>
                </div>

                <table class="min-w-full divide-y divide-gray-200 border">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Bed
                                Number</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">
                                Status</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">
                                Patient Name</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($beds as $bed)
                            <tr>
                                <td class="px-6 py-4 font-medium">{{ $bed->bedNumber }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            @if($bed->status == 'Available') bg-green-100 text-green-800
                                            @elseif($bed->status == 'Occupied') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ $bed->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $bed->patient_name ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    @if($bed->status == 'Available')
                                        <a href="{{ route('my-wards.beds.assign.form', [$bed->bedNumber, $ward->wardNumber]) }}"
                                            class="text-blue-600 hover:text-blue-900">Assign Patient</a>
                                    @elseif($bed->status == 'Occupied')
                                        <form action="{{ route('my-wards.beds.vacate', [$bed->bedNumber, $ward->wardNumber]) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-orange-600 hover:text-orange-900"
                                                onclick="return confirm('Vacate this bed?')">Vacate Bed</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>