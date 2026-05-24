<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between mb-6">
            <h3 class="text-2xl font-bold">Manage Beds (Ward ID: {{ $id }})</h3>
            <a href="{{ route('dashboard') }}" class="text-indigo-600">← Back to Wards</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($beds as $bed)
                <div class="bg-white p-4 rounded-xl border shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="font-bold text-lg">{{ $bed->bed_number }}</p>
                        <span
                            class="px-2 py-1 text-xs rounded-full {{ $bed->status == 'Available' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $bed->status }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">
                        Patient: {{ $bed->patient ?? 'None' }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>