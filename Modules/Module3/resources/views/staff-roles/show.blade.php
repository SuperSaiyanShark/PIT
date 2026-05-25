<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">{{ $role->name }}</h3>
                        <div class="space-x-2">
                            <a href="{{ route('staff-roles.edit', $role->id) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                                Edit
                            </a>
                            <a href="{{ route('staff-roles.index') }}"
                                class="bg-gray-400 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="text-gray-600 text-sm mb-2">Description</p>
                        <p class="font-semibold text-lg">{{ $role->description ?? 'No description provided' }}</p>
                    </div>

                    @if($role->permissions)
                        <div>
                            <h4 class="text-lg font-semibold mb-4">Permissions</h4>
                            <div class="grid grid-cols-2 gap-2">
                                @php
                                    $permissions = json_decode($role->permissions, true) ?? [];
                                @endphp
                                @forelse($permissions as $permission)
                                    <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded">
                                        {{ $permission }}
                                    </div>
                                @empty
                                    <p class="text-gray-500">No permissions assigned</p>
                                @endforelse
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
