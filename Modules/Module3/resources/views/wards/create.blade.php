<x-app-layout>
    <div class="min-h-screen bg-[#F5F9FA] p-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-[#134E5E]">Add New Ward</h2>
                    <p class="text-sm text-gray-500">Register a new facility in the Wellmeadow Hospital System</p>
                </div>
                <a href="{{ route('my-wards.index') }}"
                    class="text-[#00B2D1] font-bold text-sm uppercase tracking-widest hover:underline">
                    ← Back to Wards
                </a>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('my-wards.store') }}" method="POST"
                class="bg-white p-10 rounded-[2rem] shadow-sm border border-gray-100">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-[#00B2D1] uppercase tracking-widest px-2">Allocation
                            ID</label>
                        <input type="text" name="allocationid" placeholder="e.g., ALC-001" required
                            class="w-full bg-[#F8FAFB] border-transparent rounded-xl p-4 font-semibold text-gray-700 focus:ring-2 focus:ring-[#00B2D1]">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[#00B2D1] uppercase tracking-widest px-2">Ward
                            Number</label>
                        <input type="text" name="wardNumber" placeholder="e.g., W-101" required
                            class="w-full bg-[#F8FAFB] border-transparent rounded-xl p-4 font-semibold text-gray-700 focus:ring-2 focus:ring-[#00B2D1]">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[#00B2D1] uppercase tracking-widest px-2">Ward
                            Name</label>
                        <input type="text" name="wardName" placeholder="e.g., General Ward A" required
                            class="w-full bg-[#F8FAFB] border-transparent rounded-xl p-4 font-semibold text-gray-700 focus:ring-2 focus:ring-[#00B2D1]">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[#00B2D1] uppercase tracking-widest px-2">Location</label>
                        <input type="text" name="location" placeholder="e.g., Floor 1, East Wing"
                            class="w-full bg-[#F8FAFB] border-transparent rounded-xl p-4 font-semibold text-gray-700 focus:ring-2 focus:ring-[#00B2D1]">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[#00B2D1] uppercase tracking-widest px-2">Total Bed
                            Capacity</label>
                        <input type="number" name="capacity" placeholder="Enter number of beds" required
                            class="w-full bg-[#F8FAFB] border-transparent rounded-xl p-4 font-semibold text-gray-700 focus:ring-2 focus:ring-[#00B2D1]">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[#00B2D1] uppercase tracking-widest px-2">Telephone
                            Extension</label>
                        <input type="text" name="telExtn" placeholder="e.g., Ext-1101"
                            class="w-full bg-[#F8FAFB] border-transparent rounded-xl p-4 font-semibold text-gray-700 focus:ring-2 focus:ring-[#00B2D1]">
                    </div>
                </div>

                <div class="mt-10 flex justify-end">
                    <button type="submit"
                        class="bg-[#00B2D1] text-white px-10 py-4 rounded-xl font-bold text-sm uppercase tracking-widest hover:bg-[#134E5E] transition-all shadow-lg shadow-[#00B2D1]/20">
                        Create Ward
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>