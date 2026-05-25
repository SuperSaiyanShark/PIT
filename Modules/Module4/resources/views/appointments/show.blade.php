<x-app-layout>
    <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 min-h-screen py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-xl shadow-md border-l-4 border-green-500 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white p-6 rounded-2xl shadow-lg mb-6 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold leading-tight">{{ __('Appointment Details') }}</h2>
                    <p class="text-cyan-100 text-sm mt-0.5">Reference ID #{{ $appointment->id }}</p>
                </div>
                <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider
                    @if($appointment->status === 'completed') bg-green-700 text-white
                    @elif($appointment->status === 'pending') bg-yellow-600 text-white
                    @else bg-red-700 text-white @endif">
                    {{ $appointment->status }}
                </span>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 border-b-4 border-cyan-500">
                <div class="space-y-6">
                    <div class="border-b border-gray-100 pb-4">
                        <label class="text-xs font-bold text-cyan-600 uppercase tracking-wide">Reason for Visit</label>
                        <p class="text-xl font-bold text-gray-800 mt-1">{{ $appointment->reason_for_visit }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-6 border-b border-gray-100 pb-4">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Patient Type</label>
                            <p class="text-base font-semibold text-gray-800 mt-1 capitalize">{{ $appointment->patient_type }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Patient ID Reference</label>
                            <p class="text-base font-semibold text-gray-800 mt-1">#{{ $appointment->patient_id }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 border-b border-gray-100 pb-4">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Date Scheduled</label>
                            <p class="text-base font-semibold text-gray-800 mt-1">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Time Slot</label>
                            <p class="text-base font-semibold text-gray-800 mt-1">{{ $appointment->appointment_time }}</p>
                        </div>
                    </div>

                    <div class="border-b border-gray-100 pb-4">
                        <label class="text-xs font-bold text-gray-400 uppercase">Assigned Doctor ID</label>
                        <p class="text-base font-semibold text-gray-800 mt-1">#{{ $appointment->doctor_id }}</p>
                    </div>

                    <div class="border-b border-gray-100 pb-4">
                        <label class="text-xs font-bold text-gray-400 uppercase">Additional Notes</label>
                        <p class="text-sm bg-gray-50 text-gray-700 rounded-xl p-4 mt-2 border border-gray-200 italic">
                            {{ $appointment->notes ?? 'No auxiliary details provided.' }}
                        </p>
                    </div>

                    <div class="text-xs text-gray-400 space-y-1">
                        <p><strong>Created:</strong> {{ \Carbon\Carbon::parse($appointment->created_at)->format('M d, Y \a\t g:i A') }}</p>
                        <p><strong>Last Updated:</strong> {{ \Carbon\Carbon::parse($appointment->updated_at)->format('M d, Y \a\t g:i A') }}</p>
                    </div>

                    <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('module4.appointments.edit', $appointment) }}" class="px-5 py-2.5 bg-cyan-600 text-white font-semibold rounded-xl hover:bg-cyan-700 transition shadow-md flex-1 text-center text-sm">
                            Edit Appointment
                        </a>
                        <form action="{{ route('module4.appointments.destroy', $appointment) }}" method="POST" class="inline flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-5 py-2.5 bg-red-50 text-red-600 font-semibold rounded-xl hover:bg-red-100 transition text-center text-sm" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                Cancel Appointment
                            </button>
                        </form>
                        <a href="{{ route('module4.appointments.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-semibold rounded-xl hover:bg-gray-200 transition flex-1 text-center text-sm">
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>