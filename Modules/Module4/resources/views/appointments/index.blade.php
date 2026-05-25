<x-app-layout>
    <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 min-h-screen pb-12">
        
        <div class="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white py-8 px-6 shadow-lg mb-8">
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

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($appointments->count())
                <div class="space-y-4">
                    @foreach ($appointments as $appointment)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-200 overflow-hidden relative flex flex-col md:flex-row items-start md:items-center justify-between p-6 gap-6">
                            
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 
                                @if ($appointment->status === 'pending') bg-amber-400
                                @elif ($appointment->status === 'confirmed') bg-blue-500
                                @else bg-emerald-500 @endif">
                            </div>

                            <div class="flex-1 pl-2">
                                <div class="flex flex-wrap items-center gap-3">
                                    <h3 class="text-xl font-bold text-gray-800 tracking-tight">
                                        {{ $appointment->reason_for_visit ?? 'Routine Clinical Checkup' }}
                                    </h3>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold tracking-wide
                                        @if ($appointment->status === 'pending') bg-amber-50 text-amber-700 border border-amber-200
                                        @elif ($appointment->status === 'confirmed') bg-blue-50 text-blue-700 border border-blue-200
                                        @else bg-emerald-50 text-emerald-700 border border-emerald-200 @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>

                                <div class="flex flex-wrap items-center gap-x-6 gap-y-1.5 mt-3 text-sm text-gray-500 font-medium">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 self-stretch md:self-auto justify-end border-t md:border-t-0 border-gray-100 pt-4 md:pt-0 w-full md:w-auto">
                                <a href="{{ route('module4.appointments.show', $appointment) }}" class="px-4 py-2 text-sm font-semibold text-cyan-600 hover:text-cyan-700 hover:bg-cyan-50 rounded-xl transition">
                                    View Details
                                </a>
                                <a href="{{ route('module4.appointments.edit', $appointment) }}" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-xl transition">
                                    Edit
                                </a>
                                <form action="{{ route('module4.appointments.destroy', $appointment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-red-600 hover:text-red-700 hover:bg-red-50 rounded-xl transition"
                                            onclick="return confirm('Are you sure you want to delete this appointment instance?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center max-w-2xl mx-auto mt-12">
                    <div class="bg-cyan-50 rounded-full p-5 w-20 h-20 mx-auto mb-6 flex items-center justify-center border border-cyan-100">
                        <svg class="w-10 h-10 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">No Scheduled Appointments</h3>
                    <p class="text-gray-500 mt-2 max-w-sm mx-auto mb-6">There are currently no active appointment instances registered under your profile logs.</p>
                    <a href="{{ route('module4.appointments.choose-patient-type') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-cyan-600 to-cyan-500 text-white rounded-xl font-bold hover:from-cyan-500 hover:to-cyan-400 transition shadow-md">
                        Schedule Your First Appointment
                    </a>
                </div>
            @endif

<!-- =========================================================================
     REAL VISIBLE PARAMETERIZED DATABASE ROUTINE DIAGNOSTIC INSPECTOR
     ========================================================================= -->
<div class="bg-white rounded-2xl shadow-xl border-b-4 border-cyan-600 overflow-hidden mt-12">
    <div class="bg-gradient-to-r from-cyan-700 to-cyan-600 text-white p-6">
        <h3 class="text-xl font-bold tracking-wide flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            Database Store Routine Diagnostic Inspector
        </h3>
        <p class="text-cyan-100 text-xs mt-1">Specify targeted records below to interrogate stored system functions.</p>
    </div>

    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6 bg-gray-50">
        <!-- Function 1 Card -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
            <div>
                <span class="bg-blue-100 text-blue-800 text-xs font-bold uppercase px-2 py-0.5 rounded">Function 1</span>
                <h4 class="font-bold text-gray-800 mt-2 text-sm">get_patient_treatment_count()</h4>
                <p class="text-gray-500 text-xs mt-1 mb-4">Calculates total historic treatment entries registered directly under the targeted user.</p>
                
                <!-- NEW INPUT FIELD FOR USER ID -->
                <div class="mb-2">
                    <label class="block text-xs font-bold text-cyan-700 uppercase mb-1">Target User ID</label>
                    <input type="number" id="param-user-1" value="{{ auth()->id() }}" class="w-full px-3 py-2 border-2 border-cyan-400 rounded-lg text-sm font-bold bg-white text-gray-900 shadow-sm focus:outline-none focus:border-cyan-600">
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div id="res-treatment-count" class="text-2xl font-black text-cyan-600 mb-2">--</div>
                <button onclick="runDiagnostic1('{{ route('module4.diagnostics.treatment-count') }}')" class="w-full text-center px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold text-xs rounded-lg transition shadow-sm">
                    Execute Function
                </button>
            </div>
        </div>

        <!-- Function 2 Card -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
            <div>
                <span class="bg-purple-100 text-purple-800 text-xs font-bold uppercase px-2 py-0.5 rounded">Function 2</span>
                <h4 class="font-bold text-gray-800 mt-2 text-sm">get_patient_daily_appointment_count()</h4>
                <p class="text-gray-500 text-xs mt-1 mb-4">Computes ongoing scheduling allocations registered for your target profile for a designated date.</p>
                
                <!-- NEW INPUT FIELDS FOR USER ID AND DATE -->
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-cyan-700 uppercase mb-1">Target User ID</label>
                        <input type="number" id="param-user-2" value="{{ auth()->id() }}" class="w-full px-3 py-2 border-2 border-cyan-400 rounded-lg text-sm font-bold bg-white text-gray-900 shadow-sm focus:outline-none focus:border-cyan-600">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-cyan-700 uppercase mb-1">Target Date</label>
                        <input type="date" id="param-date-2" value="{{ now()->toDateString() }}" class="w-full px-3 py-2 border-2 border-cyan-400 rounded-lg text-sm font-bold bg-white text-gray-900 shadow-sm focus:outline-none focus:border-cyan-600">
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div id="res-daily-appointments" class="text-2xl font-black text-cyan-600 mb-2">--</div>
                <button onclick="runDiagnostic2('{{ route('module4.diagnostics.daily-appointments') }}')" class="w-full text-center px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold text-xs rounded-lg transition shadow-sm">
                    Execute Function
                </button>
            </div>
        </div>

        <!-- Function 3 Card -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
            <div>
                <span class="bg-amber-100 text-amber-800 text-xs font-bold uppercase px-2 py-0.5 rounded">Function 3</span>
                <h4 class="font-bold text-gray-800 mt-2 text-sm">has_treatment_time_conflict()</h4>
                <p class="text-gray-500 text-xs mt-1 mb-4">Inspects core system registries to establish if a safety booking collision occurs at a precise time block.</p>
                
                <!-- NEW INPUT FIELDS FOR USER ID, DATE, AND TIME -->
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-cyan-700 uppercase mb-1">Target User ID</label>
                        <input type="number" id="param-user-3" value="{{ auth()->id() }}" class="w-full px-3 py-2 border-2 border-cyan-400 rounded-lg text-sm font-bold bg-white text-gray-900 shadow-sm focus:outline-none focus:border-cyan-600">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-bold text-cyan-700 uppercase mb-1">Date</label>
                            <input type="date" id="param-date-3" value="{{ now()->toDateString() }}" class="w-full px-3 py-2 border-2 border-cyan-400 rounded-lg text-sm font-bold bg-white text-gray-900 shadow-sm focus:outline-none focus:border-cyan-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-cyan-700 uppercase mb-1">Time</label>
                            <input type="time" id="param-time-3" value="10:00" class="w-full px-3 py-2 border-2 border-cyan-400 rounded-lg text-sm font-bold bg-white text-gray-900 shadow-sm focus:outline-none focus:border-cyan-600">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div id="res-check-conflict" class="text-sm font-bold text-cyan-600 mb-2">--</div>
                <button onclick="runDiagnostic3('{{ route('module4.diagnostics.check-conflict') }}')" class="w-full text-center px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold text-xs rounded-lg transition shadow-sm">
                    Execute Function
                </button>
            </div>
        </div>
    </div>
</div>

    <script>
        function fetchDiagnostic(url, targetElement, displayClass = "text-2xl font-black text-cyan-600 mb-2") {
            targetElement.innerHTML = `<span class="text-xs text-gray-400 font-normal animate-pulse">Running function...</span>`;

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error();
                return res.json();
            })
            .then(data => {
                let parsedVal = data.value;
                targetElement.innerText = parsedVal;
                
                if(parsedVal.toString().includes('Conflict') || parsedVal.toString() === 'Yes') {
                    targetElement.className = "text-sm font-bold text-red-600 mb-2 animate-bounce";
                } else {
                    targetElement.className = displayClass;
                }
            })
            .catch(() => {
                targetElement.innerHTML = `<span class="text-xs text-red-500 font-medium">Execution Error</span>`;
            });
        }

        function runDiagnostic1(baseUrl) {
            const userId = document.getElementById('param-user-1').value;
            const target = document.getElementById('res-treatment-count');
            fetchDiagnostic(`${baseUrl}?user_id=${userId}`, target, "text-2xl font-black text-cyan-600 mb-2");
        }

        function runDiagnostic2(baseUrl) {
            const userId = document.getElementById('param-user-2').value;
            const date = document.getElementById('param-date-2').value;
            const target = document.getElementById('res-daily-appointments');
            fetchDiagnostic(`${baseUrl}?user_id=${userId}&date=${date}`, target, "text-2xl font-black text-cyan-600 mb-2");
        }

        function runDiagnostic3(baseUrl) {
            const userId = document.getElementById('param-user-3').value;
            const date = document.getElementById('param-date-3').value;
            let time = document.getElementById('param-time-3').value;
            
            if(time && time.split(':').length === 2) {
                time = `${time}:00`;
            }
            
            const target = document.getElementById('res-check-conflict');
            fetchDiagnostic(`${baseUrl}?user_id=${userId}&date=${date}&time=${time}`, target, "text-sm font-bold text-emerald-600 mb-2");
        }
    </script>
</x-app-layout>