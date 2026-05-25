<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff & Patient Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm font-medium">Total Staff</div>
                    <div class="text-4xl font-bold text-blue-600 mt-2">{{ $totalStaff ?? 0 }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm font-medium">Total Patients</div>
                    <div class="text-4xl font-bold text-green-600 mt-2">{{ $totalPatients ?? 0 }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm font-medium">Departments</div>
                    <div class="text-4xl font-bold text-purple-600 mt-2">{{ $totalDepartments ?? 0 }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm font-medium">Wards</div>
                    <div class="text-4xl font-bold text-orange-600 mt-2">{{ $totalWards ?? 0 }}</div>
                </div>
            </div>

            <!-- Staff Management Section -->
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Staff Management</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Staff List -->
                    <a href="{{ route('staff.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow p-8 text-center">
                        <div class="text-5xl mb-4">👥</div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Manage Staff</h4>
                        <p class="text-gray-600 text-sm">View, create, and manage staff members</p>
                    </a>

                    <!-- Staff by Role -->
                    <a href="{{ route('staff.byRole', 'all') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow p-8 text-center">
                        <div class="text-5xl mb-4">🏷️</div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Staff by Role</h4>
                        <p class="text-gray-600 text-sm">Filter staff members by job roles</p>
                    </a>

                    <!-- Staff Statistics -->
                    <a href="{{ route('staff.statistics') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow p-8 text-center">
                        <div class="text-5xl mb-4">📊</div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Staff Statistics</h4>
                        <p class="text-gray-600 text-sm">View staff analytics and reports</p>
                    </a>

                    <!-- Staff Schedules -->
                    <a href="{{ route('schedules.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow p-8 text-center">
                        <div class="text-5xl mb-4">📅</div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Schedules</h4>
                        <p class="text-gray-600 text-sm">Manage staff schedules and shifts</p>
                    </a>

                    <!-- Staff Responsibilities -->
                    <a href="{{ route('responsibilities.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow p-8 text-center">
                        <div class="text-5xl mb-4">✅</div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Responsibilities</h4>
                        <p class="text-gray-600 text-sm">Assign and manage staff duties</p>
                    </a>

                    <!-- Staff Roles -->
                    <a href="{{ route('staff-roles.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow p-8 text-center">
                        <div class="text-5xl mb-4">🎯</div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Staff Roles</h4>
                        <p class="text-gray-600 text-sm">Configure job roles and positions</p>
                    </a>
                </div>
            </div>

            <!-- Patient Management Section -->
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Patient Management</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Patient List -->
                    <a href="{{ route('patients.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow p-8 text-center">
                        <div class="text-5xl mb-4">🏥</div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Manage Patients</h4>
                        <p class="text-gray-600 text-sm">View and manage patient records</p>
                    </a>

                    <!-- Patient Admissions -->
                    <a href="{{ route('patients.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow p-8 text-center">
                        <div class="text-5xl mb-4">🚪</div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Admissions</h4>
                        <p class="text-gray-600 text-sm">Handle patient admissions and discharges</p>
                    </a>

                    <!-- Medical Records -->
                    <a href="{{ route('patients.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow p-8 text-center">
                        <div class="text-5xl mb-4">📋</div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Medical Records</h4>
                        <p class="text-gray-600 text-sm">Access and update medical records</p>
                    </a>
                </div>
            </div>

            <!-- Organizational Structure Section -->
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Organizational Structure</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Departments -->
                    <a href="{{ route('departments.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow p-8 text-center">
                        <div class="text-5xl mb-4">🏢</div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Departments</h4>
                        <p class="text-gray-600 text-sm">Manage hospital departments</p>
                    </a>

                    <!-- Wards -->
                    <a href="{{ route('wards.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow p-8 text-center">
                        <div class="text-5xl mb-4">🛏️</div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Wards</h4>
                        <p class="text-gray-600 text-sm">Manage hospital wards</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
