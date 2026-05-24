<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Staff Members') }}
            </h2>
            <a href="{{ route('module4.staff.create') }}" class="px-4 py-2 bg-white text-cyan-600 rounded-md hover:bg-cyan-100">
                Add Staff Member
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($staff->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($staff as $member)
                        <div class="bg-cyan-500 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-white">
                                <h3 class="text-lg font-semibold mb-2">{{ $member->name }}</h3>
                                <div class="space-y-2 text-sm mb-4">
                                    <p><strong>Role:</strong> {{ ucfirst($member->role) }}</p>
                                    <p><strong>Email:</strong> {{ $member->email }}</p>
                                    @if($member->specialization)
                                        <p><strong>Specialization:</strong> {{ $member->specialization }}</p>
                                    @endif
                                    @if($member->license_number)
                                        <p><strong>License:</strong> {{ $member->license_number }}</p>
                                    @endif
                                </div>
                                @if($member->bio)
                                    <p class="text-sm text-cyan-100 mb-4">{{ Str::limit($member->bio, 100) }}</p>
                                @endif
                                <div class="flex gap-2 pt-4 border-t border-teal-400">
                                    <a href="{{ route('module4.staff.show', $member) }}" class="text-white hover:underline text-sm">
                                        View
                                    </a>
                                    <a href="{{ route('module4.staff.edit', $member) }}" class="text-cyan-100 hover:underline text-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('module4.staff.destroy', $member) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-200 hover:underline text-sm"
                                                onclick="return confirm('Are you sure?')">
                                            Deactivate
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-cyan-500 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-cyan-100 mb-4">No active staff members.</p>
                    <a href="{{ route('module4.staff.create') }}" class="inline-block px-4 py-2 bg-white text-cyan-600 rounded-md hover:bg-cyan-100">
                        Add First Staff Member
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
