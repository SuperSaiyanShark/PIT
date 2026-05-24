<x-app-layout>
    <div class="py-12 px-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <h2 class="text-2xl font-bold text-[#134E5E] mb-6">Assign Patient to Bed #{{ $bed->bedNumber }}</h2>
                
                <form action="{{ route('beds.assign', [$bed->wardNumber, $bed->bedNumber]) }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Patient Name</label>
                        <input type="text" name="patient_name" required
                               class="w-full border-gray-300 rounded-xl p-3 focus:ring-[#00B2D1] focus:border-[#00B2D1]">
                    </div>
                    
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('wards.beds', $bed->wardNumber) }}" 
                           class="px-6 py-3 bg-gray-200 rounded-xl font-semibold hover:bg-gray-300">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 bg-[#00B2D1] text-white rounded-xl font-semibold hover:bg-[#134E5E]">
                            Assign Patient
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>