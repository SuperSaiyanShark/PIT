<x-app-layout>
    <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 min-h-screen py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white p-6 rounded-2xl shadow-lg mb-6">
                <h2 class="text-2xl font-bold leading-tight">{{ __('Edit Appointment') }}</h2>
                <p class="text-cyan-100 text-sm mt-1">Modifying appointment record ID #{{ $appointment->id }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 border-b-4 border-cyan-500">
                <form action="{{ route('module4.appointments.update', $appointment) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="patient_type" class="block text-sm font-bold text-gray-700 mb-2">Patient Type</label>
                        <select id="patient_type" name="patient_type" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-gray-50 text-gray-900 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition">
                            <option value="inpatient" {{ $appointment->patient_type === 'inpatient' ? 'selected' : '' }}>Inpatient</option>
                            <option value="outpatient" {{ $appointment->patient_type === 'outpatient' ? 'selected' : '' }}>Outpatient</option>
                        </select>
                        @error('patient_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="appointment_date" class="block text-sm font-bold text-gray-700 mb-2">Appointment Date</label>
                            <input type="date" id="appointment_date" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-b') ?? $appointment->appointment_date) }}" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-gray-50 text-gray-900 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition">
                            @error('appointment_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="appointment_time" class="block text-sm font-bold text-gray-700 mb-2">Appointment Time</label>
                            <input type="time" id="appointment_time" name="appointment_time" value="{{ old('appointment_time', $appointment->appointment_time) }}" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-gray-50 text-gray-900 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition">
                            @error('appointment_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="patient_id" class="block text-sm font-bold text-gray-700 mb-2">Patient ID Reference</label>
                            <input type="number" id="patient_id" name="patient_id" value="{{ old('patient_id', $appointment->patient_id) }}" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-gray-50 text-gray-900 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition">
                            @error('patient_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="doctor_id" class="block text-sm font-bold text-gray-700 mb-2">Assigned Doctor ID</label>
                            <input type="number" id="doctor_id" name="doctor_id" value="{{ old('doctor_id', $appointment->doctor_id) }}" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-gray-50 text-gray-900 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition">
                            @error('doctor_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="reason_for_visit" class="block text-sm font-bold text-gray-700 mb-2">Reason for Visit</label>
                        <input type="text" id="reason_for_visit" name="reason_for_visit" value="{{ old('reason_for_visit', $appointment->reason_for_visit) }}" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-gray-50 text-gray-900 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition">
                        @error('reason_for_visit') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-bold text-gray-700 mb-2">Additional Notes</label>
                        <textarea id="notes" name="notes" rows="4" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-gray-50 text-gray-900 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition">{{ old('notes', $appointment->notes) }}</textarea>
                        @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-4 pt-4 border-t border-gray-100">
                        <button type="submit" class="px-6 py-3 bg-cyan-600 text-white font-semibold rounded-xl hover:bg-cyan-700 transition shadow-md flex-1 text-center">
                            Update Appointment
                        </button>
                        <a href="{{ route('module4.appointments.index') }}" class="px-6 py-3 bg-gray-100 text-gray-600 font-semibold rounded-xl hover:bg-gray-200 transition text-center">
                            Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>