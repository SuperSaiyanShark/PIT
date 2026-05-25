<x-app-layout>
    <div class="min-h-screen bg-[#F5F9FA] p-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-[#134E5E]">Edit Ward</h2>
                    <p class="text-sm text-gray-500">Modify registry details for {{ $ward->wardName }}</p>
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

            <form action="{{ route('my-wards.update', $ward->allocationid) }}" method="POST"
                class="bg-white p-10 rounded-[2rem] shadow-sm border border-gray-100">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-[#00B2D1] uppercase tracking-widest px-2">Allocation
                            ID</label>
                        <input type="text" value="{{ $ward->allocationid }}" disabled
                            class="w-full bg-gray-100 border-transparent rounded-xl p-4 font-semibold text-gray-500">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[#00B2D1] uppercase tracking-widest px-2">Ward
                            Number</label>
                        <input type="text" value="{{ $ward->wardNumber }}" disabled
                            class="w-full bg-gray-100 border-transparent rounded-xl p-4 font-semibold text-gray-500">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[#00B2D1] uppercase tracking-widest px-2">Ward
                            Name</label>
                        <input type="text" name="wardName" value="{{ old('wardName', $ward->wardName) }}" required
                            class="w-full bg-[#F8FAFB] border-transparent rounded-xl p-4 font-semibold text-gray-700 focus:ring-2 focus:ring-[#00B2D1]">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[#00B2D1] uppercase tracking-widest px-2">Location</label>
                        <input type="text" name="location" value="{{ old('location', $ward->location) }}"
                            class="w-full bg-[#F8FAFB] border-transparent rounded-xl p-4 font-semibold text-gray-700 focus:ring-2 focus:ring-[#00B2D1]">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[#00B2D1] uppercase tracking-widest px-2">Total Bed
                            Capacity</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $ward->capacity) }}" required
                            class="w-full bg-[#F8FAFB] border-transparent rounded-xl p-4 font-semibold text-gray-700 focus:ring-2 focus:ring-[#00B2D1]">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[#00B2D1] uppercase tracking-widest px-2">Telephone
                            Extension</label>
                        <input type="text" name="telExtn" value="{{ old('telExtn', $ward->telExtn) }}"
                            class="w-full bg-[#F8FAFB] border-transparent rounded-xl p-4 font-semibold text-gray-700 focus:ring-2 focus:ring-[#00B2D1]">
                    </div>
                </div>

                <div class="mt-10 flex justify-end gap-4">
                    <a href="{{ route('my-wards.index') }}"
                        class="bg-gray-300 text-gray-700 px-10 py-4 rounded-xl font-bold text-sm uppercase tracking-widest hover:bg-gray-400 transition-all">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-[#00B2D1] text-white px-10 py-4 rounded-xl font-bold text-sm uppercase tracking-widest hover:bg-[#134E5E] transition-all shadow-lg shadow-[#00B2D1]/20">
                        Update Ward
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>