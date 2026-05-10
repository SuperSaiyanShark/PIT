@extends('layouts.app')

@section('page-title', 'Patient Management')

@push('styles')
<style>
    /* ── STAT CARDS ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        border-radius: 18px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        border: none;
        position: relative;
        overflow: hidden;
        transition: transform 0.18s, box-shadow 0.18s;
    }

    /* Decorative circle in top-right corner of each card */
    .stat-card::before {
        content: '';
        position: absolute;
        top: -30px; right: -30px;
        width: 110px; height: 110px;
        border-radius: 50%;
        background: rgba(255,255,255,0.10);
        pointer-events: none;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        bottom: -40px; right: 30px;
        width: 80px; height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        pointer-events: none;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 32px rgba(0,0,0,0.20);
    }

    /* Four distinct blue-family gradients */
    .stat-card.c1 { background: linear-gradient(135deg, #0b7285, #15aabf); } /* teal-cyan */
    .stat-card.c2 { background: linear-gradient(135deg, #1971c2, #339af0); } /* royal blue */
    .stat-card.c3 { background: linear-gradient(135deg, #0c8599, #22b8cf); } /* ocean */
    .stat-card.c4 { background: linear-gradient(135deg, #1864ab, #74c0fc); } /* sky blue */

    .stat-icon {
        width: 50px; height: 50px;
        border-radius: 14px;
        background: rgba(255,255,255,0.20);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon svg { width: 24px; height: 24px; stroke: white; }

    .stat-text { position: relative; z-index: 1; }

    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: white;
        line-height: 1;
        letter-spacing: -0.5px;
    }

    .stat-label {
        font-size: 12px;
        color: rgba(255,255,255,0.82);
        margin-top: 5px;
        font-weight: 500;
    }

    /* ── TOOLBAR ── */
    .toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        gap: 12px;
    }

    .search-wrap {
        position: relative;
        flex: 1;
        max-width: 380px;
    }

    .search-wrap svg {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px; height: 16px;
        color: var(--gray-500);
        stroke: var(--gray-500);
        pointer-events: none;
    }

    .search-wrap input {
        padding-left: 38px;
        background: white;
        border-radius: 10px;
    }

    /* ── ACTION LINKS ── */
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s;
        cursor: pointer;
        border: none;
        font-family: var(--font);
    }

    .action-btn svg { width: 13px; height: 13px; }

    .action-view {
        background: var(--teal-100);
        color: var(--teal-700);
    }
    .action-view:hover { background: var(--teal-200, #a5e9f0); }

    .action-edit {
        background: var(--gray-100);
        color: var(--gray-700);
    }
    .action-edit:hover { background: var(--gray-200, #e5e7eb); }

    .actions-cell { display: flex; align-items: center; gap: 6px; }

    @media (max-width: 900px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

@section('content')

<!-- STAT CARDS -->
<div class="stats-grid">
    <div class="stat-card c1">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
        <div class="stat-text">
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Patients</div>
        </div>
    </div>

    <div class="stat-card c2">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
            </svg>
        </div>
        <div class="stat-text">
            <div class="stat-value">{{ $stats['admitted'] }}</div>
            <div class="stat-label">Currently Admitted</div>
        </div>
    </div>

    <div class="stat-card c3">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div class="stat-text">
            <div class="stat-value">{{ $stats['discharged_today'] }}</div>
            <div class="stat-label">Discharged Today</div>
        </div>
    </div>

    <div class="stat-card c4">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="3" y1="9" x2="21" y2="9"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8"  y1="2" x2="8"  y2="6"/>
            </svg>
        </div>
        <div class="stat-text">
            <div class="stat-value">{{ $stats['beds_available'] }}</div>
            <div class="stat-label">Beds Available</div>
        </div>
    </div>
</div>

<!-- MAIN TABLE CARD -->
<div class="card">
    <div class="card-header">
        <h3>Patient Registry</h3>
        <div class="toolbar" style="margin-bottom:0;">
            <form method="GET" action="{{ route('patients.index') }}" class="search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" placeholder="Search by name, ID or phone…"
                       value="{{ request('search') }}" autocomplete="off">
            </form>
            <button class="btn btn-primary" onclick="openModal('registerModal')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                New Patient
            </button>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Bed & Ward</th>
                    <th>Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                <tr>
                    <td><span class="patient-id">#{{ str_pad($patient->PatientID, 6, '0', STR_PAD_LEFT) }}</span></td>
                    <td><span class="patient-name">{{ $patient->FullName }}</span></td>
                    <td>{{ $patient->age }}</td>
                    <td>{{ $patient->Sex }}</td>
                    <td>{{ $patient->PhoneNumber ?? '—' }}</td>
                    <td>
                        @php $status = $patient->status; @endphp
                        <span class="badge badge-{{ strtolower($status) }}">{{ $status }}</span>
                    </td>
                    <td class="text-muted">{{ $patient->bed_and_ward }}</td>
                    <td class="text-muted text-sm">{{ $patient->DateRegistered ? $patient->DateRegistered->format('M d, Y') : '—' }}</td>
                    <td>
                        <div class="actions-cell">
                            <a href="{{ route('patients.show', $patient) }}" class="action-btn action-view">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                View
                            </a>
                            <button class="action-btn action-edit"
                                onclick="openEditModal({{ $patient->PatientID }})">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                                Edit
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                            </svg>
                            <p>No patients found{{ request('search') ? ' for "'.request('search').'"' : '' }}.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($patients->hasPages())
    <div class="pagination">
        {{ $patients->links() }}
    </div>
    @endif
</div>

{{-- ═══════════════════════════════════════════ --}}
{{--          REGISTER NEW PATIENT MODAL         --}}
{{-- ═══════════════════════════════════════════ --}}
<div class="modal-backdrop" id="registerModal">
    <div class="modal">
        <div class="modal-header">
            <div>
                <h2>New Patient Registration</h2>
                <p>Fill in the patient's information below</p>
            </div>
            <button class="modal-close" onclick="closeModal('registerModal')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('patients.store') }}" method="POST">
            @csrf
            <div class="modal-body">

                <div class="form-section-title">Personal Information</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>First Name <span class="req">*</span></label>
                        <input type="text" name="FirstName" value="{{ old('FirstName') }}" required>
                        @error('FirstName') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Last Name <span class="req">*</span></label>
                        <input type="text" name="LastName" value="{{ old('LastName') }}" required>
                        @error('LastName') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Date of Birth <span class="req">*</span></label>
                        <input type="date" name="DOB" value="{{ old('DOB') }}" required>
                        @error('DOB') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Gender <span class="req">*</span></label>
                        <select name="Sex" required>
                            <option value="">Select gender</option>
                            <option value="Male"   {{ old('Sex') == 'Male'   ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('Sex') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other"  {{ old('Sex') == 'Other'  ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('Sex') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Blood Type</label>
                        <select name="BloodType">
                            <option value="">Unknown</option>
                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
                            <option value="{{ $bt }}" {{ old('BloodType') == $bt ? 'selected' : '' }}>{{ $bt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="PhoneNumber" value="{{ old('PhoneNumber') }}" placeholder="+63…">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="Email" value="{{ old('Email') }}">
                    </div>
                    <div class="form-group span-2">
                        <label>Home Address</label>
                        <input type="text" name="Address" value="{{ old('Address') }}">
                    </div>
                    <div class="form-group span-2">
                        <label>Known Allergies</label>
                        <input type="text" name="Allergies" value="{{ old('Allergies') }}" placeholder="e.g. Penicillin, Aspirin">
                    </div>
                    <div class="form-group span-2">
                        <label>Existing Medical Conditions</label>
                        <input type="text" name="MedicalConditions" value="{{ old('MedicalConditions') }}" placeholder="e.g. Hypertension, Diabetes">
                    </div>
                </div>

                <div class="form-section-title">Next of Kin / Emergency Contact</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="nok_FullName" value="{{ old('nok_FullName') }}">
                    </div>
                    <div class="form-group">
                        <label>Relationship</label>
                        <input type="text" name="nok_Relationship" value="{{ old('nok_Relationship') }}" placeholder="e.g. Spouse, Parent">
                    </div>
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" name="nok_PhoneNumber" value="{{ old('nok_PhoneNumber') }}">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="nok_Address" value="{{ old('nok_Address') }}">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('registerModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Register Patient</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════ --}}
{{--          EDIT PATIENT MODAL (dynamic)       --}}
{{-- ═══════════════════════════════════════════ --}}
<div class="modal-backdrop" id="editModal">
    <div class="modal">
        <div class="modal-header">
            <div>
                <h2>Edit Patient</h2>
                <p>Update patient information</p>
            </div>
            <button class="modal-close" onclick="closeModal('editModal')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div id="editModalBody" style="padding: 40px; text-align:center; color: var(--gray-500);">
            Loading patient data…
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}

// Close on backdrop click
document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
    backdrop.addEventListener('click', e => {
        if (e.target === backdrop) closeModal(backdrop.id);
    });
});

// Open edit modal and dynamically load a form
function openEditModal(patientId) {
    openModal('editModal');

    // Patient data is embedded as JSON via the table rows to avoid extra AJAX
    const patients = @json($patients->items());
    const patient = patients.find(p => p.PatientID == patientId);

    if (!patient) {
        document.getElementById('editModalBody').innerHTML = '<p>Could not load patient data.</p>';
        return;
    }

    const nok = patient.next_of_kin || {};
    const bloodTypes = ['A+','A-','B+','B-','AB+','AB-','O+','O-'];
    const btOptions = bloodTypes.map(bt =>
        `<option value="${bt}" ${patient.BloodType === bt ? 'selected' : ''}>${bt}</option>`
    ).join('');

    document.getElementById('editModalBody').innerHTML = `
        <form action="/patients/${patient.PatientID}" method="POST">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
            <div class="modal-body" style="padding-top:0">
                <div class="form-section-title">Personal Information</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>First Name <span class="req">*</span></label>
                        <input type="text" name="FirstName" value="${patient.FirstName}" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name <span class="req">*</span></label>
                        <input type="text" name="LastName" value="${patient.LastName}" required>
                    </div>
                    <div class="form-group">
                        <label>Date of Birth <span class="req">*</span></label>
                        <input type="date" name="DOB" value="${patient.DOB}" required>
                    </div>
                    <div class="form-group">
                        <label>Gender <span class="req">*</span></label>
                        <select name="Sex" required>
                            <option value="Male" ${patient.Sex==='Male'?'selected':''}>Male</option>
                            <option value="Female" ${patient.Sex==='Female'?'selected':''}>Female</option>
                            <option value="Other" ${patient.Sex==='Other'?'selected':''}>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Blood Type</label>
                        <select name="BloodType"><option value="">Unknown</option>${btOptions}</select>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="PhoneNumber" value="${patient.PhoneNumber || ''}">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="Email" value="${patient.Email || ''}">
                    </div>
                    <div class="form-group span-2">
                        <label>Address</label>
                        <input type="text" name="Address" value="${patient.Address || ''}">
                    </div>
                    <div class="form-group span-2">
                        <label>Allergies</label>
                        <input type="text" name="Allergies" value="${patient.Allergies || ''}">
                    </div>
                    <div class="form-group span-2">
                        <label>Medical Conditions</label>
                        <input type="text" name="MedicalConditions" value="${patient.MedicalConditions || ''}">
                    </div>
                </div>

                <div class="form-section-title">Next of Kin</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="nok_FullName" value="${nok.FullName || ''}">
                    </div>
                    <div class="form-group">
                        <label>Relationship</label>
                        <input type="text" name="nok_Relationship" value="${nok.Relationship || ''}">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="nok_PhoneNumber" value="${nok.PhoneNumber || ''}">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="nok_Address" value="${nok.Address || ''}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('editModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    `;
}

// Reopen modal if validation errors exist
@if($errors->any())
    openModal('registerModal');
@endif
</script>
@endpush
