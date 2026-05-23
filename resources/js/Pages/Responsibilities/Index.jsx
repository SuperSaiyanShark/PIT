import { useState, useMemo } from 'react';
import { Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import { Head } from '@inertiajs/react';

export default function ResponsibilitiesIndex({ responsibilities = [] }) {
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedStatus, setSelectedStatus] = useState('');
    const [selectedStaff, setSelectedStaff] = useState('');
    const [view, setView] = useState('table'); // table or timeline

    const uniqueStaff = [...new Set(responsibilities.map(r => r.staff?.name).filter(Boolean))];
    const statuses = ['active', 'inactive', 'pending', 'completed', 'on-hold'];

    const getStatusColor = (status) => {
        const colors = {
            'active': 'bg-green-100 text-green-800',
            'completed': 'bg-blue-100 text-blue-800',
            'pending': 'bg-yellow-100 text-yellow-800',
            'on-hold': 'bg-orange-100 text-orange-800',
            'inactive': 'bg-gray-100 text-gray-800',
        };
        return colors[status] || 'bg-gray-100 text-gray-800';
    };

    const filteredResponsibilities = useMemo(() => {
        return responsibilities.filter(responsibility => {
            const matchesSearch = 
                responsibility.staff?.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                responsibility.description.toLowerCase().includes(searchTerm.toLowerCase()) ||
                responsibility.responsibility_type?.toLowerCase().includes(searchTerm.toLowerCase());
            
            const matchesStatus = selectedStatus === '' || responsibility.status === selectedStatus;
            const matchesStaff = selectedStaff === '' || responsibility.staff?.name === selectedStaff;
            
            return matchesSearch && matchesStatus && matchesStaff;
        });
    }, [searchTerm, selectedStatus, selectedStaff, responsibilities]);

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this responsibility?')) {
            router.delete(route('responsibilities.destroy', id), {
                onSuccess: () => {
                    // Success handled by Laravel redirect
                }
            });
        }
    };

    return (
        <AuthenticatedLayout>
            <Head title="Staff Responsibilities Tracking" />

            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                {/* Header */}
                <div className="mb-8">
                    <div className="flex justify-between items-start">
                        <div>
                            <h1 className="text-4xl font-bold text-cyan-600">STAFF RESPONSIBILITIES</h1>
                            <p className="text-cyan-700 font-semibold">Patient Care Assignment Tracking</p>
                            <p className="text-sm text-cyan-600">"Monitor and manage staff duties and patient care assignments"</p>
                        </div>
                        <Link href={route('responsibilities.create')}>
                            <PrimaryButton>+ Assign New Responsibility</PrimaryButton>
                        </Link>
                    </div>
                </div>

                {/* Filters */}
                <div className="bg-white rounded-lg shadow-md p-6 mb-8">
                    <div className="flex flex-col md:flex-row gap-4 items-end mb-6">
                        {/* Search */}
                        <div className="flex-1 min-w-0">
                            <label className="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <input
                                type="text"
                                placeholder="Search by staff name, description, or type..."
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                            />
                        </div>

                        {/* Staff Filter */}
                        <div className="flex items-center gap-2">
                            <label htmlFor="staff" className="text-sm font-medium text-gray-700">Staff:</label>
                            <select
                                id="staff"
                                value={selectedStaff}
                                onChange={(e) => setSelectedStaff(e.target.value)}
                                className="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 bg-white"
                            >
                                <option value="">ALL STAFF</option>
                                {uniqueStaff.map(name => (
                                    <option key={name} value={name}>{name}</option>
                                ))}
                            </select>
                        </div>

                        {/* Status Filter */}
                        <div className="flex items-center gap-2">
                            <label htmlFor="status" className="text-sm font-medium text-gray-700">Status:</label>
                            <select
                                id="status"
                                value={selectedStatus}
                                onChange={(e) => setSelectedStatus(e.target.value)}
                                className="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 bg-white"
                            >
                                <option value="">ALL STATUSES</option>
                                {statuses.map(status => (
                                    <option key={status} value={status}>
                                        {status.charAt(0).toUpperCase() + status.slice(1)}
                                    </option>
                                ))}
                            </select>
                        </div>

                        {/* View Toggle */}
                        <div className="flex gap-2">
                            <button
                                onClick={() => setView('table')}
                                className={`px-3 py-2 rounded-lg transition ${view === 'table' ? 'bg-cyan-500 text-white' : 'bg-gray-200 text-gray-700'}`}
                                title="Table View"
                            >
                                📋
                            </button>
                            <button
                                onClick={() => setView('timeline')}
                                className={`px-3 py-2 rounded-lg transition ${view === 'timeline' ? 'bg-cyan-500 text-white' : 'bg-gray-200 text-gray-700'}`}
                                title="Timeline View"
                            >
                                📅
                            </button>
                        </div>
                    </div>

                    {/* Results Summary */}
                    <div className="text-gray-700">
                        <p>Showing <span className="font-semibold text-cyan-600">{filteredResponsibilities.length}</span> of <span className="font-semibold">{responsibilities.length}</span> responsibilities</p>
                    </div>
                </div>

                {/* Content */}
                {filteredResponsibilities.length > 0 ? (
                    view === 'table' ? (
                        <div className="bg-white rounded-lg shadow-md overflow-x-auto">
                            <table className="w-full">
                                <thead className="bg-cyan-600 text-white">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-sm font-semibold">Staff Member</th>
                                        <th className="px-6 py-3 text-left text-sm font-semibold">Responsibility Type</th>
                                        <th className="px-6 py-3 text-left text-sm font-semibold">Description</th>
                                        <th className="px-6 py-3 text-left text-sm font-semibold">Department</th>
                                        <th className="px-6 py-3 text-left text-sm font-semibold">Ward</th>
                                        <th className="px-6 py-3 text-left text-sm font-semibold">Dates</th>
                                        <th className="px-6 py-3 text-left text-sm font-semibold">Status</th>
                                        <th className="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200">
                                    {filteredResponsibilities.map(responsibility => (
                                        <tr key={responsibility.id} className="hover:bg-gray-50 transition">
                                            <td className="px-6 py-4 text-sm font-medium text-gray-900">
                                                {responsibility.staff?.name || 'N/A'}
                                            </td>
                                            <td className="px-6 py-4 text-sm text-gray-700">
                                                {responsibility.responsibility_type}
                                            </td>
                                            <td className="px-6 py-4 text-sm text-gray-600">
                                                <div className="max-w-xs truncate" title={responsibility.description}>
                                                    {responsibility.description}
                                                </div>
                                            </td>
                                            <td className="px-6 py-4 text-sm text-gray-700">
                                                {responsibility.department?.name || '-'}
                                            </td>
                                            <td className="px-6 py-4 text-sm text-gray-700">
                                                {responsibility.ward?.name || '-'}
                                            </td>
                                            <td className="px-6 py-4 text-sm text-gray-700">
                                                {responsibility.start_date && (
                                                    <div>
                                                        <span>{responsibility.start_date}</span>
                                                        {responsibility.end_date && (
                                                            <span> → {responsibility.end_date}</span>
                                                        )}
                                                    </div>
                                                )}
                                            </td>
                                            <td className="px-6 py-4 text-sm">
                                                <span className={`px-3 py-1 rounded-full text-xs font-semibold ${getStatusColor(responsibility.status)}`}>
                                                    {responsibility.status}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4 text-sm">
                                                <div className="flex gap-2">
                                                    <Link href={route('responsibilities.edit', responsibility.id)}>
                                                        <button className="bg-cyan-500 hover:bg-cyan-600 text-white px-3 py-1 rounded transition text-xs">
                                                            Edit
                                                        </button>
                                                    </Link>
                                                    <button
                                                        onClick={() => handleDelete(responsibility.id)}
                                                        className="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition text-xs"
                                                    >
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    ) : (
                        <div className="space-y-4">
                            {filteredResponsibilities.map(responsibility => (
                                <div key={responsibility.id} className="bg-white rounded-lg shadow-md p-6 border-l-4 border-cyan-500">
                                    <div className="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 className="text-lg font-semibold text-gray-900">
                                                {responsibility.staff?.name}
                                            </h3>
                                            <p className="text-sm text-gray-600">
                                                {responsibility.responsibility_type}
                                            </p>
                                        </div>
                                        <span className={`px-3 py-1 rounded-full text-xs font-semibold ${getStatusColor(responsibility.status)}`}>
                                            {responsibility.status}
                                        </span>
                                    </div>

                                    <p className="text-gray-700 mb-3">{responsibility.description}</p>

                                    <div className="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4 text-sm">
                                        <div>
                                            <span className="font-semibold text-gray-700">Department:</span>
                                            <p className="text-gray-600">{responsibility.department?.name || '-'}</p>
                                        </div>
                                        <div>
                                            <span className="font-semibold text-gray-700">Ward:</span>
                                            <p className="text-gray-600">{responsibility.ward?.name || '-'}</p>
                                        </div>
                                        <div>
                                            <span className="font-semibold text-gray-700">Start Date:</span>
                                            <p className="text-gray-600">{responsibility.start_date || '-'}</p>
                                        </div>
                                        <div>
                                            <span className="font-semibold text-gray-700">End Date:</span>
                                            <p className="text-gray-600">{responsibility.end_date || '-'}</p>
                                        </div>
                                    </div>

                                    <div className="flex gap-2 justify-end">
                                        <Link href={route('responsibilities.edit', responsibility.id)}>
                                            <button className="bg-cyan-500 hover:bg-cyan-600 text-white px-3 py-1 rounded transition text-sm">
                                                Edit
                                            </button>
                                        </Link>
                                        <button
                                            onClick={() => handleDelete(responsibility.id)}
                                            className="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition text-sm"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )
                ) : (
                    <div className="bg-white rounded-lg shadow-md p-12 text-center">
                        <p className="text-gray-500 text-lg">No responsibilities found matching your filters.</p>
                    </div>
                )}
            </div>
        </AuthenticatedLayout>
    );
}
