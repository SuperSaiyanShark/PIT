<x-app-layout>
    <div class="min-h-screen bg-cyan-200">
        <!-- Header -->
        <div class="bg-cyan-500 text-white py-6 px-6">
            <h1 class="text-3xl font-bold">WELLMEADOWS HOSPITAL</h1>
            <p class="text-cyan-100 mt-1">APPOINTMENT AND TREATMENT MODULE</p>
        </div>

        <!-- Main Content -->
        <div class="py-12 px-6">
            <div class="max-w-6xl mx-auto">
                <!-- Main Navigation Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Appointments Card -->
                    <a href="{{ route('appointments.index') }}" 
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
                    <a href="{{ route('appointments.recent') }}" 
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
                    <a href="{{ route('treatments.create') }}" 
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

                    <!-- Assign Doctors and Nurses Card -->
                    <a href="{{ route('staff.index') }}" 
                       class="transform hover:scale-105 transition duration-300">
                        <div class="bg-cyan-500 rounded-3xl shadow-xl p-12 text-white text-center hover:bg-cyan-600 cursor-pointer">
                            <div class="flex justify-center mb-6">
                                <div class="bg-white bg-opacity-20 rounded-full p-6">
                                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-3xl font-bold">Assign doctors and<br>nurses</h2>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
