<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('My Treatments') }}
            </h2>
            <a href="{{ route('module4.treatments.create') }}" class="px-4 py-2 bg-white text-cyan-600 rounded-md hover:bg-cyan-100">
                Record New Treatment
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($treatments->count())
                <div class="space-y-4">
                    @foreach ($treatments as $treatment)
                        <div class="bg-cyan-500 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-white flex justify-between items-center">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold">{{ $treatment->treatment_name }}</h3>
                                    <p class="text-sm text-cyan-100 mt-1">
                                        <strong>Date:</strong> {{ $treatment->treatment_date->format('M d, Y') }}
                                        @if($treatment->treatment_time)
                                            at {{ $treatment->treatment_time->format('g:i A') }}
                                        @endif
                                    </p>
                                    @if($treatment->description)
                                        <p class="text-sm text-teal-100">
                                            <strong>Description:</strong> {{ Str::limit($treatment->description, 100) }}
                                        </p>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                        @if ($treatment->status === 'scheduled')
                                            bg-yellow-100 text-yellow-800
                                        @elseif ($treatment->status === 'in-progress')
                                            bg-blue-100 text-blue-800
                                        @else
                                            bg-green-100 text-green-800
                                        @endif
                                    ">
                                        {{ ucfirst(str_replace('-', ' ', $treatment->status)) }}
                                    </span>
                                    <div class="mt-3 space-x-2">
                                        <a href="{{ route('module4.treatments.show', $treatment) }}" class="text-white hover:underline text-sm">
                                            View
                                        </a>
                                        <a href="{{ route('module4.treatments.edit', $treatment) }}" class="text-cyan-100 hover:underline text-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('module4.treatments.destroy', $treatment) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-200 hover:underline text-sm"
                                                    onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-cyan-500 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-cyan-100 mb-4">You have no treatments recorded.</p>
                    <a href="{{ route('module4.treatments.create') }}" class="inline-block px-4 py-2 bg-white text-cyan-600 rounded-md hover:bg-cyan-100">
                        Record Your First Treatment
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
