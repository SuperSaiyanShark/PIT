<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Staff Member Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-cyan-500 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <div class="space-y-6 mb-6">
                        <div>
                            <label class="text-sm font-semibold text-cyan-100">Name</label>
                            <p class="text-lg mt-2">{{ $staff->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-cyan-100">Email</label>
                            <p class="text-lg mt-2">{{ $staff->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-cyan-100">Role</label>
                            <p class="text-lg mt-2">{{ ucfirst($staff->role) }}</p>
                        </div>
                        @if($staff->specialization)
                            <div>
                                <label class="text-sm font-semibold text-cyan-100">Specialization</label>
                                <p class="text-lg mt-2">{{ $staff->specialization }}</p>
                            </div>
                        @endif
                        @if($staff->license_number)
                            <div>
                                <label class="text-sm font-semibold text-cyan-100">License Number</label>
                                <p class="text-lg mt-2">{{ $staff->license_number }}</p>
                            </div>
                        @endif
                        @if($staff->bio)
                            <div>
                                <label class="text-sm font-semibold text-cyan-100">Biography</label>
                                <p class="text-base mt-2 bg-cyan-400 p-4 rounded">{{ $staff->bio }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="text-sm font-semibold text-cyan-100">Status</label>
                            <p class="text-lg mt-2">
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $staff->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}
                                ">
                                    {{ $staff->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-teal-400 pt-6">
                        <p class="text-sm text-cyan-100 mb-4">
                            <strong>Created:</strong> {{ $staff->created_at->format('M d, Y g:i A') }}<br>
                            <strong>Last Updated:</strong> {{ $staff->updated_at->format('M d, Y g:i A') }}
                        </p>

                        <div class="flex gap-4">
                            <a href="{{ route('staff.edit', $staff) }}" 
                               class="px-4 py-2 bg-white text-cyan-600 rounded-md hover:bg-cyan-100">
                                Edit
                            </a>
                            <form action="{{ route('staff.destroy', $staff) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                                        onclick="return confirm('Are you sure you want to deactivate this staff member?')">
                                    Deactivate
                                </button>
                            </form>
                            <a href="{{ route('staff.index') }}" class="px-4 py-2 bg-cyan-400 text-white rounded-md hover:bg-cyan-300">
                                Back to Staff
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
