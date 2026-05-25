<x-app-layout>
    <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 min-h-screen py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white p-8 rounded-2xl shadow-lg mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h2 class="text-3xl font-bold leading-tight">{{ __('Recent Treatments') }}</h2>
                    <p class="text-cyan-100 mt-1">Historically compiled treatments and medical entries</p>
                </div>
                <a href="{{ route('module4.appointments.index') }}" class="bg-white text-cyan-600 px-6 py-3 rounded-xl font-semibold hover:bg-cyan-50 transition shadow-md">
                    View All Appointments
                </a>
            </div>

            @if ($appointments->count())
                <div class="grid grid-cols-1 gap-4">
                    @foreach ($appointments as $appointment)
                        <div class="bg-white rounded-2xl shadow-md p-6 border-b-4 border-cyan-500 transition hover:shadow-lg">
                            <div class="flex justify-between items-start flex-wrap gap-4">
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-800">{{ $appointment->reason_for_visit }}</h3>
                                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-gray-600">
                                        <p><strong>Date:</strong> {{ $appointment->appointment_date->format('M d, Y') }} at {{ $appointment->appointment_time->format('g:i A') }}</p>
                                        <p><strong>Patient Class:</strong> <span class="capitalize font-semibold text-gray-700">{{ $appointment->patient_type }}</span></p>
                                    </div>
                                </div>
                                <div class="text-right flex flex-col items-end gap-3">
                                    <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wider
                                        @if($appointment->status === 'completed') bg-green-100 text-green-800
                                        @elif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $appointment->status }}
                                    </span>
                                    <a href="{{ route('module4.appointments.show', $appointment) }}" class="text-cyan-600 font-semibold hover:text-cyan-700 text-sm flex items-center gap-1 mt-2">
                                        View Details &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center border-b-4 border-cyan-500">
                    <p class="text-gray-600">You have no recent treatments tracked in this logs block.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>