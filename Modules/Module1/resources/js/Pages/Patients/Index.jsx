import { useState, useMemo } from 'react';
import { router, Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Modal from '@/Components/Modal';
import { Head } from '@inertiajs/react';

// ── Stat Card ─────────────────────────────────────────────────
function StatCard({ icon, value, label, color }) {
    return (
        <div className={`rounded-2xl p-5 flex items-center gap-4 text-white shadow-md hover:-translate-y-1 transition-transform duration-200 ${color}`}>
            <div className="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                {icon}
            </div>
            <div>
                <div className="text-3xl font-extrabold leading-none">{value}</div>
                <div className="text-sm text-white/80 mt-1 font-medium">{label}</div>
            </div>
        </div>
    );
}

// ── Patient Card (mirrors StaffCard style) ───────────────────
function PatientCard({ patient, onView, onEdit }) {
    const initials = (patient.first_name?.charAt(0) ?? '') + (patient.last_name?.charAt(0) ?? '');
    return (
        <div className="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow relative">
            {/* Action buttons */}
            <div className="absolute top-2 right-2 flex gap-1">
                <button
                    onClick={() => onView(patient)}
                    className="bg-cyan-500 hover:bg-cyan-600 text-white p-1.5 rounded-lg transition text-xs"
                    title="View"
                >
                    <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
                        <path strokeLinecap="round" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
                <button
                    onClick={() => onEdit(patient)}
                    className="bg-gray-200 hover:bg-gray-300 text-gray-700 p-1.5 rounded-lg transition text-xs"
                    title="Edit"
                >
                    <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
                        <path strokeLinecap="round" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path strokeLinecap="round" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </button>
            </div>

            <div className="flex flex-col items-center">
                {/* Avatar */}
                <div className="w-20 h-20 mb-3 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold text-2xl">
                    {initials.toUpperCase()}
                </div>

                {/* Name */}
                <h3 className="text-base font-semibold text-gray-800 text-center">{patient.full_name}</h3>

                {/* Small teal divider (matches StaffCard style) */}
                <div className="w-8 h-0.5 bg-cyan-500 rounded my-2"></div>

                {/* Status badge */}
                <span className={`inline-block text-xs font-semibold px-3 py-1 rounded-full mb-3 ${
                    patient.status === 'Admitted'
                        ? 'bg-green-100 text-green-700'
                        : 'bg-amber-100 text-amber-700'
                }`}>
                    {patient.status}
                </span>

                {/* Details */}
                <div className="flex items-center text-gray-600 mb-1.5 w-full justify-center gap-1.5">
                    <svg className="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fillRule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clipRule="evenodd"/>
                    </svg>
                    <span className="text-xs">{patient.age} yrs · {patient.sex === 'M' ? 'Male' : 'Female'}</span>
                </div>

                {patient.phone_number && (
                    <div className="flex items-center text-gray-600 mb-1.5 w-full justify-center gap-1.5">
                        <svg className="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.418 1.02 1.004 1.989 1.839 2.823.835.835 1.803 1.421 2.823 1.839l.773-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2.57C6.75 18 1 12.25 1 5.43V3z"/>
                        </svg>
                        <span className="text-xs">{patient.phone_number}</span>
                    </div>
                )}

                {patient.ward_name && (
                    <div className="flex items-center text-gray-600 w-full justify-center gap-1.5">
                        <svg className="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fillRule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clipRule="evenodd"/>
                        </svg>
                        <span className="text-xs">{patient.ward_name} · Bed {patient.bed_number}</span>
                    </div>
                )}
            </div>
        </div>
    );
}

// ── Patient Form (register / edit) ───────────────────────────
function PatientForm({ patient = null, onSubmit, isLoading }) {
    const [form, setForm] = useState({
        first_name:         patient?.first_name        ?? '',
        last_name:          patient?.last_name         ?? '',
        date_of_birth:      patient?.date_of_birth     ?? '',
        sex:                patient?.sex               ?? '',
        marital_status:     patient?.marital_status    ?? '',
        address:            patient?.address           ?? '',
        phone_number:       patient?.phone_number      ?? '',
        email:              patient?.email             ?? '',
        blood_type:         patient?.blood_type        ?? '',
        allergies:          patient?.allergies         ?? '',
        medical_conditions: patient?.medical_conditions ?? '',
        nok_full_name:      patient?.next_of_kin?.full_name    ?? '',
        nok_relationship:   patient?.next_of_kin?.relationship ?? '',
        nok_address:        patient?.next_of_kin?.address      ?? '',
        nok_phone:          patient?.next_of_kin?.phone_number ?? '',
    });
    const [errors, setErrors] = useState({});

    const set = (key) => (e) => setForm(f => ({ ...f, [key]: e.target.value }));

    const handle = (e) => {
        e.preventDefault();
        onSubmit(form, setErrors);
    };

    const field = (label, key, type = 'text', required = false) => (
        <div>
            <label className="block text-xs font-semibold text-gray-600 mb-1">
                {label}{required && <span className="text-red-500 ml-0.5">*</span>}
            </label>
            <input
                type={type}
                value={form[key]}
                onChange={set(key)}
                className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400"
            />
            {errors[key] && <p className="text-red-500 text-xs mt-1">{errors[key]}</p>}
        </div>
    );

    return (
        <form onSubmit={handle} className="space-y-4">
            <div className="text-xs font-bold uppercase tracking-widest text-cyan-600 border-b-2 border-cyan-100 pb-1">
                Personal Information
            </div>
            <div className="grid grid-cols-2 gap-3">
                {field('First Name', 'first_name', 'text', true)}
                {field('Last Name',  'last_name',  'text', true)}
                {field('Date of Birth', 'date_of_birth', 'date', true)}
                <div>
                    <label className="block text-xs font-semibold text-gray-600 mb-1">Gender <span className="text-red-500">*</span></label>
                    <select value={form.sex} onChange={set('sex')} className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                        <option value="">Select</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>
                <div>
                    <label className="block text-xs font-semibold text-gray-600 mb-1">Marital Status</label>
                    <select value={form.marital_status} onChange={set('marital_status')} className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                        <option value="">Select</option>
                        {['Single','Married','Widowed','Separated'].map(s => <option key={s} value={s}>{s}</option>)}
                    </select>
                </div>
                <div>
                    <label className="block text-xs font-semibold text-gray-600 mb-1">Blood Type</label>
                    <select value={form.blood_type} onChange={set('blood_type')} className="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                        <option value="">Unknown</option>
                        {['A+','A-','B+','B-','AB+','AB-','O+','O-'].map(b => <option key={b} value={b}>{b}</option>)}
                    </select>
                </div>
                {field('Phone Number', 'phone_number')}
                {field('Email', 'email', 'email')}
                <div className="col-span-2">{field('Address', 'address')}</div>
                <div className="col-span-2">{field('Allergies', 'allergies')}</div>
                <div className="col-span-2">{field('Medical Conditions', 'medical_conditions')}</div>
            </div>

            <div className="text-xs font-bold uppercase tracking-widest text-cyan-600 border-b-2 border-cyan-100 pb-1 mt-2">
                Next of Kin / Emergency Contact
            </div>
            <div className="grid grid-cols-2 gap-3">
                {field('Full Name',    'nok_full_name')}
                {field('Relationship', 'nok_relationship')}
                {field('Phone',        'nok_phone')}
                {field('Address',      'nok_address')}
            </div>

            <div className="flex justify-end gap-2 pt-2">
                <button
                    type="submit"
                    disabled={isLoading}
                    className="px-5 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg text-sm font-semibold transition disabled:opacity-50"
                >
                    {isLoading ? 'Saving…' : patient ? 'Save Changes' : 'Register Patient'}
                </button>
            </div>
        </form>
    );
}

// ── Main Page ────────────────────────────────────────────────
export default function PatientsIndex({ patients = [], stats = {}, wards = [], filters = {} }) {
    const [search, setSearch]           = useState(filters.search ?? '');
    const [view, setView]               = useState('grid');
    const [showModal, setShowModal]     = useState(false);
    const [modalType, setModalType]     = useState('');  // create | edit
    const [selected, setSelected]       = useState(null);
    const [isLoading, setIsLoading]     = useState(false);

    const filtered = useMemo(() => {
        const q = search.toLowerCase();
        return patients.filter(p =>
            p.full_name.toLowerCase().includes(q) ||
            (p.phone_number ?? '').includes(q) ||
            String(p.id).includes(q)
        );
    }, [search, patients]);

    const openCreate = () => { setSelected(null); setModalType('create'); setShowModal(true); };
    const openEdit   = (p) => { setSelected(p);    setModalType('edit');   setShowModal(true); };
    const openView   = (p) => { router.visit(route('patients.show', p.id)); };

    const handleSubmit = (formData, setErrors) => {
        setIsLoading(true);
        const url    = selected ? route('patients.update', selected.id) : route('patients.store');
        const method = selected ? 'patch' : 'post';
        router[method](url, formData, {
            onSuccess: () => { setShowModal(false); setIsLoading(false); },
            onError:   (e) => { setErrors(e); setIsLoading(false); },
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title="Patient Management" />

            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">

                {/* ── Header ── */}
                <div className="mb-8">
                    <div className="flex justify-between items-start">
                        <div>
                            <h1 className="text-4xl font-bold text-cyan-600">WELLMEADOW HOSPITAL</h1>
                            <p className="text-cyan-700 font-semibold">PATIENT MANAGEMENT</p>
                            <p className="text-sm text-cyan-600">"Register and Manage Hospital Patients"</p>
                        </div>
                        <button
                            onClick={openCreate}
                            className="px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg font-semibold transition text-sm"
                        >
                            + New Patient
                        </button>
                    </div>
                </div>

                {/* ── Stat Cards ── */}
                <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <StatCard
                        color="bg-gradient-to-br from-cyan-600 to-cyan-400"
                        value={stats.total ?? 0}
                        label="Total Patients"
                        icon={<svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path strokeLinecap="round" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path strokeLinecap="round" d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>}
                    />
                    <StatCard
                        color="bg-gradient-to-br from-blue-600 to-blue-400"
                        value={stats.admitted ?? 0}
                        label="Currently Admitted"
                        icon={<svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path strokeLinecap="round" d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>}
                    />
                    <StatCard
                        color="bg-gradient-to-br from-cyan-500 to-teal-400"
                        value={stats.discharged_today ?? 0}
                        label="Discharged Today"
                        icon={<svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>}
                    />
                    <StatCard
                        color="bg-gradient-to-br from-sky-600 to-sky-400"
                        value={stats.beds_available ?? 0}
                        label="Beds Available"
                        icon={<svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/></svg>}
                    />
                </div>

                {/* ── Search + Filter bar ── */}
                <div className="bg-white rounded-lg shadow-md p-6 mb-8">
                    <div className="flex flex-col md:flex-row gap-4 items-end mb-4">
                        <div className="flex-1">
                            <label className="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input
                                type="text"
                                placeholder="Search by name, ID or phone…"
                                value={search}
                                onChange={e => setSearch(e.target.value)}
                                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                            />
                        </div>
                        <div className="flex gap-2">
                            <button
                                onClick={() => setView('grid')}
                                className={`px-3 py-2 rounded-lg transition ${view === 'grid' ? 'bg-cyan-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`}
                            >
                                <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/>
                                    <path d="M3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z"/>
                                    <path d="M14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                            </button>
                            <button
                                onClick={() => setView('list')}
                                className={`px-3 py-2 rounded-lg transition ${view === 'list' ? 'bg-cyan-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`}
                            >
                                <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fillRule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clipRule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <p className="text-gray-700 text-sm">
                        Showing Result <strong className="text-cyan-600">{filtered.length}</strong> of <strong>{patients.length}</strong>
                    </p>
                </div>

                {/* ── Patient Display ── */}
                {filtered.length > 0 ? (
                    view === 'grid' ? (
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            {filtered.map(p => (
                                <PatientCard key={p.id} patient={p} onView={openView} onEdit={openEdit} />
                            ))}
                        </div>
                    ) : (
                        <div className="bg-white rounded-lg shadow-md overflow-x-auto">
                            <table className="w-full">
                                <thead className="bg-cyan-600 text-white">
                                    <tr>
                                        {['Patient ID','Name','Age','Sex','Phone','Status','Ward / Bed','Registered','Actions'].map(h => (
                                            <th key={h} className="px-5 py-3 text-left text-sm font-semibold">{h}</th>
                                        ))}
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-100">
                                    {filtered.map(p => (
                                        <tr key={p.id} className="hover:bg-gray-50">
                                            <td className="px-5 py-3 text-sm font-mono text-cyan-600 font-bold">#{String(p.id).padStart(6,'0')}</td>
                                            <td className="px-5 py-3 text-sm font-semibold text-gray-900">{p.full_name}</td>
                                            <td className="px-5 py-3 text-sm text-gray-600">{p.age}</td>
                                            <td className="px-5 py-3 text-sm text-gray-600">{p.sex === 'M' ? 'Male' : 'Female'}</td>
                                            <td className="px-5 py-3 text-sm text-gray-600">{p.phone_number ?? '—'}</td>
                                            <td className="px-5 py-3">
                                                <span className={`inline-block text-xs font-semibold px-2.5 py-1 rounded-full ${p.status === 'Admitted' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'}`}>
                                                    {p.status}
                                                </span>
                                            </td>
                                            <td className="px-5 py-3 text-sm text-gray-500">
                                                {p.ward_name ? `${p.ward_name} · Bed ${p.bed_number}` : '—'}
                                            </td>
                                            <td className="px-5 py-3 text-sm text-gray-500">{p.date_registered}</td>
                                            <td className="px-5 py-3 text-sm flex gap-2">
                                                <button onClick={() => openView(p)} className="text-cyan-600 hover:text-cyan-900 font-medium">View</button>
                                                <button onClick={() => openEdit(p)} className="text-gray-500 hover:text-gray-800 font-medium">Edit</button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    )
                ) : (
                    <div className="text-center py-12 bg-white rounded-lg shadow-md">
                        <p className="text-gray-600 text-lg">No patients found matching your search.</p>
                    </div>
                )}

                {/* ── Modal ── */}
                <Modal show={showModal} onClose={() => setShowModal(false)}>
                    <div className="p-6">
                        <h2 className="text-xl font-bold text-gray-900 mb-5">
                            {modalType === 'create' ? 'New Patient Registration' : `Edit — ${selected?.full_name}`}
                        </h2>
                        <PatientForm
                            patient={selected}
                            onSubmit={handleSubmit}
                            isLoading={isLoading}
                        />
                    </div>
                </Modal>

            </div>
        </AuthenticatedLayout>
    );
}
