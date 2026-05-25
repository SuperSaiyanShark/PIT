import { useState } from 'react';
import { router, Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Modal from '@/Components/Modal';
import { Head } from '@inertiajs/react';

// ── Info Row ──────────────────────────────────────────────────
function InfoRow({ label, value }) {
    return (
        <div className="flex py-2.5 border-b border-gray-50 last:border-0">
            <span className="w-40 flex-shrink-0 text-xs font-semibold text-gray-400 uppercase tracking-wide">{label}</span>
            <span className="text-sm text-gray-800 font-medium">{value || '—'}</span>
        </div>
    );
}

// ── Alert Box ──────────────────────────────────────────────────
function AlertBox({ color, title, children }) {
    const colors = {
        red:  'bg-red-50 border-red-200',
        amber:'bg-amber-50 border-amber-200',
        blue: 'bg-blue-50 border-blue-200',
    };
    const titleColors = { red:'text-red-600', amber:'text-amber-700', blue:'text-blue-600' };
    return (
        <div className={`border rounded-xl p-4 mx-5 mb-4 ${colors[color]}`}>
            <p className={`text-xs font-bold uppercase tracking-wide mb-1 ${titleColors[color]}`}>{title}</p>
            <p className="text-sm text-gray-700">{children}</p>
        </div>
    );
}

export default function PatientShow({ patient, wards = [] }) {
    const [tab, setTab]           = useState('info');
    const [showModal, setShowModal] = useState(false);
    const [modalType, setModalType] = useState('');
    const [isLoading, setIsLoading] = useState(false);
    const [formData, setFormData]   = useState({});

    const activeAdmission = patient.admissions?.find(a => a.status === 'Admitted');

    const initials = (patient.first_name?.charAt(0) ?? '') + (patient.last_name?.charAt(0) ?? '');

    const openModal = (type, defaults = {}) => {
        setFormData(defaults);
        setModalType(type);
        setShowModal(true);
    };

    const set = (key) => (e) => setFormData(f => ({ ...f, [key]: e.target.value }));

    const submit = (routeName, data, params = []) => {
        setIsLoading(true);
        router.post(route(routeName, [patient.id, ...params]), data, {
            onSuccess: () => { setShowModal(false); setIsLoading(false); },
            onError:   ()  => { setIsLoading(false); },
        });
    };

    const handleEdit = (data, setErrors) => {
        setIsLoading(true);
        router.patch(route('patients.update', patient.id), data, {
            onSuccess: () => { setShowModal(false); setIsLoading(false); },
            onError:   (e) => { setErrors(e); setIsLoading(false); },
        });
    };

    const tabs = [
        { key: 'info',       label: 'Patient Info',         icon: '👤' },
        { key: 'records',    label: `Medical Records (${patient.medical_records?.length ?? 0})`, icon: '📄' },
        { key: 'admissions', label: 'Admission / Discharge', icon: '🏥' },
    ];

    return (
        <AuthenticatedLayout>
            <Head title={patient.full_name} />

            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">

                {/* Back link */}
                <Link href={route('patients.index')} className="inline-flex items-center gap-1.5 text-cyan-600 hover:text-cyan-800 text-sm font-medium mb-6">
                    <svg className="w-4 h-4" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
                        <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                    </svg>
                    Back to Patients
                </Link>

                {/* ── Hero ── */}
                <div className="rounded-2xl p-7 mb-6 text-white relative overflow-hidden"
                     style={{ background: 'linear-gradient(135deg, #0e6b77, #12a8bd)' }}>
                    {/* decorative circles */}
                    <div className="absolute -top-10 -right-10 w-48 h-48 rounded-full bg-white/10 pointer-events-none"/>
                    <div className="absolute -bottom-16 right-20 w-36 h-36 rounded-full bg-white/6 pointer-events-none"/>

                    <div className="flex items-center gap-6 relative z-10">
                        <div className="w-16 h-16 rounded-full bg-white/20 border-2 border-white/30 flex items-center justify-center text-2xl font-bold flex-shrink-0">
                            {initials.toUpperCase()}
                        </div>
                        <div className="flex-1">
                            <h1 className="text-2xl font-bold">{patient.full_name}</h1>
                            <p className="text-white/75 text-sm mt-0.5">
                                Patient ID: #{String(patient.id).padStart(6,'0')}
                                &nbsp;·&nbsp; {patient.sex === 'M' ? 'Male' : 'Female'}
                                &nbsp;·&nbsp; Age {patient.age}
                                {patient.blood_type && <>&nbsp;·&nbsp; {patient.blood_type}</>}
                            </p>
                            <div className="flex gap-2 mt-3 flex-wrap">
                                <span className={`text-xs font-semibold px-3 py-1 rounded-full ${
                                    patient.status === 'Admitted'
                                        ? 'bg-green-400/30'
                                        : 'bg-white/20'
                                }`}>
                                    {patient.status}
                                </span>
                                {activeAdmission && (
                                    <span className="text-xs font-semibold px-3 py-1 rounded-full bg-white/20">
                                        Bed {activeAdmission.bed_number} · {activeAdmission.ward_name}
                                    </span>
                                )}
                            </div>
                        </div>
                        <button
                            onClick={() => openModal('edit', {
                                first_name: patient.first_name, last_name: patient.last_name,
                                date_of_birth: patient.date_of_birth, sex: patient.sex,
                                marital_status: patient.marital_status, address: patient.address,
                                phone_number: patient.phone_number, email: patient.email,
                                blood_type: patient.blood_type, allergies: patient.allergies,
                                medical_conditions: patient.medical_conditions,
                                nok_full_name:    patient.next_of_kin?.full_name    ?? '',
                                nok_relationship: patient.next_of_kin?.relationship ?? '',
                                nok_address:      patient.next_of_kin?.address      ?? '',
                                nok_phone:        patient.next_of_kin?.phone_number ?? '',
                            })}
                            className="px-4 py-2 rounded-xl bg-white/15 hover:bg-white/25 text-white text-sm font-semibold transition border border-white/20 flex-shrink-0"
                        >
                            ✎ Edit
                        </button>
                    </div>
                </div>

                {/* ── Tabs ── */}
                <div className="flex gap-1 bg-white rounded-xl p-1.5 w-fit shadow mb-6">
                    {tabs.map(t => (
                        <button
                            key={t.key}
                            onClick={() => setTab(t.key)}
                            className={`flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition whitespace-nowrap ${
                                tab === t.key ? 'bg-cyan-500 text-white' : 'text-gray-500 hover:bg-cyan-50'
                            }`}
                        >
                            <span>{t.icon}</span> {t.label}
                        </button>
                    ))}
                </div>

                {/* ══ TAB: PATIENT INFO ══ */}
                {tab === 'info' && (
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {/* Personal details */}
                        <div className="bg-white rounded-2xl shadow overflow-hidden">
                            <div className="px-5 py-4 border-b border-gray-100 flex items-center gap-2">
                                <span className="text-cyan-500">👤</span>
                                <h3 className="text-xs font-bold uppercase tracking-widest text-gray-600">Personal Details</h3>
                            </div>
                            <div className="px-5 py-3">
                                <InfoRow label="Date of Birth" value={patient.date_of_birth} />
                                <InfoRow label="Gender"        value={patient.sex === 'M' ? 'Male' : 'Female'} />
                                <InfoRow label="Marital Status"value={patient.marital_status} />
                                <InfoRow label="Blood Type"    value={patient.blood_type} />
                                <InfoRow label="Phone"         value={patient.phone_number} />
                                <InfoRow label="Email"         value={patient.email} />
                                <InfoRow label="Address"       value={patient.address} />
                                <InfoRow label="Registered"    value={patient.date_registered} />
                            </div>
                            {patient.next_of_kin && (
                                <AlertBox color="red" title="⚠ Emergency Contact">
                                    <strong>{patient.next_of_kin.full_name}</strong>
                                    {patient.next_of_kin.relationship && ` — ${patient.next_of_kin.relationship}`}
                                    <br />{patient.next_of_kin.phone_number}
                                </AlertBox>
                            )}
                        </div>

                        {/* Medical summary */}
                        <div className="bg-white rounded-2xl shadow overflow-hidden">
                            <div className="px-5 py-4 border-b border-gray-100 flex items-center gap-2">
                                <span className="text-cyan-500">💊</span>
                                <h3 className="text-xs font-bold uppercase tracking-widest text-gray-600">Medical Summary</h3>
                            </div>
                            <div className="px-5 py-3">
                                <InfoRow label="Status"         value={patient.status} />
                                <InfoRow label="Total Records"  value={`${patient.medical_records?.length ?? 0} record(s)`} />
                                <InfoRow label="Total Admissions" value={`${patient.admissions?.length ?? 0} time(s)`} />
                            </div>
                            {patient.allergies && (
                                <AlertBox color="amber" title="Allergies">{patient.allergies}</AlertBox>
                            )}
                            {patient.medical_conditions && (
                                <AlertBox color="blue" title="Medical Conditions">{patient.medical_conditions}</AlertBox>
                            )}
                        </div>
                    </div>
                )}

                {/* ══ TAB: MEDICAL RECORDS ══ */}
                {tab === 'records' && (
                    <div>
                        <div className="flex justify-between items-center mb-4">
                            <h3 className="text-lg font-bold text-gray-800">Medical Records</h3>
                            <button
                                onClick={() => openModal('record', { record_date: new Date().toISOString().slice(0,10) })}
                                className="px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg text-sm font-semibold transition"
                            >
                                + Add Record
                            </button>
                        </div>
                        <div className="bg-white rounded-2xl shadow overflow-x-auto">
                            <table className="w-full">
                                <thead className="bg-cyan-600 text-white">
                                    <tr>
                                        {['Date','Diagnosis','Treatment','Notes'].map(h => (
                                            <th key={h} className="px-5 py-3 text-left text-sm font-semibold">{h}</th>
                                        ))}
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-100">
                                    {patient.medical_records?.length > 0 ? patient.medical_records.map(r => (
                                        <tr key={r.id} className="hover:bg-gray-50">
                                            <td className="px-5 py-3 text-sm text-gray-600">{r.record_date}</td>
                                            <td className="px-5 py-3 text-sm font-semibold text-gray-900">{r.diagnosis}</td>
                                            <td className="px-5 py-3 text-sm text-gray-600">{r.treatment || '—'}</td>
                                            <td className="px-5 py-3 text-sm text-gray-400">{r.notes || '—'}</td>
                                        </tr>
                                    )) : (
                                        <tr><td colSpan="4" className="px-5 py-12 text-center text-gray-400">No medical records yet.</td></tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}

                {/* ══ TAB: ADMISSIONS ══ */}
                {tab === 'admissions' && (
                    <div>
                        <div className="flex justify-between items-center mb-4">
                            <h3 className="text-lg font-bold text-gray-800">Admission / Discharge History</h3>
                            {activeAdmission ? (
                                <button
                                    onClick={() => openModal('discharge')}
                                    className="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-semibold transition"
                                >
                                    Discharge Patient
                                </button>
                            ) : (
                                <button
                                    onClick={() => openModal('admit', { date_admitted: new Date().toISOString().slice(0,10) })}
                                    className="px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg text-sm font-semibold transition"
                                >
                                    + Admit Patient
                                </button>
                            )}
                        </div>

                        {patient.admissions?.length > 0 ? patient.admissions.map(a => (
                            <div key={a.id} className="bg-white rounded-2xl shadow p-5 mb-4">
                                <div className="flex items-center justify-between mb-4">
                                    <div>
                                        <span className="font-bold text-gray-900">{a.ward_name ?? 'Unknown Ward'}</span>
                                        <span className="text-gray-400 text-sm ml-2">· Bed {a.bed_number}</span>
                                    </div>
                                    <span className={`text-xs font-semibold px-3 py-1 rounded-full ${
                                        a.status === 'Admitted'
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-gray-100 text-gray-500'
                                    }`}>{a.status}</span>
                                </div>
                                <div className="grid grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <p className="text-xs uppercase text-gray-400 font-semibold">Admitted</p>
                                        <p className="font-semibold mt-0.5">{a.date_admitted ?? '—'}</p>
                                    </div>
                                    <div>
                                        <p className="text-xs uppercase text-gray-400 font-semibold">Discharged</p>
                                        <p className="font-semibold mt-0.5">{a.date_actual_leave ?? '—'}</p>
                                    </div>
                                    <div>
                                        <p className="text-xs uppercase text-gray-400 font-semibold">Duration</p>
                                        <p className="font-semibold mt-0.5">
                                            {a.expected_stay_days ? `${a.expected_stay_days} day(s)` : '—'}
                                        </p>
                                    </div>
                                </div>
                                {a.discharge_notes && (
                                    <div className="mt-3 p-3 bg-gray-50 rounded-lg text-sm text-gray-600">
                                        <strong>Discharge notes:</strong> {a.discharge_notes}
                                    </div>
                                )}
                            </div>
                        )) : (
                            <div className="bg-white rounded-2xl shadow px-5 py-12 text-center text-gray-400">
                                No admissions recorded yet.
                            </div>
                        )}
                    </div>
                )}

                {/* ══ MODALS ══ */}
                <Modal show={showModal} onClose={() => setShowModal(false)}>
                    <div className="p-6">

                        {/* ADD MEDICAL RECORD */}
                        {modalType === 'record' && (
                            <>
                                <h2 className="text-xl font-bold text-gray-900 mb-5">Add Medical Record</h2>
                                <div className="space-y-3">
                                    {[
                                        { label: 'Diagnosis *', key: 'diagnosis' },
                                        { label: 'Treatment',   key: 'treatment' },
                                    ].map(f => (
                                        <div key={f.key}>
                                            <label className="block text-xs font-semibold text-gray-600 mb-1">{f.label}</label>
                                            <input type="text" value={formData[f.key] ?? ''} onChange={set(f.key)}
                                                className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400"/>
                                        </div>
                                    ))}
                                    <div>
                                        <label className="block text-xs font-semibold text-gray-600 mb-1">Record Date *</label>
                                        <input type="date" value={formData.record_date ?? ''} onChange={set('record_date')}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400"/>
                                    </div>
                                    <div>
                                        <label className="block text-xs font-semibold text-gray-600 mb-1">Notes</label>
                                        <textarea value={formData.notes ?? ''} onChange={set('notes')} rows={3}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400"/>
                                    </div>
                                    <div className="flex justify-end gap-2 pt-1">
                                        <button onClick={() => setShowModal(false)} className="px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">Cancel</button>
                                        <button onClick={() => submit('patients.medical-records.store', formData)} disabled={isLoading}
                                            className="px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg text-sm font-semibold transition disabled:opacity-50">
                                            {isLoading ? 'Saving…' : 'Save Record'}
                                        </button>
                                    </div>
                                </div>
                            </>
                        )}

                        {/* ADMIT PATIENT */}
                        {modalType === 'admit' && (
                            <>
                                <h2 className="text-xl font-bold text-gray-900 mb-5">Admit Patient</h2>
                                <div className="space-y-3">
                                    <div>
                                        <label className="block text-xs font-semibold text-gray-600 mb-1">Ward *</label>
                                        <select value={formData.ward_id ?? ''} onChange={set('ward_id')}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                            <option value="">Select a ward</option>
                                            {wards.map(w => <option key={w.id} value={w.id}>{w.name}</option>)}
                                        </select>
                                    </div>
                                    <div>
                                        <label className="block text-xs font-semibold text-gray-600 mb-1">Bed Number *</label>
                                        <input type="text" placeholder="e.g. A-101" value={formData.bed_number ?? ''} onChange={set('bed_number')}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400"/>
                                    </div>
                                    <div>
                                        <label className="block text-xs font-semibold text-gray-600 mb-1">Admission Date *</label>
                                        <input type="date" value={formData.date_admitted ?? ''} onChange={set('date_admitted')}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400"/>
                                    </div>
                                    <div className="flex justify-end gap-2 pt-1">
                                        <button onClick={() => setShowModal(false)} className="px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">Cancel</button>
                                        <button onClick={() => submit('patients.admit', formData)} disabled={isLoading}
                                            className="px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg text-sm font-semibold transition disabled:opacity-50">
                                            {isLoading ? 'Admitting…' : 'Confirm Admission'}
                                        </button>
                                    </div>
                                </div>
                            </>
                        )}

                        {/* DISCHARGE PATIENT */}
                        {modalType === 'discharge' && (
                            <>
                                <h2 className="text-xl font-bold text-gray-900 mb-2">Discharge Patient</h2>
                                <p className="text-sm text-gray-500 mb-5">This will mark {patient.full_name} as discharged as of today.</p>
                                <div className="space-y-3">
                                    <div>
                                        <label className="block text-xs font-semibold text-gray-600 mb-1">Discharge Notes</label>
                                        <textarea value={formData.discharge_notes ?? ''} onChange={set('discharge_notes')} rows={3}
                                            placeholder="Recovery instructions, follow-up…"
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400"/>
                                    </div>
                                    <div className="flex justify-end gap-2 pt-1">
                                        <button onClick={() => setShowModal(false)} className="px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">Cancel</button>
                                        <button onClick={() => submit('patients.discharge', formData)} disabled={isLoading}
                                            className="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-semibold transition disabled:opacity-50">
                                            {isLoading ? 'Discharging…' : 'Discharge Patient'}
                                        </button>
                                    </div>
                                </div>
                            </>
                        )}

                        {/* EDIT PATIENT (reuse PatientForm inline) */}
                        {modalType === 'edit' && (
                            <>
                                <h2 className="text-xl font-bold text-gray-900 mb-5">Edit — {patient.full_name}</h2>
                                <EditPatientForm data={formData} setData={setFormData} onSubmit={handleEdit} isLoading={isLoading} onCancel={() => setShowModal(false)} />
                            </>
                        )}

                    </div>
                </Modal>

            </div>
        </AuthenticatedLayout>
    );
}

// Inline edit form (same fields as Index PatientForm)
function EditPatientForm({ data, setData, onSubmit, isLoading, onCancel }) {
    const [errors, setErrors] = useState({});
    const set = (key) => (e) => setData(f => ({ ...f, [key]: e.target.value }));

    const f = (label, key, type = 'text', req = false) => (
        <div>
            <label className="block text-xs font-semibold text-gray-600 mb-1">{label}{req && <span className="text-red-500 ml-0.5">*</span>}</label>
            <input type={type} value={data[key] ?? ''} onChange={set(key)}
                className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400"/>
            {errors[key] && <p className="text-red-500 text-xs mt-1">{errors[key]}</p>}
        </div>
    );

    return (
        <div className="space-y-4">
            <p className="text-xs font-bold uppercase tracking-widest text-cyan-600 border-b-2 border-cyan-100 pb-1">Personal Information</p>
            <div className="grid grid-cols-2 gap-3">
                {f('First Name','first_name','text',true)}
                {f('Last Name', 'last_name', 'text',true)}
                {f('Date of Birth','date_of_birth','date',true)}
                <div>
                    <label className="block text-xs font-semibold text-gray-600 mb-1">Gender *</label>
                    <select value={data.sex ?? ''} onChange={set('sex')} className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                        <option value="">Select</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>
                <div>
                    <label className="block text-xs font-semibold text-gray-600 mb-1">Marital Status</label>
                    <select value={data.marital_status ?? ''} onChange={set('marital_status')} className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                        <option value="">Select</option>
                        {['Single','Married','Widowed','Separated'].map(s=><option key={s} value={s}>{s}</option>)}
                    </select>
                </div>
                <div>
                    <label className="block text-xs font-semibold text-gray-600 mb-1">Blood Type</label>
                    <select value={data.blood_type ?? ''} onChange={set('blood_type')} className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                        <option value="">Unknown</option>
                        {['A+','A-','B+','B-','AB+','AB-','O+','O-'].map(b=><option key={b} value={b}>{b}</option>)}
                    </select>
                </div>
                {f('Phone','phone_number')}
                {f('Email','email','email')}
                <div className="col-span-2">{f('Address','address')}</div>
                <div className="col-span-2">{f('Allergies','allergies')}</div>
                <div className="col-span-2">{f('Medical Conditions','medical_conditions')}</div>
            </div>
            <p className="text-xs font-bold uppercase tracking-widest text-cyan-600 border-b-2 border-cyan-100 pb-1 mt-2">Next of Kin</p>
            <div className="grid grid-cols-2 gap-3">
                {f('Full Name','nok_full_name')}
                {f('Relationship','nok_relationship')}
                {f('Phone','nok_phone')}
                {f('Address','nok_address')}
            </div>
            <div className="flex justify-end gap-2 pt-2">
                <button type="button" onClick={onCancel} className="px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">Cancel</button>
                <button type="button" onClick={() => onSubmit(data, setErrors)} disabled={isLoading}
                    className="px-5 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg text-sm font-semibold transition disabled:opacity-50">
                    {isLoading ? 'Saving…' : 'Save Changes'}
                </button>
            </div>
        </div>
    );
}
