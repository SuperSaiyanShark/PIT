<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Treatment Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-cyan-500 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="text-sm font-semibold text-cyan-100">Treatment Name</label>
                            <p class="text-lg mt-2">{{ $treatment->treatment_name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-cyan-100">Status</label>
                            <p class="text-lg mt-2">
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                    @if ($treatment->status === 'scheduled')
                                        bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                    @elseif ($treatment->status === 'in-progress')
                                        bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                    @else
                                        bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                    @endif
                                ">
                                    {{ ucfirst(str_replace('-', ' ', $treatment->status)) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="text-sm font-semibold text-cyan-100">Treatment Date</label>
                            <p class="text-lg mt-2">{{ $treatment->treatment_date->format('F d, Y') }}</p>
                        </div>
                        @if($treatment->treatment_time)
                            <div>
                                <label class="text-sm font-semibold text-cyan-100">Treatment Time</label>
                                <p class="text-lg mt-2">{{ $treatment->treatment_time->format('g:i A') }}</p>
                            </div>
                        @endif
                    </div>

                    @if ($treatment->description)
                        <div class="mb-6">
                            <label class="text-sm font-semibold text-cyan-100">Description</label>
                            <p class="text-base mt-2 bg-cyan-400 p-4 rounded">{{ $treatment->description }}</p>
                        </div>
                    @endif

                    @if ($treatment->notes)
                        <div class="mb-6">
                            <label class="text-sm font-semibold text-cyan-100">Additional Notes</label>
                            <p class="text-base mt-2 bg-cyan-400 p-4 rounded">{{ $treatment->notes }}</p>
                        </div>
                    @endif

                    <div class="border-t border-teal-400 pt-6">
                        <p class="text-sm text-cyan-100 mb-4">
                            <strong>Created:</strong> {{ $treatment->created_at->format('M d, Y g:i A') }}<br>
                            <strong>Last Updated:</strong> {{ $treatment->updated_at->format('M d, Y g:i A') }}
                        </p>

                        <div class="flex gap-4">
                            <a href="{{ route('module4.treatments.edit', $treatment) }}" 
                               class="px-4 py-2 bg-white text-cyan-600 rounded-md hover:bg-cyan-100">
                                Edit Treatment
                            </a>
                            <form action="{{ route('module4.treatments.destroy', $treatment) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                                        onclick="return confirm('Are you sure you want to delete this treatment?')">
                                    Delete Treatment
                                </button>
                            </form>
                            <a href="{{ route('module4.treatments.index') }}" class="px-4 py-2 bg-cyan-400 text-white rounded-md hover:bg-cyan-300">
                                Back to Treatments
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
