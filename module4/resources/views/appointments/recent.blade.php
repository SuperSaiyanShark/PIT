<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Recent Treatments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if ($appointments->count())
                <div class="space-y-4">
                    @foreach ($appointments as $appointment)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold">{{ $appointment->reason_for_visit }}</h3>
                                        <div class="mt-2 space-y-1 text-sm text-gray-600 dark:text-gray-400">
                                            <p>
                                                <strong>Date:</strong> {{ $appointment->appointment_date->format('M d, Y') }} at {{ $appointment->appointment_time->format('g:i A') }}
                                            </p>
                                            <p>
                                                <strong>Type:</strong> {{ ucfirst($appointment->patient_type) }}
                                            </p>
                                            @if ($appointment->notes)
                                                <p>
                                                    <strong>Notes:</strong> {{ Str::limit($appointment->notes, 100) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="ml-4">
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
                                        <div class="mt-3">
                                            <a href="{{ route('appointments.show', $appointment) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-gray-600 dark:text-gray-400">You have no recent treatments.</p>
                </div>
            @endif

            <div class="mt-6">
                <a href="{{ route('appointments.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                    View All Appointments
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
