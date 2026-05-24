import { useState, useMemo } from 'react';
import { Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import { Head } from '@inertiajs/react';

export default function ResponsibilitiesIndex({ responsibilities = [], patients = [] }) {
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

    const filteredPatients = useMemo(() => {
        return patients.filter(patient => {
            const wardName = patient.ward?.name || '';

            const matchesSearch =
                patient.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                patient.allocation_id.toLowerCase().includes(searchTerm.toLowerCase()) ||
                wardName.toLowerCase().includes(searchTerm.toLowerCase());

            const matchesWard = selectedWard === '' || patient.ward?.name === selectedWard;
            const matchesStatus = selectedStatus === '' || patient.status === selectedStatus;

            return matchesSearch && matchesWard && matchesStatus;
        });
    }, [searchTerm, selectedWard, selectedStatus, patients]);

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this patient?')) {
            router.delete(route('patients.destroy', id));
        }
    };

    return (
        <AuthenticatedLayout>
            <Head title="Patient Management" />

            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                <div className="mb-8">
                    <div className="flex justify-between items-start">
                        <div>
                            <h1 className="text-3xl font-bold text-cyan-700">PATIENT TRACKING</h1>
                            <p className="text-cyan-700 font-semibold">Patient Care & Ward Assignment</p>
                            <p className="text-sm text-cyan-600">"Monitor and manage patient admissions and ward assignments"</p>
                        </div>
                        <Link href={route('patients.create')}>
                            <PrimaryButton>+ Add New Patient</PrimaryButton>
                        </Link>
                    </div>
                </div>

                <div className="bg-white rounded-lg shadow-md p-6 mb-8">
                    <div className="flex flex-col md:flex-row gap-4 items-end mb-6">
                        <div className="flex-1 min-w-0">
                            <label className="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <input
                                type="text"
                                placeholder="Search by patient name, allocation ID, or ward..."
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                            />
                        </div>

                        <div className="flex items-center gap-2">
                            <label htmlFor="ward" className="text-sm font-medium text-gray-700">Ward:</label>
                            <select
                                id="ward"
                                value={selectedWard}
                                onChange={(e) => setSelectedWard(e.target.value)}
                                className="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 bg-white font-semibold"
                            >
                                <option value="">ALL WARDS</option>
                                {uniqueWards.map(ward => (
                                    <option key={ward} value={ward}>{ward}</option>
                                ))}
                            </select>
                        </div>

                        <div className="flex items-center gap-2">
                            <label htmlFor="status" className="text-sm font-medium text-gray-700">Status:</label>
                            <select
                                id="status"
                                value={selectedStatus}
                                onChange={(e) => setSelectedStatus(e.target.value)}
                                className="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 bg-white font-semibold"
                            >
                                <option value="">ALL STATUSES</option>
                                {statuses.map(status => (
                                    <option key={status} value={status}>
                                        {status.charAt(0).toUpperCase() + status.slice(1)}
                                    </option>
                                ))}
                            </select>
                        </div>
                    </div>

                    <div className="text-gray-700">
                        <p>Showing <span className="font-semibold text-cyan-600">{filteredPatients.length}</span> of <span className="font-semibold">{patients.length}</span> patients</p>
                    </div>
                </div>

                {filteredPatients.length > 0 ? (
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
                                            <button className="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-lg transition font-semibold text-sm">
                                                Edit
                                            </button>
                                        </Link>
                                        <button
                                            onClick={() => handleDelete(patient.id)}
                                            className="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition font-semibold text-sm"
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
                )}
            </div>
        </AuthenticatedLayout>
    );
}