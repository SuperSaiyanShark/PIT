@extends('layouts.app')

@section('page-title', $patient->FullName)

@push('styles')
<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--gray-500);
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 20px;
        transition: color 0.15s;
    }
    .back-link:hover { color: var(--teal-600); }
    .back-link svg { width: 15px; height: 15px; }

    /* ── PATIENT HERO CARD ── */
    .patient-hero {
        background: linear-gradient(135deg, var(--teal-700) 0%, var(--teal-500) 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 24px;
        position: relative;
        overflow: hidden;
    }

    .patient-hero::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
    }

    .patient-hero::after {
        content: '';
        position: absolute;
        bottom: -60px; right: 80px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }

    .patient-avatar {
        width: 68px; height: 68px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 26px;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
        border: 3px solid rgba(255,255,255,0.3);
    }

    .patient-hero-info { flex: 1; }

    .patient-hero-name {
        font-size: 24px;
        font-weight: 700;
        color: white;
    }

    .patient-hero-sub {
        font-size: 13px;
        color: rgba(255,255,255,0.75);
        margin-top: 4px;
    }

    .patient-hero-badges {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 12px;
        flex-wrap: wrap;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        background: rgba(255,255,255,0.18);
        color: white;
    }

    .hero-badge.admitted { background: rgba(41,168,124,0.35); }
    .hero-badge.discharged { background: rgba(255,255,255,0.12); }
    .hero-badge.outpatient { background: rgba(240,165,0,0.35); }

    .hero-actions { display: flex; gap: 10px; z-index: 1; }

    /* ── TABS ── */
    .tabs-bar {
        display: flex;
        gap: 4px;
        background: white;
        border-radius: 14px;
        padding: 6px;
        border: 1px solid var(--gray-300);
        margin-bottom: 24px;
        width: fit-content;
    }

    .tab-btn {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        border-radius: 10px;
        border: none;
        background: transparent;
        color: var(--gray-500);
        font-family: var(--font);
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
        white-space: nowrap;
    }

    .tab-btn svg { width: 16px; height: 16px; }

    .tab-btn:hover { background: var(--teal-50); color: var(--teal-700); }
    .tab-btn.active { background: var(--teal-500); color: white; }

    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* ── INFO GRID ── */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    .info-block {
        background: white;
        border-radius: 16px;
        border: 1px solid var(--gray-300);
        overflow: hidden;
    }

    .info-block-header {
        padding: 14px 20px;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-block-header h4 {
        font-size: 13px;
        font-weight: 700;
        color: var(--gray-700);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .info-block-header svg {
        width: 16px; height: 16px;
        color: var(--teal-500); stroke: var(--teal-500);
    }

    .info-rows { padding: 8px 0; }

    .info-row {
        display: flex;
        padding: 10px 20px;
        border-bottom: 1px solid var(--gray-50);
    }

    .info-row:last-child { border-bottom: none; }

    .info-label {
        width: 140px;
        flex-shrink: 0;
        font-size: 12px;
        font-weight: 600;
        color: var(--gray-500);
    }

    .info-value {
        font-size: 13.5px;
        color: var(--gray-900);
        font-weight: 500;
    }

    /* ── ALERT BOXES ── */
    .info-alert {
        margin: 12px 20px;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 13px;
    }

    .info-alert-emergency { background: #fff1f2; border: 1px solid #fecaca; }
    .info-alert-allergy   { background: #fefce8; border: 1px solid #fde68a; }
    .info-alert-condition { background: #eff6ff; border: 1px solid #bfdbfe; }

    .info-alert-title {
        font-weight: 700;
        font-size: 12px;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .info-alert-emergency .info-alert-title { color: var(--danger); }
    .info-alert-allergy   .info-alert-title { color: #92400e; }
    .info-alert-condition .info-alert-title { color: #1d4ed8; }

    /* ── RECORDS TABLE ── */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .section-header h3 { font-size: 16px; font-weight: 700; }

    /* ── ADMISSION CARD ── */
    .admission-card {
        background: white;
        border-radius: 14px;
        border: 1px solid var(--gray-300);
        padding: 20px;
        margin-bottom: 14px;
    }

    .admission-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .admission-detail-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
    }

    .admission-detail { font-size: 13px; }
    .admission-detail .label { color: var(--gray-500); font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; }
    .admission-detail .val   { font-weight: 600; margin-top: 2px; }

    @media (max-width: 768px) {
        .info-grid { grid-template-columns: 1fr; }
        .admission-detail-grid { grid-template-columns: 1fr 1fr; }
        .patient-hero { flex-direction: column; align-items: flex-start; }
    }
</style>
@endpush

@section('content')

<a href="{{ route('patients.index') }}" class="back-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
        <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
    </svg>
    Back to Patients
</a>

{{-- PATIENT HERO --}}
@php
    $initials = strtoupper(substr($patient->FirstName, 0, 1) . substr($patient->LastName, 0, 1));
    $status = $patient->status;
@endphp

<div class="patient-hero">
    <div class="patient-avatar">{{ $initials }}</div>
    <div class="patient-hero-info">
        <div class="patient-hero-name">{{ $patient->FullName }}</div>
        <div class="patient-hero-sub">
            Patient ID: #{{ str_pad($patient->PatientID, 6, '0', STR_PAD_LEFT) }}
            &nbsp;·&nbsp; {{ $patient->Sex }}
            &nbsp;·&nbsp; Age {{ $patient->age }}
            @if($patient->BloodType)
            &nbsp;·&nbsp; Blood Type {{ $patient->BloodType }}
            @endif
        </div>
        <div class="patient-hero-badges">
            <span class="hero-badge {{ strtolower($status) }}">{{ $status }}</span>
            @if($patient->latestAdmission && $patient->latestAdmission->Status === 'Admitted')
            <span class="hero-badge">
                Bed {{ $patient->latestAdmission->BedNumber }}
                · {{ $patient->latestAdmission->ward->WardName ?? 'N/A' }}
            </span>
            @endif
        </div>
    </div>
    <div class="hero-actions">
        <button class="btn btn-outline" style="background:rgba(255,255,255,0.15);border-color:rgba(255,255,255,0.3);color:white;"
                onclick="openModal('editPatientModal')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Edit
        </button>
    </div>
</div>

{{-- TABS --}}
<div class="tabs-bar" id="tabsBar">
    <button class="tab-btn active" onclick="switchTab('patientInfo', this)">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>
        Patient Info
    </button>
    <button class="tab-btn" onclick="switchTab('medicalRecords', this)">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            <polyline points="10 9 9 9 8 9"/>
        </svg>
        Medical Records
        @if($patient->medicalRecords->count())
        <span style="background:var(--teal-100);color:var(--teal-700);border-radius:20px;padding:1px 7px;font-size:11px;">
            {{ $patient->medicalRecords->count() }}
        </span>
        @endif
    </button>
    <button class="tab-btn" onclick="switchTab('admissions', this)">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <rect x="3" y="4" width="18" height="18" rx="2"/>
            <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
            <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        Admission / Discharge
    </button>
</div>

{{-- ═══════════════════════════ --}}
{{-- TAB 1: PATIENT INFO        --}}
{{-- ═══════════════════════════ --}}
<div class="tab-panel active" id="tab-patientInfo">
    <div class="info-grid">
        {{-- Personal Details --}}
        <div class="info-block">
            <div class="info-block-header">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
                <h4>Personal Details</h4>
            </div>
            <div class="info-rows">
                <div class="info-row">
                    <div class="info-label">Date of Birth</div>
                    <div class="info-value">{{ $patient->DOB ? $patient->DOB->format('F j, Y') : '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Gender</div>
                    <div class="info-value">{{ $patient->Sex }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Blood Type</div>
                    <div class="info-value">{{ $patient->BloodType ?: '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Phone</div>
                    <div class="info-value">{{ $patient->PhoneNumber ?: '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $patient->Email ?: '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Address</div>
                    <div class="info-value">{{ $patient->Address ?: '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Registered</div>
                    <div class="info-value">{{ $patient->DateRegistered ? $patient->DateRegistered->format('F j, Y') : '—' }}</div>
                </div>
            </div>

            @if($patient->nextOfKin)
            <div class="info-alert info-alert-emergency">
                <div class="info-alert-title">⚠ Emergency Contact</div>
                <div style="font-weight:600;">{{ $patient->nextOfKin->FullName }}</div>
                @if($patient->nextOfKin->Relationship)
                <div class="text-muted text-sm">{{ $patient->nextOfKin->Relationship }}</div>
                @endif
                <div style="margin-top:4px;">{{ $patient->nextOfKin->PhoneNumber ?: 'No phone' }}</div>
            </div>
            @endif
        </div>

        {{-- Medical Summary --}}
        <div class="info-block">
            <div class="info-block-header">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round">
                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                </svg>
                <h4>Medical Summary</h4>
            </div>
            <div class="info-rows">
                <div class="info-row">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="badge badge-{{ strtolower($status) }}">{{ $status }}</span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Total Records</div>
                    <div class="info-value">{{ $patient->medicalRecords->count() }} record(s)</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Total Admissions</div>
                    <div class="info-value">{{ $patient->admissions->count() }} time(s)</div>
                </div>
            </div>

            @if($patient->Allergies)
            <div class="info-alert info-alert-allergy">
                <div class="info-alert-title">Allergies</div>
                <div>{{ $patient->Allergies }}</div>
            </div>
            @endif

            @if($patient->MedicalConditions)
            <div class="info-alert info-alert-condition">
                <div class="info-alert-title">Medical Conditions</div>
                <div>{{ $patient->MedicalConditions }}</div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ═══════════════════════════ --}}
{{-- TAB 2: MEDICAL RECORDS     --}}
{{-- ═══════════════════════════ --}}
<div class="tab-panel" id="tab-medicalRecords">
    <div class="section-header">
        <h3>Medical Records</h3>
        <button class="btn btn-primary btn-sm" onclick="openModal('addRecordModal')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Add Record
        </button>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Diagnosis</th>
                        <th>Treatment</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patient->medicalRecords as $record)
                    <tr>
                        <td>{{ $record->RecordDate ? $record->RecordDate->format('M d, Y') : '—' }}</td>
                        <td style="font-weight:600;">{{ $record->Diagnosis }}</td>
                        <td>{{ $record->Treatment ?: '—' }}</td>
                        <td class="text-muted">{{ $record->Notes ?: '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                                <p>No medical records yet.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════ --}}
{{-- TAB 3: ADMISSION / DISCHARGE   --}}
{{-- ═══════════════════════════════ --}}
<div class="tab-panel" id="tab-admissions">
    <div class="section-header">
        <h3>Admission / Discharge History</h3>
        @php $activeAdmission = $patient->admissions->firstWhere('Status', 'Admitted'); @endphp
        @if(!$activeAdmission)
        <button class="btn btn-primary btn-sm" onclick="openModal('admitModal')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Admit Patient
        </button>
        @else
        <button class="btn btn-danger btn-sm" onclick="openModal('dischargeModal')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <polyline points="9 11 12 14 22 4"/>
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
            </svg>
            Discharge Patient
        </button>
        @endif
    </div>

    @forelse($patient->admissions as $admission)
    <div class="admission-card">
        <div class="admission-card-header">
            <div>
                <span style="font-weight:700;font-size:15px;">
                    {{ $admission->ward->WardName ?? 'Unknown Ward' }}
                </span>
                <span style="color:var(--gray-500);font-size:13px;margin-left:10px;">
                    Bed {{ $admission->BedNumber }}
                </span>
            </div>
            <span class="badge badge-{{ strtolower($admission->Status) }}">{{ $admission->Status }}</span>
        </div>
        <div class="admission-detail-grid">
            <div class="admission-detail">
                <div class="label">Admitted</div>
                <div class="val">{{ $admission->AdmissionDate ? $admission->AdmissionDate->format('M d, Y') : '—' }}</div>
            </div>
            <div class="admission-detail">
                <div class="label">Discharged</div>
                <div class="val">{{ $admission->DischargeDate ? $admission->DischargeDate->format('M d, Y') : '—' }}</div>
            </div>
            <div class="admission-detail">
                <div class="label">Duration</div>
                <div class="val">
                    @if($admission->AdmissionDate)
                        @php
                            $end = $admission->DischargeDate ?? now();
                            $days = $admission->AdmissionDate->diffInDays($end);
                        @endphp
                        {{ $days }} day(s)
                    @else
                        —
                    @endif
                </div>
            </div>
        </div>
        @if($admission->DischargeNotes)
        <div style="margin-top:12px;padding:10px 14px;background:var(--gray-50);border-radius:9px;font-size:13px;color:var(--gray-600);">
            <span style="font-weight:600;">Discharge notes:</span> {{ $admission->DischargeNotes }}
        </div>
        @endif
    </div>
    @empty
    <div class="empty-state" style="background:white;border-radius:16px;border:1px solid var(--gray-300);">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <rect x="3" y="4" width="18" height="18" rx="2"/>
            <line x1="3" y1="9" x2="21" y2="9"/>
        </svg>
        <p>No admissions recorded yet.</p>
    </div>
    @endforelse
</div>

{{-- ═══════════════════ MODALS ═══════════════════ --}}

{{-- ADD MEDICAL RECORD --}}
<div class="modal-backdrop" id="addRecordModal">
    <div class="modal" style="max-width:500px;">
        <div class="modal-header">
            <div><h2>Add Medical Record</h2><p>For {{ $patient->FullName }}</p></div>
            <button class="modal-close" onclick="closeModal('addRecordModal')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('patients.medical-records.store', $patient) }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-grid" style="grid-template-columns:1fr;">
                    <div class="form-group">
                        <label>Diagnosis <span class="req">*</span></label>
                        <input type="text" name="Diagnosis" required placeholder="e.g. Pneumonia">
                    </div>
                    <div class="form-group">
                        <label>Treatment</label>
                        <input type="text" name="Treatment" placeholder="e.g. Amoxicillin 500mg">
                    </div>
                    <div class="form-group">
                        <label>Record Date <span class="req">*</span></label>
                        <input type="date" name="RecordDate" value="{{ today()->format('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="Notes" placeholder="Additional notes…"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('addRecordModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Record</button>
            </div>
        </form>
    </div>
</div>

{{-- ADMIT PATIENT --}}
<div class="modal-backdrop" id="admitModal">
    <div class="modal" style="max-width:500px;">
        <div class="modal-header">
            <div><h2>Admit Patient</h2><p>{{ $patient->FullName }}</p></div>
            <button class="modal-close" onclick="closeModal('admitModal')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('patients.admit', $patient) }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-grid" style="grid-template-columns:1fr;">
                    <div class="form-group">
                        <label>Ward <span class="req">*</span></label>
                        <select name="WardID" required>
                            <option value="">Select a ward</option>
                            @foreach($wards as $ward)
                                <option value="{{ $ward->WardID }}">
                                    {{ $ward->WardName }} ({{ $ward->available_beds }} bed(s) available)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Bed Number <span class="req">*</span></label>
                        <input type="text" name="BedNumber" placeholder="e.g. 201A" required>
                    </div>
                    <div class="form-group">
                        <label>Admission Date <span class="req">*</span></label>
                        <input type="date" name="AdmissionDate" value="{{ today()->format('Y-m-d') }}" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('admitModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Confirm Admission</button>
            </div>
        </form>
    </div>
</div>

{{-- DISCHARGE PATIENT --}}
<div class="modal-backdrop" id="dischargeModal">
    <div class="modal" style="max-width:480px;">
        <div class="modal-header" style="background: linear-gradient(135deg, #7f1d1d, var(--danger));">
            <div><h2>Discharge Patient</h2><p>{{ $patient->FullName }}</p></div>
            <button class="modal-close" onclick="closeModal('dischargeModal')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('patients.discharge', $patient) }}" method="POST">
            @csrf
            <div class="modal-body">
                <p style="color:var(--gray-500);font-size:13.5px;margin-bottom:16px;">
                    This will mark the patient as discharged as of today. Please add any discharge notes below.
                </p>
                <div class="form-group">
                    <label>Discharge Notes</label>
                    <textarea name="DischargeNotes" placeholder="Recovery instructions, follow-up dates…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('dischargeModal')">Cancel</button>
                <button type="submit" class="btn btn-danger">Discharge Patient</button>
            </div>
        </form>
    </div>
</div>

{{-- EDIT PATIENT MODAL --}}
<div class="modal-backdrop" id="editPatientModal">
    <div class="modal">
        <div class="modal-header">
            <div><h2>Edit Patient</h2><p>{{ $patient->FullName }}</p></div>
            <button class="modal-close" onclick="closeModal('editPatientModal')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('patients.update', $patient) }}" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-section-title">Personal Information</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>First Name <span class="req">*</span></label>
                        <input type="text" name="FirstName" value="{{ old('FirstName', $patient->FirstName) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name <span class="req">*</span></label>
                        <input type="text" name="LastName" value="{{ old('LastName', $patient->LastName) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Date of Birth <span class="req">*</span></label>
                        <input type="date" name="DOB" value="{{ old('DOB', $patient->DOB?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Gender <span class="req">*</span></label>
                        <select name="Sex" required>
                            <option value="Male"   {{ $patient->Sex === 'Male'   ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $patient->Sex === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other"  {{ $patient->Sex === 'Other'  ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Blood Type</label>
                        <select name="BloodType">
                            <option value="">Unknown</option>
                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
                            <option value="{{ $bt }}" {{ $patient->BloodType === $bt ? 'selected' : '' }}>{{ $bt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="PhoneNumber" value="{{ old('PhoneNumber', $patient->PhoneNumber) }}">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="Email" value="{{ old('Email', $patient->Email) }}">
                    </div>
                    <div class="form-group span-2">
                        <label>Address</label>
                        <input type="text" name="Address" value="{{ old('Address', $patient->Address) }}">
                    </div>
                    <div class="form-group span-2">
                        <label>Allergies</label>
                        <input type="text" name="Allergies" value="{{ old('Allergies', $patient->Allergies) }}">
                    </div>
                    <div class="form-group span-2">
                        <label>Medical Conditions</label>
                        <input type="text" name="MedicalConditions" value="{{ old('MedicalConditions', $patient->MedicalConditions) }}">
                    </div>
                </div>

                <div class="form-section-title">Next of Kin</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="nok_FullName" value="{{ old('nok_FullName', $patient->nextOfKin?->FullName) }}">
                    </div>
                    <div class="form-group">
                        <label>Relationship</label>
                        <input type="text" name="nok_Relationship" value="{{ old('nok_Relationship', $patient->nextOfKin?->Relationship) }}">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="nok_PhoneNumber" value="{{ old('nok_PhoneNumber', $patient->nextOfKin?->PhoneNumber) }}">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="nok_Address" value="{{ old('nok_Address', $patient->nextOfKin?->Address) }}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('editPatientModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
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

document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
    backdrop.addEventListener('click', e => {
        if (e.target === backdrop) closeModal(backdrop.id);
    });
});

function switchTab(name, btn) {
    // Deactivate all
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    // Activate selected
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}

// Auto-open correct tab from URL hash
const hash = window.location.hash.replace('#', '');
if (hash) {
    const btn = document.querySelector(`.tab-btn[onclick*="${hash}"]`);
    if (btn) switchTab(hash, btn);
}
</script>
@endpush
