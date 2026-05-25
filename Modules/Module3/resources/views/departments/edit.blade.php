<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-medium mb-6">Edit Department: {{ $department->name }}</h3>

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('departments.update', $department->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Department Name</label>
                            <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00B2D1]"
                                value="{{ old('name', $department->name) }}" required>
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00B2D1]">{{ old('description', $department->description) }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Department Head</label>
                            <select name="head_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00B2D1]">
                                <option value="">Select a Head</option>
                                @foreach($heads as $head)
                                    <option value="{{ $head->id }}" {{ old('head_id', $department->head_id) == $head->id ? 'selected' : '' }}>{{ $head->name }}</option>
                                @endforeach
                            </select>
                            @error('head_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Building</label>
                            <input type="text" name="building" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00B2D1]"
                                value="{{ old('building', $department->building) }}">
                            @error('building')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                            <input type="text" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00B2D1]"
                                value="{{ old('phone', $department->phone) }}">
                            @error('phone')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="bg-[#00B2D1] hover:bg-[#134E5E] text-white px-6 py-2 rounded-lg font-bold transition">
                                Update Department
                            </button>
                            <a href="{{ route('departments.index') }}" class="bg-gray-400 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-bold transition">
                                Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
