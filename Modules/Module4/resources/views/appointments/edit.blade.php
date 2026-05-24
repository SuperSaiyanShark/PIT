<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-cyan-500 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <form action="{{ route('appointments.update', $appointment) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Patient Type -->
                        <div>
                            <label for="patient_type" class="block text-sm font-medium text-white mb-2">
                                Patient Type
                            </label>
                            <select id="patient_type" name="patient_type" 
                                    class="block w-full px-3 py-2 border border-teal-300 bg-teal-100 text-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500">
                                <option value="">Select patient type</option>
                                <option value="inpatient" {{ $appointment->patient_type === 'inpatient' ? 'selected' : '' }}>Inpatient</option>
                                <option value="outpatient" {{ $appointment->patient_type === 'outpatient' ? 'selected' : '' }}>Outpatient</option>
                            </select>
                            @error('patient_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Appointment Date -->
                        <div>
                            <label for="appointment_date" class="block text-sm font-medium text-white mb-2">
                                Appointment Date
                            </label>
                            <input type="date" id="appointment_date" name="appointment_date" 
                                   class="block w-full px-3 py-2 border border-teal-300 bg-teal-100 text-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                                   value="{{ $appointment->appointment_date->format('Y-m-d') }}" required>
                            @error('appointment_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Appointment Time -->
                        <div>
                            <label for="appointment_time" class="block text-sm font-medium text-white mb-2">
                                Appointment Time
                            </label>
                            <input type="time" id="appointment_time" name="appointment_time" 
                                   class="block w-full px-3 py-2 border border-teal-300 bg-teal-100 text-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                                   value="{{ $appointment->appointment_time->format('H:i') }}" required>
                            @error('appointment_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Reason for Visit -->
                        <div>
                            <label for="reason_for_visit" class="block text-sm font-medium text-white mb-2">
                                Reason for Visit
                            </label>
                            <input type="text" id="reason_for_visit" name="reason_for_visit" 
                                   class="block w-full px-3 py-2 border border-teal-300 bg-teal-100 text-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                                   value="{{ $appointment->reason_for_visit }}" placeholder="e.g., General checkup" required>
                            @error('reason_for_visit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-white mb-2">
                                Additional Notes
                            </label>
                            <textarea id="notes" name="notes" rows="4"
                                      class="block w-full px-3 py-2 border border-cyan-300 bg-cyan-100 text-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-cyan-500 focus:border-cyan-500"
                                      placeholder="Any additional information...">{{ $appointment->notes }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-4">
                            <button type="submit" class="px-4 py-2 bg-white text-cyan-600 rounded-md hover:bg-cyan-100 focus:outline-none focus:ring-2 focus:ring-white">
                                Update Appointment
                            </button>
                            <a href="{{ route('appointments.show', $appointment) }}" class="px-4 py-2 bg-cyan-400 text-white rounded-md hover:bg-cyan-300">
                                Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
