<x-app-layout>
    <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 min-h-screen pb-12">
        
        <div class="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white py-8 px-6 shadow-lg mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center max-w-6xl mx-auto gap-6">
                <div>
                    <h1 class="text-4xl font-bold tracking-wide">WELLMEADOWS HOSPITAL</h1>
                    <p class="text-cyan-100 mt-2 text-lg uppercase tracking-wider font-medium flex items-center gap-2">
                        <span>{{ __('Treatment Profiler') }}</span>
                        <span class="text-cyan-300/50">•</span>
                        <span class="text-sm normal-case tracking-normal text-cyan-200/90">Inspecting clinical verification instances</span>
                    </p>
                </div>
                <div class="flex flex-wrap gap-3 w-full md:w-auto justify-end">
                    <a href="{{ route('module4.treatments.index') }}" class="bg-white text-cyan-600 px-5 py-2.5 rounded-lg font-bold hover:bg-cyan-50 transition shadow-md text-sm text-center flex-1 md:flex-none">
                        Back to Treatments List
                    </a>
                    <a href="{{ route('module4.dashboard') }}" class="bg-cyan-700 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-cyan-800 transition shadow-md text-sm text-center flex-1 md:flex-none">
                        Module 4 Dashboard
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-b border-gray-100 pb-8">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Treatment Identity</label>
                            <p class="text-xl font-bold text-gray-800 mt-1.5">{{ $treatment->treatment_name }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Current Status</label>
                            <div class="mt-1.5">
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-bold tracking-wide
                                    @if ($treatment->status === 'scheduled') bg-yellow-50 text-yellow-800 border border-yellow-200
                                    @elif ($treatment->status === 'in-progress') bg-blue-50 text-blue-800 border border-blue-200
                                    @else bg-green-50 text-green-800 border border-green-200 @endif">
                                    {{ ucfirst(str_replace('-', ' ', $treatment->status)) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-b border-gray-100 pb-8">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Scheduled Execution Date</label>
                            <p class="text-base font-semibold text-gray-700 mt-1.5 flex items-center gap-2">
                                <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $treatment->treatment_date->format('F d, Y') }}
                            </p>
                        </div>
                        @if($treatment->treatment_time)
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Target Timeframe</label>
                                <p class="text-base font-semibold text-gray-700 mt-1.5 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $treatment->treatment_time->format('g:i A') }}
                                </p>
                            </div>
                        @endif
                    </div>

                    @if ($treatment->description)
                        <div class="pt-8 border-b border-gray-100 pb-8">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Clinical Description & Directives</label>
                            <p class="text-sm text-gray-600 mt-2 bg-gray-50 border border-gray-100 p-4 rounded-2xl leading-relaxed font-normal">{{ $treatment->description }}</p>
                        </div>
                    @endif

                    @if ($treatment->notes)
                        <div class="pt-8 pb-4">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Special Internal Notes</label>
                            <p class="text-sm text-gray-600 mt-2 bg-amber-50/50 border border-amber-100 p-4 rounded-2xl leading-relaxed font-normal">{{ $treatment->notes }}</p>
                        </div>
                    @endif

                    <div class="border-t border-gray-100 pt-6 mt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                        <p class="text-xs text-gray-400 font-medium">
                            <strong>Logged:</strong> {{ $treatment->created_at->format('M d, Y \a\t g:i A') }}<br>
                            <strong>Last Modification:</strong> {{ $treatment->updated_at->format('M d, Y \a\t g:i A') }}
                        </p>

                        <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                            <a href="{{ route('module4.treatments.edit', $treatment) }}" 
                               class="px-5 py-2.5 bg-gradient-to-r from-cyan-600 to-cyan-500 text-white rounded-xl font-semibold hover:from-cyan-500 hover:to-cyan-400 transition shadow-md text-sm text-center flex-1 sm:flex-none">
                                Edit Record
                            </a>
                            <form action="{{ route('module4.treatments.destroy', $treatment) }}" method="POST" class="inline flex-1 sm:flex-none">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-5 py-2.5 bg-red-50 text-red-600 border border-red-100 rounded-xl font-semibold hover:bg-red-100 transition text-sm text-center"
                                        onclick="return confirm('Are you completely sure you want to scrub this treatment entry?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>