<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WELLMEADOWS HOSPITAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-cyan-50 to-cyan-100">
    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white py-8 px-6 shadow-lg">
            <div class="flex justify-between items-center max-w-6xl mx-auto">
                <div>
                    <h1 class="text-4xl font-bold">WELLMEADOWS HOSPITAL</h1>
                    <p class="text-cyan-100 mt-2 text-lg">APPOINTMENT AND TREATMENT MODULE</p>
                </div>
                <a href="{{ route('dashboard') }}" class="bg-white text-cyan-600 px-8 py-3 rounded-lg font-semibold hover:bg-cyan-50 transition shadow-md">
                    Back to Main Dashboard
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="py-16 px-6">
            <div class="max-w-6xl mx-auto">
                <!-- Main Navigation Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Appointments Card -->
                    <a href="{{ route('module4.appointments.index') }}" 
                       class="transform hover:scale-105 transition duration-300 group">
                        <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition h-full border-b-4 border-cyan-500 group-hover:border-cyan-600">
                            <div class="flex justify-center mb-6">
                                <div class="bg-cyan-100 rounded-full p-6 group-hover:bg-cyan-200 transition">
                                    <svg class="w-12 h-12 text-cyan-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 text-center">Appointments</h2>
                            <p class="text-gray-600 text-center mt-2 text-sm">Manage appointments</p>
                        </div>
                    </a>

                    <!-- Treatment History Card -->
                    <a href="{{ route('module4.appointments.recent') }}" 
                       class="transform hover:scale-105 transition duration-300 group">
                        <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition h-full border-b-4 border-cyan-500 group-hover:border-cyan-600">
                            <div class="flex justify-center mb-6">
                                <div class="bg-cyan-100 rounded-full p-6 group-hover:bg-cyan-200 transition">
                                    <svg class="w-12 h-12 text-cyan-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 text-center">Treatment History</h2>
                            <p class="text-gray-600 text-center mt-2 text-sm">View patient records</p>
                        </div>
                    </a>

                    <!-- Record Treatments Card -->
                    <a href="{{ route('module4.treatments.create') }}" 
                       class="transform hover:scale-105 transition duration-300 group">
                        <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition h-full border-b-4 border-cyan-500 group-hover:border-cyan-600">
                            <div class="flex justify-center mb-6">
                                <div class="bg-cyan-100 rounded-full p-6 group-hover:bg-cyan-200 transition">
                                    <svg class="w-12 h-12 text-cyan-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 text-center">Record Treatments</h2>
                            <p class="text-gray-600 text-center mt-2 text-sm">Add new treatment</p>
                        </div>
                    </a>

                    <!-- All Treatments Card -->
                    <a href="{{ route('module4.treatments.index') }}" 
                       class="transform hover:scale-105 transition duration-300 group">
                        <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition h-full border-b-4 border-cyan-500 group-hover:border-cyan-600">
                            <div class="flex justify-center mb-6">
                                <div class="bg-cyan-100 rounded-full p-6 group-hover:bg-cyan-200 transition">
                                    <svg class="w-12 h-12 text-cyan-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 text-center">All Treatments</h2>
                            <p class="text-gray-600 text-center mt-2 text-sm">View all treatments</p>
                        </div>
                    </a>

                    <!-- Staff Management Card - Links to Root Staff -->
                    <a href="{{ route('staff.index') }}" 
                       class="transform hover:scale-105 transition duration-300 group">
                        <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition h-full border-b-4 border-cyan-500 group-hover:border-cyan-600">
                            <div class="flex justify-center mb-6">
                                <div class="bg-cyan-100 rounded-full p-6 group-hover:bg-cyan-200 transition">
                                    <svg class="w-12 h-12 text-cyan-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 text-center">Staff Management</h2>
                            <p class="text-gray-600 text-center mt-2 text-sm">Manage medical staff</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
