<x-app-layout>
    <div class="min-h-screen bg-[#F5F9FA] p-8">
        <div class="max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-[#134E5E]">Assign Patient to Bed</h2>
                    <p class="text-sm text-gray-500">Bed {{ $bed->bedNumber }} in {{ $ward->wardName }}</p>
                </div>
                <a href="{{ route('my-wards.beds', $ward->wardNumber) }}"
                    class="text-[#00B2D1] font-bold text-sm uppercase tracking-widest hover:underline">
                    ← Back to Beds
                </a>
            </div>

            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                <form action="{{ route('my-wards.beds.assign', [$bed->bedNumber, $ward->wardNumber]) }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="text-xs font-black text-[#00B2D1] uppercase tracking-widest px-2">Patient
                            Name</label>
                        <input type="text" name="patient_name" required
                            class="w-full bg-[#F8FAFB] border-transparent rounded-xl p-4 font-semibold text-gray-700 focus:ring-2 focus:ring-[#00B2D1] mt-2"
                            placeholder="Enter patient full name">
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('my-wards.beds', $ward->wardNumber) }}"
                            class="bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-bold text-sm uppercase tracking-widest hover:bg-gray-400 transition-all">
                            Cancel
                        </a>
                        <button type="submit"
                            class="bg-[#00B2D1] text-white px-6 py-3 rounded-xl font-bold text-sm uppercase tracking-widest hover:bg-[#134E5E] transition-all shadow-lg shadow-[#00B2D1]/20">
                            Assign Patient
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>