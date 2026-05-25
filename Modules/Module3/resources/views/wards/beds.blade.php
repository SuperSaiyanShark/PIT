<x-app-layout>
    <div class="py-12 px-6">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-[#134E5E]">
                Beds in {{ $wardInfo->wardnumber ?? $wardNumber }}
            </h2>
            <div class="mt-2 p-4 bg-gray-50 rounded-xl">
                <p>📍 Location: {{ $wardInfo->location ?? 'N/A' }}</p>
                <p>📞 Extension: {{ $wardInfo->telextn ?? 'N/A' }}</p>
                <p>🛏️ Occupancy: {{ $beds->where('is_occupied', true)->count() }} / {{ $beds->count() }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($beds as $bed)
                <div class="p-4 rounded-xl border-2 
                    {{ $bed->status == 'Available' ? 'border-green-500 bg-green-50' : '' }}
                    {{ $bed->status == 'Occupied' ? 'border-red-500 bg-red-50' : '' }}
                    {{ $bed->status == 'Maintenance' ? 'border-yellow-500 bg-yellow-50' : '' }}">
                    
                    <p class="font-bold text-lg">Bed #{{ $bed->bedNumber }}</p>
                    <p class="text-xs uppercase font-semibold">{{ $bed->status }}</p>
                    
                    @if($bed->patient_name)
                        <p class="text-sm mt-2 font-bold text-red-700">👤 {{ $bed->patient_name }}</p>
                    @endif
                    
                    <div class="mt-3 space-y-2">
                        @if($bed->status == 'Available')
                            <a href="{{ route('beds.assign.form', [$wardNumber, $bed->bedNumber]) }}" 
                               class="block text-center text-xs bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                Assign Patient
                            </a>
                        @endif
                        
                        @if($bed->patient_name)
                            <form action="{{ route('beds.vacate', [$wardNumber, $bed->bedNumber]) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-xs bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    Discharge
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>