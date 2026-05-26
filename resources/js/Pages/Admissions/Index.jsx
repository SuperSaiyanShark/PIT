import { Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { useState } from 'react';

export default function AdmissionsIndex({ admissions = [] }) {
    const [search, setSearch] = useState('');

    // Fixed naming keys to match backend snake_case properties
    const filtered = admissions.filter(a =>
        a.patient?.first_name?.toLowerCase().includes(search.toLowerCase()) ||
        a.patient?.last_name?.toLowerCase().includes(search.toLowerCase()) ||
        a.ward?.name?.toLowerCase().includes(search.toLowerCase())
    );

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this admission?')) {
            router.delete(route('admissions.destroy', id));
        }
    };

    // Fixed key to look for date_actual_leave
    const activeCount = admissions.filter(a => !a.date_actual_leave).length;
    const dischargedCount = admissions.filter(a => a.date_actual_leave).length;

    return (
        <AuthenticatedLayout>
            <Head title="Admissions" />

            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                {/* Header */}
                <div className="flex items-center justify-between mb-8">
                    <div>
                        <h1 className="text-3xl font-bold text-cyan-600">Admissions</h1>
                        <p className="text-gray-500 text-sm mt-1">Manage patient admissions and discharges</p>
                    </div>
                    <Link href={route('admissions.create')}>
                        <button className="bg-cyan-600 text-white px-5 py-2 rounded-lg hover:bg-cyan-700 transition font-semibold">
                            + New Admission
                        </button>
                    </Link>
                </div>

                {/* Stats */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div className="bg-white rounded-lg shadow p-5">
                        <p className="text-gray-500 text-sm">Total Admissions</p>
                        <p className="text-3xl font-bold text-cyan-600">{admissions.length}</p>
                    </div>
                    <div className="bg-white rounded-lg shadow p-5">
                        <p className="text-gray-500 text-sm">Currently Admitted</p>
                        <p className="text-3xl font-bold text-green-600">{activeCount}</p>
                    </div>
                    <div className="bg-white rounded-lg shadow p-5">
                        <p className="text-gray-500 text-sm">Discharged</p>
                        <p className="text-3xl font-bold text-gray-500">{dischargedCount}</p>
                    </div>
                </div>

                {/* Search */}
                <div className="mb-6">
                    <input
                        type="text"
                        placeholder="Search by patient name or ward..."
                        className="w-full max-w-md border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500"
                        value={search}
                        onChange={e => setSearch(e.target.value)}
                    />
                </div>

                {/* Table */}
                <div className="bg-white rounded-lg shadow overflow-hidden">
                    <table className="w-full text-sm">
                        <thead className="bg-cyan-600 text-white">
                            <tr>
                                <th className="text-left px-6 py-3">Patient</th>
                                <th className="text-left px-6 py-3">Bed</th>
                                <th className="text-left px-6 py-3">Ward</th>
                                <th className="text-left px-6 py-3">Admission Date</th>
                                <th className="text-left px-6 py-3">Discharge Date</th>
                                <th className="text-left px-6 py-3">Status</th>
                                <th className="text-left px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {filtered.length === 0 ? (
                                <tr>
                                    <td colSpan="7" className="text-center py-10 text-gray-400">
                                        No admissions found.
                                    </td>
                                </tr>
                            ) : (
                                filtered.map((admission, i) => (
                                    <tr key={admission.id} className={`border-t ${i % 2 === 0 ? 'bg-white' : 'bg-gray-50'} hover:bg-cyan-50 transition`}>
                                        <td className="px-6 py-4 font-medium text-gray-800">
                                            {admission.patient?.first_name} {admission.patient?.last_name}
                                        </td>
                                        <td className="px-6 py-4 text-gray-600">
                                            {admission.bed_number || '—'}
                                        </td>
                                        <td className="px-6 py-4 text-gray-600">
                                            {admission.ward?.name || '—'}
                                        </td>
                                        <td className="px-6 py-4 text-gray-600">
                                            {admission.date_admitted || '—'}
                                        </td>
                                        <td className="px-6 py-4 text-gray-600">
                                            {admission.date_actual_leave || '—'}
                                        </td>
                                        <td className="px-6 py-4">
                                            <span className={`px-2 py-1 rounded-full text-xs font-semibold ${
                                                !admission.date_actual_leave
                                                    ? 'bg-green-100 text-green-700'
                                                    : 'bg-gray-100 text-gray-500'
                                            }`}>
                                                {!admission.date_actual_leave ? 'Admitted' : 'Discharged'}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="flex gap-2">
                                                <Link href={route('admissions.edit', admission.id)}>
                                                    <button className="bg-cyan-100 text-cyan-700 px-3 py-1 rounded hover:bg-cyan-200 transition text-xs font-semibold">
                                                        Edit
                                                    </button>
                                                </Link>
                                                {!admission.date_actual_leave && (
                                                    <Link href={route('admissions.edit', admission.id)}>
                                                        <button className="bg-yellow-100 text-yellow-700 px-3 py-1 rounded hover:bg-yellow-200 transition text-xs font-semibold">
                                                            Discharge
                                                        </button>
                                                    </Link>
                                                )}
                                                <button
                                                    onClick={() => handleDelete(admission.id)}
                                                    className="bg-red-100 text-red-600 px-3 py-1 rounded hover:bg-red-200 transition text-xs font-semibold"
                                                >
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}