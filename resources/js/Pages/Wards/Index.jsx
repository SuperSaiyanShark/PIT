import { Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { useState } from 'react';

export default function WardsIndex({ wards = [] }) {
    const [search, setSearch] = useState('');

    const filtered = wards.filter(w =>
        w.name.toLowerCase().includes(search.toLowerCase()) ||
        w.department?.name?.toLowerCase().includes(search.toLowerCase())
    );

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this ward?')) {
            router.delete(route('wards.destroy', id));
        }
    };

    return (
        <AuthenticatedLayout>
            <Head title="Wards" />

            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                <div className="flex items-center justify-between mb-8">
                    <div>
                        <h1 className="text-3xl font-bold text-cyan-600">Wards</h1>
                        <p className="text-gray-500 text-sm mt-1">Manage hospital wards and their capacity</p>
                    </div>
                    <Link href={route('wards.create')}>
                        <button className="bg-cyan-600 text-white px-5 py-2 rounded-lg hover:bg-cyan-700 transition font-semibold">
                            + Add New Ward
                        </button>
                    </Link>
                </div>

                <div className="mb-6">
                    <input
                        type="text"
                        placeholder="Search by ward name or department..."
                        className="w-full max-w-md border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500"
                        value={search}
                        onChange={e => setSearch(e.target.value)}
                    />
                </div>

                <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div className="bg-white rounded-lg shadow p-5">
                        <p className="text-gray-500 text-sm">Total Wards</p>
                        <p className="text-3xl font-bold text-cyan-600">{wards.length}</p>
                    </div>
                    <div className="bg-white rounded-lg shadow p-5">
                        <p className="text-gray-500 text-sm">Total Capacity</p>
                        <p className="text-3xl font-bold text-cyan-600">
                            {wards.reduce((sum, w) => sum + (w.capacity || 0), 0)}
                        </p>
                    </div>
                    <div className="bg-white rounded-lg shadow p-5">
                        <p className="text-gray-500 text-sm">Total Staff Assigned</p>
                        <p className="text-3xl font-bold text-cyan-600">
                            {wards.reduce((sum, w) => sum + (w.staff?.length || 0), 0)}
                        </p>
                    </div>
                </div>

                <div className="bg-white rounded-lg shadow overflow-hidden">
                    <table className="w-full text-sm">
                        <thead className="bg-cyan-600 text-white">
                            <tr>
                                <th className="text-left px-6 py-3">Ward Name</th>
                                <th className="text-left px-6 py-3">Department</th>
                                <th className="text-left px-6 py-3">Floor</th>
                                <th className="text-left px-6 py-3">Capacity</th>
                                <th className="text-left px-6 py-3">Max Staff</th>
                                <th className="text-left px-6 py-3">Ward Head</th>
                                <th className="text-left px-6 py-3">Staff Count</th>
                                <th className="text-left px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {filtered.length === 0 ? (
                                <tr>
                                    <td colSpan="8" className="text-center py-10 text-gray-400">No wards found.</td>
                                </tr>
                            ) : (
                                filtered.map((ward, i) => {
                                    const maxStaff = Math.max(3, Math.min(10, Math.floor((ward.capacity || 0) / 2)));
                                    const staffCount = ward.staff?.length || 0;
                                    const isFull = staffCount >= maxStaff;
                                    return (
                                        <tr key={ward.id} className={`border-t ${i % 2 === 0 ? 'bg-white' : 'bg-gray-50'} hover:bg-cyan-50 transition`}>
                                            <td className="px-6 py-4 font-medium text-gray-800">{ward.name}</td>
                                            <td className="px-6 py-4 text-gray-600">{ward.department?.name || '—'}</td>
                                            <td className="px-6 py-4 text-gray-600">{ward.floor ?? '—'}</td>
                                            <td className="px-6 py-4 text-gray-600">{ward.capacity ?? '—'}</td>
                                            <td className="px-6 py-4 text-gray-600">{maxStaff}</td>
                                            <td className="px-6 py-4 text-gray-600">{ward.head?.name || '—'}</td>
                                            <td className="px-6 py-4">
                                                <span className={`px-2 py-1 rounded-full text-xs font-semibold ${isFull ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'}`}>
                                                    {staffCount} / {maxStaff} {isFull ? '(Full)' : ''}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4">
                                                <div className="flex gap-2">
                                                    <Link href={route('wards.edit', ward.id)}>
                                                        <button className="bg-cyan-100 text-cyan-700 px-3 py-1 rounded hover:bg-cyan-200 transition text-xs font-semibold">Edit</button>
                                                    </Link>
                                                    <button
                                                        onClick={() => handleDelete(ward.id)}
                                                        className="bg-red-100 text-red-600 px-3 py-1 rounded hover:bg-red-200 transition text-xs font-semibold"
                                                    >
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    );
                                })
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}