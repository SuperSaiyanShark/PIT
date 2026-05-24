<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('My Appointments') }}
            </h2>
            <a href="{{ route('module4.appointments.choose-patient-type') }}" class="px-4 py-2 bg-white text-cyan-600 rounded-md hover:bg-cyan-100">
                Schedule New Appointment
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($appointments->count())
                <div class="space-y-4">
                    @foreach ($appointments as $appointment)
                        <div class="bg-cyan-500 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-white flex justify-between items-center">
                                <div class="flex-1">
                                    <div class="flex items-center gap-4">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold">{{ $appointment->reason_for_visit }}</h3>
                                            <p class="text-sm text-cyan-100 mt-1">
                                                <strong>Date:</strong> {{ $appointment->appointment_date->format('M d, Y') }} at {{ $appointment->appointment_time->format('g:i A') }}
                                            </p>
                                            <p class="text-sm text-cyan-100">
                                                <strong>Type:</strong> {{ ucfirst($appointment->patient_type) }}
                                            </p>
                                            <p class="text-sm mt-2">
                                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
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
                                </div>
                                <div class="flex gap-2 ml-4">
                                    <a href="{{ route('module4.appointments.show', $appointment) }}" 
                                       class="px-3 py-2 text-sm bg-white text-cyan-600 rounded hover:bg-cyan-100">
                                        View
                                    </a>
                                    <a href="{{ route('module4.appointments.edit', $appointment) }}" 
                                       class="px-3 py-2 text-sm bg-cyan-400 text-white rounded hover:bg-cyan-300">
                                        Edit
                                    </a>
                                    <form action="{{ route('module4.appointments.destroy', $appointment) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-2 text-sm bg-red-500 text-white rounded hover:bg-red-600"
                                                onclick="return confirm('Are you sure?')">
                                            Cancel
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-cyan-500 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-cyan-100 mb-4">You have no appointments scheduled.</p>
                    <a href="{{ route('module4.appointments.choose-patient-type') }}" class="inline-block px-4 py-2 bg-white text-cyan-600 rounded-md hover:bg-cyan-100">
                        Schedule Your First Appointment
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
