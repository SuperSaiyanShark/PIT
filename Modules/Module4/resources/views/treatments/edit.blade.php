<x-app-layout>
    <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 min-h-screen pb-12">
        
        <div class="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white py-8 px-6 shadow-lg mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center max-w-6xl mx-auto gap-6">
                <div>
                    <h1 class="text-4xl font-bold tracking-wide">WELLMEADOWS HOSPITAL</h1>
                    <p class="text-cyan-100 mt-2 text-lg uppercase tracking-wider font-medium flex items-center gap-2">
                        <span>{{ __('Edit Treatment Record') }}</span>
                        <span class="text-cyan-300/50">•</span>
                        <span class="text-sm normal-case tracking-normal text-cyan-200/90">Modify parameters for active index instances</span>
                    </p>
                </div>
                <div class="flex flex-wrap gap-3 w-full md:w-auto justify-end">
                    <a href="{{ route('module4.treatments.show', $treatment) }}" class="bg-white text-cyan-600 px-5 py-2.5 rounded-lg font-bold hover:bg-cyan-50 transition shadow-md text-sm text-center flex-1 md:flex-none">
                        Abort Changes
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('module4.treatments.update', $treatment) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="treatment_name" class="block text-sm font-bold text-gray-700 mb-2">
                                Treatment Name / Operation Title
                            </label>
                            <input type="text" id="treatment_name" name="treatment_name" 
                                   class="block w-full px-4 py-2.5 border border-gray-200 bg-gray-50/50 text-gray-900 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition font-medium"
                                   value="{{ $treatment->treatment_name }}" required>
                            @error('treatment_name')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="treatment_date" class="block text-sm font-bold text-gray-700 mb-2">
                                    Scheduled Date
                                </label>
                                <input type="date" id="treatment_date" name="treatment_date" 
                                       class="block w-full px-4 py-2.5 border border-gray-200 bg-gray-50/50 text-gray-900 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition font-medium"
                                       value="{{ $treatment->treatment_date->format('Y-m-d') }}" required>
                                @error('treatment_date')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="treatment_time" class="block text-sm font-bold text-gray-700 mb-2">
                                    Treatment Time <span class="text-xs text-gray-400 font-normal">(Optional)</span>
                                </label>
                                <input type="time" id="treatment_time" name="treatment_time" 
                                       class="block w-full px-4 py-2.5 border border-gray-200 bg-gray-50/50 text-gray-900 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition font-medium"
                                       value="{{ $treatment->treatment_time ? $treatment->treatment_time->format('H:i') : '' }}">
                                @error('treatment_time')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-bold text-gray-700 mb-2">
                                Operational Lifecycle Status
                            </label>
                            <select id="status" name="status" 
                                    class="block w-full px-4 py-2.5 border border-gray-200 bg-gray-50/50 text-gray-900 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition font-medium">
                                <option value="scheduled" {{ $treatment->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="in-progress" {{ $treatment->status === 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $treatment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                                Description & Directives
                            </label>
                            <textarea id="description" name="description" rows="4"
                                      class="block w-full px-4 py-2.5 border border-gray-200 bg-gray-50/50 text-gray-900 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition font-normal">{{ $treatment->description }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-bold text-gray-700 mb-2">
                                Practitioner Notes
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="block w-full px-4 py-2.5 border border-gray-200 bg-gray-50/50 text-gray-900 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition font-normal">{{ $treatment->notes }}</textarea>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6 mt-4">
                            <a href="{{ route('module4.treatments.show', $treatment) }}" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 rounded-xl transition">
                                Cancel Modifications
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-cyan-600 to-cyan-500 text-white rounded-xl font-semibold hover:from-cyan-500 hover:to-cyan-400 transition shadow-md hover:shadow-lg text-sm text-center">
                                Update Data Entry
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>