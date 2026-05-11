<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Appointment Details') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-cyan-500 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="text-sm font-semibold text-teal-100">Reason for Visit</label>
                            <p class="text-lg mt-2">{{ $appointment->reason_for_visit }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-teal-100">Status</label>
                            <p class="text-lg mt-2">
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                    @if ($appointment->status === 'pending')
                                        bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                    @elseif ($appointment->status === 'confirmed')
                                        bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                    @elseif ($appointment->status === 'completed')
                                        bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                    @else
                                        bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                    @endif
                                ">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="text-sm font-semibold text-teal-100">Appointment Date</label>
                            <p class="text-lg mt-2">{{ $appointment->appointment_date->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-teal-100">Appointment Time</label>
                            <p class="text-lg mt-2">{{ $appointment->appointment_time->format('g:i A') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="text-sm font-semibold text-teal-100">Patient Type</label>
                            <p class="text-lg mt-2">{{ ucfirst($appointment->patient_type) }}</p>
                        </div>
                    </div>

                    @if ($appointment->notes)
                        <div class="mb-6">
                            <label class="text-sm font-semibold text-teal-100">Additional Notes</label>
                            <p class="text-base mt-2 bg-cyan-400 p-4 rounded">{{ $appointment->notes }}</p>
                        </div>
                    @endif

                    <div class="border-t border-teal-400 pt-6">
                        <p class="text-sm text-teal-100 mb-4">
                            <strong>Created:</strong> {{ $appointment->created_at->format('M d, Y g:i A') }}<br>
                            <strong>Last Updated:</strong> {{ $appointment->updated_at->format('M d, Y g:i A') }}
                        </p>

                        <div class="flex gap-4">
                            <a href="{{ route('appointments.edit', $appointment) }}" 
                               class="px-4 py-2 bg-white text-cyan-600 rounded-md hover:bg-cyan-100">
                                Edit Appointment
                            </a>
                            <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                                        onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                    Cancel Appointment
                                </button>
                            </form>
                            <a href="{{ route('appointments.index') }}" class="px-4 py-2 bg-teal-400 text-white rounded-md hover:bg-teal-300">
                                Back to Appointments
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
