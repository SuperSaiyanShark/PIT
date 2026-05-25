<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Staff Roles</h3>
                        <a href="{{ route('staff-roles.create') }}"
                            class="bg-[#00B2D1] hover:bg-[#134E5E] text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                            + Add New Role
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Permissions</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($roles as $role)
                                    <tr>
                                        <td class="px-6 py-4 font-semibold">{{ $role->name }}</td>
                                        <td class="px-6 py-4">{{ $role->description ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">
                                            @if($role->permissions)
                                                <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">{{ count(json_decode($role->permissions, true) ?? []) }} permissions</span>
                                            @else
                                                <span class="text-gray-500">None</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 space-x-2">
                                            <a href="{{ route('staff-roles.show', $role->id) }}"
                                                class="text-blue-600 hover:text-blue-900">View</a>
                                            <a href="{{ route('staff-roles.edit', $role->id) }}"
                                                class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                            <form action="{{ route('staff-roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No roles found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
