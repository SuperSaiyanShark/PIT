<x-app-layout>
    <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 min-h-screen py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white p-8 rounded-2xl shadow-lg mb-8 text-center">
                <h2 class="text-3xl font-bold">{{ __('Schedule Appointment') }}</h2>
                <p class="text-cyan-100 mt-2">Select the type of patient registration to continue</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                <a href="{{ route('module4.appointments.create', ['type' => 'inpatient']) }}" 
                   class="transform hover:scale-105 transition duration-300 group">
                    <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition h-full border-b-4 border-blue-500 group-hover:border-blue-600">
                        <div class="flex justify-center mb-6">
                            <div class="bg-blue-50 rounded-full p-6 group-hover:bg-blue-100 transition">
                                <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 text-center">Inpatient</h3>
                        <p class="text-gray-600 text-center mt-2 text-sm">For individuals admitted to the hospital requiring overnight or extended stays.</p>
                    </div>
                </a>

                <a href="{{ route('module4.appointments.create', ['type' => 'outpatient']) }}" 
                   class="transform hover:scale-105 transition duration-300 group">
                    <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition h-full border-b-4 border-teal-500 group-hover:border-teal-600">
                        <div class="flex justify-center mb-6">
                            <div class="bg-teal-50 rounded-full p-6 group-hover:bg-teal-100 transition">
                                <svg class="w-12 h-12 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 text-center">Outpatient</h3>
                        <p class="text-gray-600 text-center mt-2 text-sm">For routine clinical follow-ups, consultations, or emergency medical examinations.</p>
                    </div>
                </a>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('module4.appointments.index') }}" class="bg-white text-gray-600 px-6 py-3 rounded-xl font-semibold hover:bg-gray-50 transition shadow-md inline-block">
                    Back to Appointments
                </a>
            </div>
        </div>
    </div>
</x-app-layout>