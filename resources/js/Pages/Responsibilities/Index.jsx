import { useState, useMemo } from 'react';
import { Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import { Head } from '@inertiajs/react';

export default function ResponsibilitiesIndex({ responsibilities = [], patients = [] }) {
    // Tab State: 'patients' or 'responsibilities'
    const [activeTab, setActiveTab] = useState('patients');

    // Filter States
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedWard, setSelectedWard] = useState('');
    const [selectedStatus, setSelectedStatus] = useState('');

    const uniqueWards = [...new Set(patients.map(p => p.ward?.name).filter(Boolean))];
    const statuses = ['admitted', 'discharged', 'transferred'];

    const getStatusColor = (status) => {
        const colors = {
            'admitted': 'bg-green-100 text-green-800',
            'discharged': 'bg-gray-100 text-gray-800',
            'transferred': 'bg-yellow-100 text-yellow-800',
        };
        return colors[status] || 'bg-gray-100 text-gray-800';
    };

    const formatDate = (dateString) => {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', { year: 'numeric', month: '2-digit', day: '2-digit' });
    };

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this item?')) {
            // Add your Inertia router.delete call here
            console.log(`Deleting item with id: ${id}`);
        }
    };

    // Filter Patients
    const filteredPatients = useMemo(() => {
        return patients.filter(patient => {
            const wardName = patient.ward?.name || '';
            const patientName = patient.name || '';
            const allocationId = patient.allocation_id || '';
            const matchesSearch =
                patientName.toLowerCase().includes(searchTerm.toLowerCase()) ||
                allocationId.toLowerCase().includes(searchTerm.toLowerCase()) ||
                wardName.toLowerCase().includes(searchTerm.toLowerCase());

            const matchesWard = selectedWard === '' || patient.ward?.name === selectedWard;
            const matchesStatus = selectedStatus === '' || patient.status === selectedStatus;

            return matchesSearch && matchesWard && matchesStatus;
        });
    }, [searchTerm, selectedWard, selectedStatus, patients]);

    // Filter Responsibilities
    const filteredResponsibilities = useMemo(() => {
        return responsibilities.filter(resp => {
            const staffName = resp.staff?.name || '';
            const type = resp.responsibility_type || '';
            const desc = resp.description || '';
            const wardName = resp.ward?.name || '';

            const matchesSearch =
                staffName.toLowerCase().includes(searchTerm.toLowerCase()) ||
                type.toLowerCase().includes(searchTerm.toLowerCase()) ||
                desc.toLowerCase().includes(searchTerm.toLowerCase()) ||
                wardName.toLowerCase().includes(searchTerm.toLowerCase());

            const matchesWard = selectedWard === '' || resp.ward?.name === selectedWard;

            return matchesSearch && matchesWard;
        });
    }, [searchTerm, selectedWard, responsibilities]);

    return (
        <AuthenticatedLayout>
            <Head title="Management Dashboard" />

            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                
                {/* Header */}
                <div className="mb-8">
                    <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h1 className="text-3xl font-bold text-cyan-700">CLINICAL DASHBOARD</h1>
                            <p className="text-cyan-700 font-semibold">Monitor and manage patient care & staff duties</p>
                        </div>
                        <div className="flex gap-2">
                            <Link href={route('patients.create')}>
                                <PrimaryButton>+ Add Patient</PrimaryButton>
                            </Link>
                        </div>
                    </div>
                </div>

                {/* Navigation Tabs */}
                <div className="flex border-b border-gray-200 mb-6 bg-white rounded-t-lg shadow-sm px-4 pt-2">
                    <button
                        onClick={() => { setActiveTab('patients'); setSearchTerm(''); }}
                        className={`px-4 py-2 font-semibold text-sm border-b-2 transition ${activeTab === 'patients' ? 'border-cyan-600 text-cyan-600' : 'border-transparent text-gray-500 hover:text-gray-700'}`}
                    >
                        Patient Tracking ({filteredPatients.length})
                    </button>
                    <button
                        onClick={() => { setActiveTab('responsibilities'); setSearchTerm(''); }}
                        className={`px-4 py-2 font-semibold text-sm border-b-2 transition ${activeTab === 'responsibilities' ? 'border-cyan-600 text-cyan-600' : 'border-transparent text-gray-500 hover:text-gray-700'}`}
                    >
                        Staff Responsibilities ({filteredResponsibilities.length})
                    </button>
                </div>

                {/* Shared Global Filters */}
                <div className="bg-white rounded-b-lg shadow-md p-6 mb-8">
                    <div className="flex flex-col md:flex-row gap-4 items-end mb-4">
                        {/* Search */}
                        <div className="flex-1 min-w-0 w-full">
                            <label className="block text-sm font-medium text-gray-700 mb-2">Search Filters</label>
                            <input
                                type="text"
                                placeholder={activeTab === 'patients' ? "Search by patient name, allocation ID, or ward..." : "Search staff, duty type, description..."}
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                            />
                        </div>

                        {/* Ward Filter */}
                        <div className="flex items-center gap-2 w-full md:w-auto">
                            <label htmlFor="ward" className="text-sm font-medium text-gray-700 whitespace-nowrap">Ward:</label>
                            <select
                                id="ward"
                                value={selectedWard}
                                onChange={(e) => setSelectedWard(e.target.value)}
                                className="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 bg-white font-semibold"
                            >
                                <option value="">ALL WARDS</option>
                                {uniqueWards.map(ward => (
                                    <option key={ward} value={ward}>{ward}</option>
                                ))}
                            </select>
                        </div>

                        {/* Status Filter (Only relevant to Patients Tab) */}
                        {activeTab === 'patients' && (
                            <div className="flex items-center gap-2 w-full md:w-auto">
                                <label htmlFor="status" className="text-sm font-medium text-gray-700 whitespace-nowrap">Status:</label>
                                <select
                                    id="status"
                                    value={selectedStatus}
                                    onChange={(e) => setSelectedStatus(e.target.value)}
                                    className="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 bg-white font-semibold"
                                >
                                    <option value="">ALL STATUSES</option>
                                    {statuses.map(status => (
                                        <option key={status} value={status}>
                                            {status.charAt(0).toUpperCase() + status.slice(1)}
                                        </option>
                                    ))}
                                </select>
                            </div>
                        )}
                    </div>
                </div>

                {/* View Content Switching Conditional logic */}
                {activeTab === 'patients' ? (
                    filteredPatients.length > 0 ? (
                        <div className="space-y-4">
                            {filteredPatients.map(patient => (
                                <div key={patient.id} className="bg-white rounded-lg shadow-md border-l-4 border-cyan-500 p-6 hover:shadow-lg transition">
                                    <div className="flex justify-between items-start">
                                        <div className="flex-1">
                                            <div className="flex items-center justify-between mb-4">
                                                <h3 className="text-2xl font-bold text-gray-900">{patient.name}</h3>
                                                <span className={`px-3 py-1 rounded-full text-xs font-semibold ${getStatusColor(patient.status)}`}>
                                                    {patient.status}
                                                </span>
                                            </div>

                                            <div className="grid grid-cols-2 md:grid-cols-4 gap-6 mb-4">
                                                <div>
                                                    <p className="text-xs font-semibold text-gray-600 uppercase">Allocation ID</p>
                                                    <p className="text-lg font-bold text-gray-900 mt-1">{patient.allocation_id}</p>
                                                </div>
                                                <div>
                                                    <p className="text-xs font-semibold text-gray-600 uppercase">Ward</p>
                                                    <p className="text-lg font-bold text-gray-900 mt-1">{patient.ward?.name || 'N/A'}</p>
                                                </div>
                                                <div>
                                                    <p className="text-xs font-semibold text-gray-600 uppercase">Date Admitted</p>
                                                    <p className="text-lg font-bold text-gray-900 mt-1">{formatDate(patient.date_admitted)}</p>
                                                </div>
                                                <div>
                                                    <p className="text-xs font-semibold text-gray-600 uppercase">Expected Duration</p>
                                                    <p className="text-lg font-bold text-gray-900 mt-1">{patient.expected_duration} days</p>
                                                </div>
                                            </div>

                                            <div className="bg-cyan-50 rounded-lg p-4 border border-cyan-200">
                                                <p className="text-xs font-semibold text-gray-600 uppercase">Expected Leave Date</p>
                                                <p className="text-lg font-bold text-cyan-700 mt-1">{formatDate(patient.date_expected_leave)}</p>
                                            </div>
                                        </div>

                                        <div className="ml-6 flex flex-col gap-2">
                                            <Link href={route('patients.edit', patient.id)}>
                                                <button className="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-lg transition font-semibold text-sm w-20">
                                                    Edit
                                                </button>
                                            </Link>
                                            <button
                                                onClick={() => handleDelete(patient.id)}
                                                className="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition font-semibold text-sm w-20"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="text-center py-12 bg-white rounded-lg shadow-md">
                            <p className="text-gray-600 text-lg">No patients found matching your search.</p>
                        </div>
                    )
                ) : (
                    /* Responsibilities Tab Panel */
                    filteredResponsibilities.length > 0 ? (
                        <div className="space-y-4">
                            {filteredResponsibilities.map(responsibility => (
                                <div key={responsibility.id} className="bg-white rounded-lg shadow-md p-6 border-l-4 border-cyan-500 hover:shadow-lg transition">
                                    <div className="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 className="text-lg font-semibold text-gray-900">
                                                {responsibility.staff?.name || 'Assigned Staff'}
                                            </h3>
                                            <p className="text-sm text-gray-600 font-medium">
                                                {responsibility.responsibility_type}
                                            </p>
                                        </div>
                                        <span className={`px-3 py-1 rounded-full text-xs font-semibold ${getStatusColor(responsibility.status)}`}>
                                            {responsibility.status || 'Active'}
                                        </span>
                                    </div>

                                    <p className="text-gray-700 mb-4 bg-gray-50 p-3 rounded border border-gray-100">{responsibility.description}</p>

                                    <div className="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4 text-sm">
                                        <div>
                                            <span className="font-semibold text-gray-400 block text-xs uppercase">Department</span>
                                            <p className="text-gray-800 font-semibold">{responsibility.department?.name || '-'}</p>
                                        </div>
                                        <div>
                                            <span className="font-semibold text-gray-400 block text-xs uppercase">Ward</span>
                                            <p className="text-gray-800 font-semibold">{responsibility.ward?.name || '-'}</p>
                                        </div>
                                        <div>
                                            <span className="font-semibold text-gray-400 block text-xs uppercase">Start Date</span>
                                            <p className="text-gray-600">{formatDate(responsibility.start_date)}</p>
                                        </div>
                                        <div>
                                            <span className="font-semibold text-gray-400 block text-xs uppercase">End Date</span>
                                            <p className="text-gray-600">{formatDate(responsibility.end_date)}</p>
                                        </div>
                                    </div>

                                    <div className="flex gap-2 justify-end border-t pt-3 border-gray-100">
                                        <Link href={route('responsibilities.edit', responsibility.id)}>
                                            <button className="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-1.5 rounded transition text-sm font-semibold">
                                                Edit
                                            </button>
                                        </Link>
                                        <button
                                            onClick={() => handleDelete(responsibility.id)}
                                            className="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded transition text-sm font-semibold"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="bg-white rounded-lg shadow-md p-12 text-center">
                            <p className="text-gray-500 text-lg">No responsibilities found matching your filters.</p>
                        </div>
                    )
                )}
            </div>
        </AuthenticatedLayout>
    );
}