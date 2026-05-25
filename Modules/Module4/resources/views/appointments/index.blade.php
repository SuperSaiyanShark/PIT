<x-app-layout>
    <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 min-h-screen">
        
        <div class="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white py-8 px-6 shadow-lg">
            <div class="flex flex-col md:flex-row justify-between items-center max-w-6xl mx-auto gap-6">
                <div>
                    <h1 class="text-4xl font-bold tracking-wide">WELLMEADOWS HOSPITAL</h1>
                    <p class="text-cyan-100 mt-2 text-lg uppercase tracking-wider font-medium flex items-center gap-2">
                        <span>{{ __('My Appointments') }}</span>
                        <span class="text-cyan-300/50">•</span>
                        <span class="text-sm normal-case tracking-normal text-cyan-200/90">Manage and track your upcoming scheduled clinical visits</span>
                    </p>
                </div>
                <div class="flex flex-wrap gap-3 w-full md:w-auto justify-end">
                    <a href="{{ route('module4.appointments.choose-patient-type') }}" class="bg-white text-cyan-600 px-5 py-2.5 rounded-lg font-bold hover:bg-cyan-50 transition shadow-md text-sm text-center flex-1 md:flex-none">
                        Schedule New Appointment
                    </a>
                    <a href="{{ route('module4.dashboard') }}" class="bg-cyan-700 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-cyan-800 transition shadow-md text-sm text-center flex-1 md:flex-none">
                        Module 4 Dashboard
                    </a>
                    <a href="{{ route('dashboard') }}" class="bg-cyan-800 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-cyan-900 transition shadow-md text-sm text-center flex-1 md:flex-none">
                        Main Dashboard
                    </a>
                </div>
            </div>
        </div>

        <div class="py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
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
                                        <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-600 font-semibold rounded-xl hover:bg-red-100 transition text-sm text-center" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                            Cancel
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-2xl shadow-lg p-12 text-center border-b-4 border-cyan-500 max-w-2xl mx-auto mt-6">
                        <div class="bg-cyan-100 rounded-full p-6 w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                            <svg class="w-10 h-10 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">No Scheduled Appointments</h3>
                        <p class="text-gray-500 mt-2 max-w-sm mx-auto mb-6">There are currently no active appointment instances registered under your file profiles.</p>
                        <a href="{{ route('module4.appointments.choose-patient-type') }}" class="inline-block px-6 py-3 bg-cyan-600 text-white font-semibold rounded-xl hover:bg-cyan-700 transition shadow-md">
                            Schedule Your First Appointment
                        </a>
                    </div>
                @endif

                <!-- =========================================================================
                     DATABASE STORE ROUTINE ROUTINE DIAGNOSTIC INSPECTOR (MODULE 4)
                     ========================================================================= -->
                <div class="bg-white rounded-2xl shadow-xl border-b-4 border-cyan-600 overflow-hidden mt-12">
                    <div class="bg-gradient-to-r from-cyan-700 to-cyan-600 text-white p-6">
                        <h3 class="text-xl font-bold tracking-wide flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            Database Store Routine Diagnostic Inspector
                        </h3>
                        <p class="text-cyan-100 text-xs mt-1">Interrogate compiled database schema functions dynamically without page reloading.</p>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6 bg-gray-50">
                        <!-- Function 1 Card -->
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
                            <div>
                                <span class="bg-blue-100 text-blue-800 text-xs font-bold uppercase px-2 py-0.5 rounded">Function 1</span>
                                <h4 class="font-bold text-gray-800 mt-2 text-sm">get_patient_treatment_count()</h4>
                                <p class="text-gray-500 text-xs mt-1">Calculates total historic treatment entries registered directly under your profile ID.</p>
                            </div>
                            <div class="mt-4">
                                <div id="res-treatment-count" class="text-2xl font-black text-cyan-600 mb-2 hidden">--</div>
                                <button onclick="runDiagnostic('{{ route('module4.diagnostics.treatment-count') }}', 'res-treatment-count')" class="w-full text-center px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold text-xs rounded-lg transition shadow-sm">
                                    Execute Function
                                </button>
                            </div>
                        </div>

                        <!-- Function 2 Card -->
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
                            <div>
                                <span class="bg-purple-100 text-purple-800 text-xs font-bold uppercase px-2 py-0.5 rounded">Function 2</span>
                                <h4 class="font-bold text-gray-800 mt-2 text-sm">get_patient_daily_appointment_count()</h4>
                                <p class="text-gray-500 text-xs mt-1">Computes ongoing scheduling allocations registered for your target profile for today.</p>
                            </div>
                            <div class="mt-4">
                                <div id="res-daily-appointments" class="text-2xl font-black text-cyan-600 mb-2 hidden">--</div>
                                <button onclick="runDiagnostic('{{ route('module4.diagnostics.daily-appointments') }}', 'res-daily-appointments')" class="w-full text-center px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold text-xs rounded-lg transition shadow-sm">
                                    Execute Function
                                </button>
                            </div>
                        </div>

                        <!-- Function 3 Card -->
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
                            <div>
                                <span class="bg-amber-100 text-amber-800 text-xs font-bold uppercase px-2 py-0.5 rounded">Function 3</span>
                                <h4 class="font-bold text-gray-800 mt-2 text-sm">has_treatment_time_conflict()</h4>
                                <p class="text-gray-500 text-xs mt-1">Inspects core system registries to establish if a safety collision state or double booking occurs right now.</p>
                            </div>
                            <div class="mt-4">
                                <div id="res-check-conflict" class="text-sm font-bold text-cyan-600 mb-2 hidden">--</div>
                                <button onclick="runDiagnostic('{{ route('module4.diagnostics.check-conflict') }}', 'res-check-conflict')" class="w-full text-center px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold text-xs rounded-lg transition shadow-sm">
                                    Execute Function
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Async Routine Script Interceptor Engine -->
    <script>
        function runDiagnostic(url, resultElementId) {
            const target = document.getElementById(resultElementId);
            target.classList.remove('hidden');
            target.innerHTML = `<span class="text-xs text-gray-400 font-normal animate-pulse">Pinging database...</span>`;
            
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Query fault');
                return res.json();
            })
            .then(data => {
                target.innerText = data.value;
                if(data.value.toString().includes('Conflict')) {
                    target.className = "text-sm font-bold text-red-600 mb-2 animate-bounce";
                } else {
                    target.className = "text-xl font-black text-cyan-600 mb-2";
                }
            })
            .catch(() => {
                target.innerHTML = `<span class="text-xs text-red-500 font-medium">Routine execution failed</span>`;
            });
        }
    </script>
</x-app-layout>