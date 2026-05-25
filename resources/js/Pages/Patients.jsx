import { useState, useMemo, useEffect } from 'react';
import { useForm, Head } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Modal from '@/Components/Modal';
import PrimaryButton from '@/Components/PrimaryButton';

export default function Patients({ patients = [], wards = [] }) {
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedWard, setSelectedWard] = useState('');
    const [showModal, setShowModal] = useState(false);
    const [selectedPatient, setSelectedPatient] = useState(null);

    // Using Inertia's hook simplifies loading, errors, and resets
    const form = useForm({
        name: '',
        allocation_id: '',
        ward_id: '',
        date_admitted: '',
        expected_duration: '',
        date_expected_leave: '',
        status: 'admitted',
    });

    // Helper function to get full name from first_name and last_name
    const getFullName = (patient) => {
        const firstName = patient.first_name || '';
        const lastName = patient.last_name || '';
        return (firstName + ' ' + lastName).trim();
    };

    // Client-side filtering logic
    const filteredPatients = useMemo(() => {
        return patients.filter(patient => {
            const wardName = patient.ward?.name || '';
            const searchLower = searchTerm.toLowerCase();
            const fullName = getFullName(patient);
            
            const matchesSearch = 
                fullName.toLowerCase().includes(searchLower) ||
                patient.allocation_id.toLowerCase().includes(searchLower) ||
                wardName.toLowerCase().includes(searchLower);
            
            const matchesWard = selectedWard === '' || patient.ward_id === parseInt(selectedWard);
            
            return matchesSearch && matchesWard;
        });
    }, [searchTerm, selectedWard, patients]);

    // Automatically calculate expected leave date based on admission date and duration
    useEffect(() => {
        if (form.data.date_admitted && form.data.expected_duration) {
            const admissionDate = new Date(form.data.date_admitted);
            const durationDays = parseInt(form.data.expected_duration, 10);
            
            if (!isNaN(admissionDate.getTime()) && !isNaN(durationDays)) {
                admissionDate.setDate(admissionDate.getDate() + durationDays);
                // Formats to YYYY-MM-DD safely
                const leaveDateString = admissionDate.toISOString().split('T')[0];
                form.setData('date_expected_leave', leaveDateString);
            }
        }
    }, [form.data.date_admitted, form.data.expected_duration]);

    const handleCreatePatient = () => {
        setSelectedPatient(null);
        form.reset();
        form.clearErrors();
        setShowModal(true);
    };

    const handleEditPatient = (patient) => {
        setSelectedPatient(patient);
        form.clearErrors();
        const fullName = getFullName(patient);
        form.setData({
            name: fullName,
            allocation_id: patient.allocation_id || '',
            ward_id: patient.ward_id || '',
            date_admitted: patient.date_admitted || '',
            expected_duration: patient.expected_duration || '',
            date_expected_leave: patient.date_expected_leave || '',
            status: patient.status || 'admitted',
        });
        setShowModal(true);
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        if (selectedPatient) {
            form.patch(route('patients.update', selectedPatient.id), {
                onSuccess: () => setShowModal(false),
            });
        } else {
            form.post(route('patients.store'), {
                onSuccess: () => setShowModal(false),
            });
        }
    };

    const handleDeletePatient = (id) => {
        if (confirm('Are you sure you want to delete this patient?')) {
            form.delete(route('patients.destroy', id));
        }
    };

    return (
        <AuthenticatedLayout>
            <Head title="Patient Management" />

            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                {/* Header */}
                <div className="mb-6">
                    <h1 className="text-3xl font-bold text-cyan-700 uppercase tracking-wide">Patient Management</h1>
                    <p className="text-sm text-cyan-600 mt-1">"Manage and View Patient Information"</p>
                </div>

                {/* Search and Filter Section */}
                <div className="bg-white rounded-lg shadow-md p-6 mb-8">
                    <div className="flex flex-col md:flex-row gap-4 items-end">
                        {/* Search Input */}
                        <div className="flex-1 min-w-0">
                            <label className="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <input
                                type="text"
                                placeholder="Search by patient name, allocation ID, ward..."
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                            />
                        </div>

                        {/* Ward Filter */}
                        <div className="flex items-center gap-2">
                            <label htmlFor="ward" className="text-sm font-medium text-gray-700 whitespace-nowrap">Ward:</label>
                            <select
                                id="ward"
                                value={selectedWard}
                                onChange={(e) => setSelectedWard(e.target.value)}
                                className="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white font-semibold"
                            >
                                <option value="">ALL WARDS</option>
                                {wards.map(ward => (
                                    <option key={ward.id} value={ward.id}>
                                        {ward.name}
                                    </option>
                                ))}
                            </select>
                        </div>

                        {/* Add Patient Button */}
                        <PrimaryButton onClick={handleCreatePatient} className="whitespace-nowrap">
                            + Add New Patient
                        </PrimaryButton>
                    </div>

                    {/* Results Summary */}
                    <div className="text-gray-700 mt-4">
                        <p>Showing <span className="font-semibold text-cyan-600">{filteredPatients.length}</span> of <span className="font-semibold">{patients.length}</span> patients</p>
                    </div>
                </div>

                {/* Patients Table */}
                {filteredPatients.length > 0 ? (
                    <div className="bg-white rounded-lg shadow-md overflow-x-auto">
                        <table className="w-full">
                            <thead className="bg-cyan-600 text-white">
                                <tr>
                                    <th className="px-6 py-3 text-left text-sm font-semibold">Patient Name</th>
                                    <th className="px-6 py-3 text-left text-sm font-semibold">Allocation ID</th>
                                    <th className="px-6 py-3 text-left text-sm font-semibold">Ward</th>
                                    <th className="px-6 py-3 text-left text-sm font-semibold">Date Admitted</th>
                                    <th className="px-6 py-3 text-left text-sm font-semibold">Expected Duration</th>
                                    <th className="px-6 py-3 text-left text-sm font-semibold">Expected Leave Date</th>
                                    <th className="px-6 py-3 text-left text-sm font-semibold">Status</th>
                                    <th className="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-200">
                                {filteredPatients.map(patient => (
                                    <tr key={patient.id} className="hover:bg-gray-50">
                                        <td className="px-6 py-4 text-sm font-medium text-gray-900">{getFullName(patient)}</td>
                                        <td className="px-6 py-4 text-sm text-gray-600 font-semibold">{patient.allocation_id}</td>
                                        <td className="px-6 py-4 text-sm text-gray-600">
                                            <span className="inline-block bg-cyan-100 text-cyan-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                {patient.ward?.name || 'N/A'}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 text-sm text-gray-600">{new Date(patient.date_admitted).toLocaleDateString()}</td>
                                        <td className="px-6 py-4 text-sm text-gray-600 text-center">{patient.expected_duration} days</td>
                                        <td className="px-6 py-4 text-sm text-gray-600">{new Date(patient.date_expected_leave).toLocaleDateString()}</td>
                                        <td className="px-6 py-4 text-sm">
                                            <span className={`inline-block px-3 py-1 rounded-full text-xs font-semibold uppercase ${
                                                patient.status === 'admitted' ? 'bg-green-100 text-green-800' :
                                                patient.status === 'discharged' ? 'bg-gray-100 text-gray-800' :
                                                'bg-yellow-100 text-yellow-800'
                                            }`}>
                                                {patient.status}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 text-sm space-x-3 flex items-center">
                                            <button
                                                onClick={() => handleEditPatient(patient)}
                                                className="text-cyan-600 hover:text-cyan-900 font-medium transition"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                onClick={() => handleDeletePatient(patient.id)}
                                                className="text-red-600 hover:text-red-900 font-medium transition"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                ) : (
                    <div className="text-center py-12 bg-white rounded-lg shadow-md">
                        <p className="text-gray-600 text-lg">No patients found matching your search.</p>
                    </div>
                )}

                {/* Modal for Patient Form */}
                <Modal show={showModal} onClose={() => setShowModal(false)}>
                    <div className="p-6">
                        <h2 className="text-2xl font-bold text-gray-900 mb-6">
                            {selectedPatient ? 'Edit Patient' : 'Add New Patient'}
                        </h2>

                        <form onSubmit={handleSubmit} className="space-y-6">
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {/* Patient Name */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">Patient Name</label>
                                    <input
                                        type="text"
                                        value={form.data.name}
                                        onChange={e => form.setData('name', e.target.value)}
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                        required
                                    />
                                    {form.errors.name && <div className="text-sm text-red-600 mt-1">{form.errors.name}</div>}
                                </div>

                                {/* Allocation ID */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">Allocation ID</label>
                                    <input
                                        type="text"
                                        value={form.data.allocation_id}
                                        onChange={e => form.setData('allocation_id', e.target.value)}
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent disabled:bg-gray-100 disabled:text-gray-500"
                                        required
                                        disabled={selectedPatient !== null}
                                    />
                                    {form.errors.allocation_id && <div className="text-sm text-red-600 mt-1">{form.errors.allocation_id}</div>}
                                </div>

                                {/* Ward */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">Ward</label>
                                    <select
                                        value={form.data.ward_id}
                                        onChange={e => form.setData('ward_id', e.target.value)}
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                        required
                                    >
                                        <option value="">Select a ward</option>
                                        {wards.map(ward => (
                                            <option key={ward.id} value={ward.id}>
                                                {ward.name}
                                            </option>
                                        ))}
                                    </select>
                                    {form.errors.ward_id && <div className="text-sm text-red-600 mt-1">{form.errors.ward_id}</div>}
                                </div>

                                {/* Status */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select
                                        value={form.data.status}
                                        onChange={e => form.setData('status', e.target.value)}
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                    >
                                        <option value="admitted">Admitted</option>
                                        <option value="discharged">Discharged</option>
                                        <option value="transferred">Transferred</option>
                                    </select>
                                    {form.errors.status && <div className="text-sm text-red-600 mt-1">{form.errors.status}</div>}
                                </div>

                                {/* Date Admitted */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">Date Admitted</label>
                                    <input
                                        type="date"
                                        value={form.data.date_admitted}
                                        onChange={e => form.setData('date_admitted', e.target.value)}
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                        required
                                    />
                                    {form.errors.date_admitted && <div className="text-sm text-red-600 mt-1">{form.errors.date_admitted}</div>}
                                </div>

                                {/* Expected Duration */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">Expected Duration (days)</label>
                                    <input
                                        type="number"
                                        value={form.data.expected_duration}
                                        onChange={e => form.setData('expected_duration', e.target.value)}
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                        min="1"
                                        required
                                    />
                                    {form.errors.expected_duration && <div className="text-sm text-red-600 mt-1">{form.errors.expected_duration}</div>}
                                </div>

                                {/* Expected Leave Date */}
                                <div className="md:col-span-2">
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Expected Leave Date <span className="text-xs text-gray-400 font-normal">(Calculated automatically)</span>
                                    </label>
                                    <input
                                        type="date"
                                        value={form.data.date_expected_leave}
                                        onChange={e => form.setData('date_expected_leave', e.target.value)}
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-gray-50"
                                        required
                                        readOnly
                                    />
                                    {form.errors.date_expected_leave && <div className="text-sm text-red-600 mt-1">{form.errors.date_expected_leave}</div>}
                                </div>
                            </div>

                            {/* Submit & Cancel Buttons */}
                            <div className="flex justify-end gap-3">
                                <button
                                    type="button"
                                    onClick={() => setShowModal(false)}
                                    className="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    disabled={form.processing}
                                    className="px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 disabled:bg-gray-400 transition"
                                >
                                    {form.processing ? 'Saving...' : selectedPatient ? 'Update Patient' : 'Add Patient'}
                                </button>
                            </div>
                        </form>
                    </div>
                </Modal>
            </div>
        </AuthenticatedLayout>
    );
}