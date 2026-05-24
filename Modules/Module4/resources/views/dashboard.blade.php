<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WELLMEADOWS HOSPITAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="min-h-screen bg-cyan-200">
        <!-- Header -->
        <div class="bg-cyan-500 text-white py-6 px-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold">WELLMEADOWS HOSPITAL</h1>
                    <p class="text-cyan-100 mt-1">APPOINTMENT AND TREATMENT MODULE</p>
                </div>
                <a href="{{ route('dashboard') }}" class="bg-white text-cyan-500 px-6 py-2 rounded-lg font-semibold hover:bg-cyan-100 transition">
                    Back to Main Dashboard
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="py-12 px-6">
            <div class="max-w-6xl mx-auto">
                <!-- Main Navigation Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Appointments Card -->
                    <a href="{{ route('module4.appointments.index') }}" 
                       class="transform hover:scale-105 transition duration-300">
                        <div class="bg-cyan-500 rounded-3xl shadow-xl p-12 text-white text-center hover:bg-cyan-600 cursor-pointer">
                            <div class="flex justify-center mb-6">
                                <div class="bg-white bg-opacity-20 rounded-full p-6">
                                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-3xl font-bold">Appointments</h2>
                        </div>
                    </a>

                    <!-- Treatment History Card -->
                    <a href="{{ route('module4.appointments.recent') }}" 
                       class="transform hover:scale-105 transition duration-300">
                        <div class="bg-cyan-500 rounded-3xl shadow-xl p-12 text-white text-center hover:bg-cyan-600 cursor-pointer">
                            <div class="flex justify-center mb-6">
                                <div class="bg-white bg-opacity-20 rounded-full p-6">
                                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-3xl font-bold">Treatment history</h2>
                        </div>
                    </a>

                    <!-- Record Treatments Card -->
                    <a href="{{ route('module4.treatments.create') }}" 
                       class="transform hover:scale-105 transition duration-300">
                        <div class="bg-cyan-500 rounded-3xl shadow-xl p-12 text-white text-center hover:bg-cyan-600 cursor-pointer">
                            <div class="flex justify-center mb-6">
                                <div class="bg-white bg-opacity-20 rounded-full p-6">
                                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-3xl font-bold">Record treatments</h2>
                        </div>
                    </a>

                    <!-- All Treatments Card -->
                    <a href="{{ route('module4.treatments.index') }}" 
                       class="transform hover:scale-105 transition duration-300">
                        <div class="bg-cyan-500 rounded-3xl shadow-xl p-12 text-white text-center hover:bg-cyan-600 cursor-pointer">
                            <div class="flex justify-center mb-6">
                                <div class="bg-white bg-opacity-20 rounded-full p-6">
                                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-3xl font-bold">View treatments</h2>
                        </div>
                    </a>

                    <!-- Assign Doctors and Nurses Card -->
                    <a href="{{ route('module4.staff.index') }}" 
                       class="transform hover:scale-105 transition duration-300">
                        <div class="bg-cyan-500 rounded-3xl shadow-xl p-12 text-white text-center hover:bg-cyan-600 cursor-pointer">
                            <div class="flex justify-center mb-6">
                                <div class="bg-white bg-opacity-20 rounded-full p-6">
                                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-3xl font-bold">Staff list</h2>
                        </div>
                    </a>

                    <!-- Create New Staff Card -->
                    <a href="{{ route('module4.staff.create') }}" 
                       class="transform hover:scale-105 transition duration-300">
                        <div class="bg-cyan-500 rounded-3xl shadow-xl p-12 text-white text-center hover:bg-cyan-600 cursor-pointer">
                            <div class="flex justify-center mb-6">
                                <div class="bg-white bg-opacity-20 rounded-full p-6">
                                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-3xl font-bold">Add staff member</h2>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
