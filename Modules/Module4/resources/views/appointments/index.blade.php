<x-app-layout>
    <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 min-h-screen py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white p-8 rounded-2xl shadow-lg mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h2 class="text-3xl font-bold leading-tight">{{ __('My Appointments') }}</h2>
                    <p class="text-cyan-100 mt-1">Manage and track scheduled hospital visits</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('module4.appointments.choose-patient-type') }}" class="bg-white text-cyan-600 px-6 py-3 rounded-xl font-semibold hover:bg-cyan-50 transition shadow-md">
                        Schedule New Appointment
                    </a>
                    <a href="{{ route('dashboard') }}" class="bg-cyan-700 text-white px-6 py-3 rounded-xl font-semibold hover:bg-cyan-800 transition shadow-md">
                        Dashboard
                    </a>
                </div>
            </div>

            @if ($appointments->count())
                <div class="grid grid-cols-1 gap-6">
                    @foreach ($appointments as $appointment)
                        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-6 border-l-4 border-cyan-500 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        @if($appointment->patient_type === 'inpatient') bg-blue-100 text-blue-800 @else bg-teal-100 text-teal-800 @endif">
                                        {{ ucfirst($appointment->patient_type) }}
                                    </span>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        @if($appointment->status === 'completed') bg-green-100 text-green-800
                                        @elif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mt-3">{{ $appointment->reason_for_visit }}</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2 text-sm text-gray-600">
                                    <p><strong>Date:</strong> {{ $appointment->appointment_date->format('M d, Y') }} at {{ $appointment->appointment_time->format('g:i A') }}</p>
                                    <p><strong>Doctor ID:</strong> #{{ $appointment->doctor_id }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3 w-full md:w-auto justify-end border-t md:border-t-0 pt-4 md:pt-0">
                                <a href="{{ route('module4.appointments.show', $appointment) }}" class="px-4 py-2 bg-cyan-50 text-cyan-600 font-semibold rounded-lg hover:bg-cyan-100 transition text-sm text-center flex-1 md:flex-none">
                                    View
                                </a>
                                <a href="{{ route('module4.appointments.edit', $appointment) }}" class="px-4 py-2 bg-cyan-600 text-white font-semibold rounded-lg hover:bg-cyan-700 transition text-sm text-center flex-1 md:flex-none">
                                    Edit
                                </a>
                                <form action="{{ route('module4.appointments.destroy', $appointment) }}" method=\"POST\" class="inline flex-1 md:flex-none">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-600 font-semibold rounded-lg hover:bg-red-100 transition text-sm text-center" onclick="return confirm('Are you sure?')">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center border-b-4 border-cyan-500">
                    <div class="bg-cyan-100 rounded-full p-6 w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-10 h-10 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 002-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">No Appointments Found</h3>
                    <p class="text-gray-600 mt-2 max-w-sm mx-auto mb-6">You don't have any appointments scheduled right now.</p>
                    <a href="{{ route('module4.appointments.choose-patient-type') }}" class="inline-block px-6 py-3 bg-cyan-600 text-white font-semibold rounded-xl hover:bg-cyan-700 transition shadow-md">
                        Schedule Your First Appointment
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>