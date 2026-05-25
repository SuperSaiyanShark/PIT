<x-app-layout>
    <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 min-h-screen pb-12">
        
        <div class="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white py-8 px-6 shadow-lg mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center max-w-6xl mx-auto gap-6">
                <div>
                    <h1 class="text-4xl font-bold tracking-wide">WELLMEADOWS HOSPITAL</h1>
                    <p class="text-cyan-100 mt-2 text-lg uppercase tracking-wider font-medium flex items-center gap-2">
                        <span>{{ __('Clinical Treatments Log') }}</span>
                        <span class="text-cyan-300/50">•</span>
                        <span class="text-sm normal-case tracking-normal text-cyan-200/90">Review and manage records of treatments and clinical operations</span>
                    </p>
                </div>
                <div class="flex flex-wrap gap-3 w-full md:w-auto justify-end">
                    <a href="{{ route('module4.treatments.create') }}" class="bg-white text-cyan-600 px-5 py-2.5 rounded-lg font-bold hover:bg-cyan-50 transition shadow-md text-sm text-center flex-1 md:flex-none">
                        Record New Treatment
                    </a>
                    <a href="{{ route('module4.dashboard') }}" class="bg-cyan-700 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-cyan-800 transition shadow-md text-sm text-center flex-1 md:flex-none">
                        Module 4 Dashboard
                    </a>
                    <a href="{{ route('dashboard') }}" class="bg-cyan-800 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-cyan-900 transition shadow-md text-sm text-center flex-1 md:flex-none">
                        Main Dashboard
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($treatments->count())
                <div class="space-y-4">
                    @foreach ($treatments as $treatment)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-200 overflow-hidden relative flex flex-col md:flex-row items-start md:items-center justify-between p-6 gap-6">
                            
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 
                                @if ($treatment->status === 'scheduled') bg-amber-400
                                @elif ($treatment->status === 'in-progress') bg-blue-500
                                @else bg-emerald-500 @endif">
                            </div>

                            <div class="flex-1 pl-2">
                                <div class="flex flex-wrap items-center gap-3">
                                    <h3 class="text-xl font-bold text-gray-800 tracking-tight">
                                        {{ $treatment->treatment_name }}
                                    </h3>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold tracking-wide
                                        @if ($treatment->status === 'scheduled') bg-amber-50 text-amber-700 border border-amber-200
                                        @elif ($treatment->status === 'in-progress') bg-blue-50 text-blue-700 border border-blue-200
                                        @else bg-emerald-50 text-emerald-700 border border-emerald-200 @endif">
                                        {{ ucfirst(str_replace('-', ' ', $treatment->status)) }}
                                    </span>
                                </div>

                                <div class="flex flex-wrap items-center gap-x-6 gap-y-1.5 mt-3 text-sm text-gray-500 font-medium">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ $treatment->treatment_date->format('M d, Y') }}</span>
                                    </div>
                                    @if($treatment->treatment_time)
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ $treatment->treatment_time->format('g:i A') }}</span>
                                        </div>
                                    @endif
                                </div>

                                @if($treatment->description)
                                    <p class="text-sm text-gray-600 mt-3 line-clamp-2 max-w-3xl bg-gray-50 border border-gray-100 rounded-xl p-3 font-normal">
                                        <span class="font-semibold text-gray-700">Description:</span> {{ Str::limit($treatment->description, 130) }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex items-center gap-2 self-stretch md:self-auto justify-end border-t md:border-t-0 border-gray-100 pt-4 md:pt-0 w-full md:w-auto">
                                <a href="{{ route('module4.treatments.show', $treatment) }}" class="px-4 py-2 text-sm font-semibold text-cyan-600 hover:text-cyan-700 hover:bg-cyan-50 rounded-xl transition">
                                    View Details
                                </a>
                                <a href="{{ route('module4.treatments.edit', $treatment) }}" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-xl transition">
                                    Edit
                                </a>
                                <form action="{{ route('module4.treatments.destroy', $treatment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-red-600 hover:text-red-700 hover:bg-red-50 rounded-xl transition"
                                            onclick="return confirm('Are you sure you want to delete this treatment log record?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center max-w-2xl mx-auto mt-12">
                    <div class="bg-cyan-50 rounded-full p-5 w-20 h-20 mx-auto mb-6 flex items-center justify-center border border-cyan-100">
                        <svg class="w-10 h-10 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">No Treatments Recorded</h3>
                    <p class="text-gray-500 mt-2 max-w-sm mx-auto mb-6">There are currently no clinical operations or treatments cataloged in this system environment.</p>
                    <a href="{{ route('module4.treatments.create') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-cyan-600 to-cyan-500 text-white rounded-xl font-bold hover:from-cyan-500 hover:to-cyan-400 transition shadow-md">
                        Record Your First Treatment
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>