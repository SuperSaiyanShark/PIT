<x-app-layout>
    <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 min-h-screen py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white p-8 rounded-2xl shadow-lg mb-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h2 class="text-3xl font-bold leading-tight">{{ __('My Appointments') }}</h2>
                    <p class="text-cyan-100 mt-1 text-sm sm:text-base">Manage and track your upcoming scheduled clinical visits</p>
                </div>
                <div class="flex flex-wrap gap-3 w-full md:w-auto justify-end">
                    <a href="{{ route('module4.appointments.choose-patient-type') }}" class="bg-white text-cyan-600 px-5 py-2.5 rounded-xl font-bold hover:bg-cyan-50 transition shadow-md text-sm text-center flex-1 md:flex-none">
                        Schedule New Appointment
                    </a>
                    <a href="{{ route('module4.dashboard') }}" class="bg-cyan-700 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-cyan-800 transition shadow-md text-sm text-center flex-1 md:flex-none">
                        Module 4 Dashboard
                    </a>
                    <a href="{{ route('dashboard') }}" class="bg-cyan-800 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-cyan-900 transition shadow-md text-sm text-center flex-1 md:flex-none">
                        Main Dashboard
                    </a>
                </div>
            </div>

            @if ($appointments->count())
                <div class="grid grid-cols-1 gap-6">
                    @foreach ($appointments as $appointment)
                        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-6 border-l-4 border-cyan-500 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full 
                                        @if($appointment->patient_type === 'inpatient') bg-blue-100 text-blue-800 @else bg-teal-100 text-teal-800 @endif">
                                        {{ $appointment->patient_type }}
                                    </span>
                                    <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full
                                        @if($appointment->status === 'completed') bg-green-100 text-green-800
                                        @elif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $appointment->status }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mt-3">{{ $appointment->reason_for_visit }}</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1 mt-2 text-sm text-gray-600">
                                    <p><strong class="text-gray-700">Date:</strong> {{ $appointment->appointment_date->format('M d, Y') }} at {{ $appointment->appointment_time->format('g:i A') }}</p>
                                    <p><strong class="text-gray-700">Doctor Reference ID:</strong> #{{ $appointment->doctor_id }}</p>
                                    <p><strong class="text-gray-700">Patient Reference ID:</strong> #{{ $appointment->patient_id }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3 w-full md:w-auto justify-end border-t border-gray-100 md:border-t-0 pt-4 md:pt-0">
                                <a href="{{ route('module4.appointments.show', $appointment) }}" class="px-4 py-2 bg-cyan-50 text-cyan-600 font-semibold rounded-xl hover:bg-cyan-100 transition text-sm text-center flex-1 md:flex-none">
                                    View Details
                                </a>
                                <a href="{{ route('module4.appointments.edit', $appointment) }}" class="px-4 py-2 bg-cyan-600 text-white font-semibold rounded-xl hover:bg-cyan-700 transition text-sm text-center flex-1 md:flex-none">
                                    Edit
                                </a>
                                <form action="{{ route('module4.appointments.destroy', $appointment) }}" method="POST" class="inline flex-1 md:flex-none">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-600 font-semibold rounded-xl hover:bg-red-100 transition text-sm text-center" onclick="return confirm('Are you sure you want to cancel this appointment