import { useState, useMemo } from 'react';
import { router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Modal from '@/Components/Modal';
import PrimaryButton from '@/Components/PrimaryButton';
import { Head } from '@inertiajs/react';

export default function Patients({ patients = [], wards = [] }) {
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedWard, setSelectedWard] = useState('');
    const [showModal, setShowModal] = useState(false);
    const [isLoading, setIsLoading] = useState(false);
    const [selectedPatient, setSelectedPatient] = useState(null);
    const [formData, setFormData] = useState({
        name: '',
        allocation_id: '',
        ward_id: '',
        date_admitted: '',
        expected_duration: '',
        date_expected_leave: '',
        status: 'admitted',
    });

    const filteredPatients = useMemo(() => {
        return patients.filter(patient => {
            const wardName = patient.ward?.name || '';

            const matchesSearch =
                patient.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                patient.allocation_id.toLowerCase().includes(searchTerm.toLowerCase()) ||
                wardName.toLowerCase().includes(searchTerm.toLowerCase());

            const matchesWard = selectedWard === '' || patient.ward_id === parseInt(selectedWard);

            return matchesSearch && matchesWard;
        });
    }, [searchTerm, selectedWard, patients]);

    const handleCreatePatient = () => {
        setSelectedPatient(null);
        setFormData({
            name: '',
            allocation_id: '',
            ward_id: '',
            date_admitted: '',
            expected_duration: '',
            date_expected_leave: '',
            status: 'admitted',
        });
        setShowModal(true);
    };

    const handleEditPatient = (patient) => {
        setSelectedPatient(patient);
        setFormData({
            name: patient.name,
            allocation_id: patient.allocation_id,
            ward_id: patient.ward_id,
            date_admitted: patient.date_admitted,
            expected_duration: patient.expected_duration,
            date_expected_leave: patient.date_expected_leave,
            status: patient.status,
        });
        setShowModal(true);
    };

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        setIsLoading(true);

        if (selectedPatient) {
            router.patch(route('patients.update', selectedPatient.id), formData, {
                onSuccess: () => {
                    setShowModal(false);
                    setIsLoading(false);
                },
                onError: (errors) => {
                    console.error(errors);
                    setIsLoading(false);
                }
            });
        } else {
            router.post(route('patients.store'), formData, {
                onSuccess: () => {
                    setShowModal(false);
                    setIsLoading(false);
                },
                onError: (errors) => {
                    console.error(errors);
                    setIsLoading(false);
                }
            });
        }
    };

    const handleDeletePatient = (id) => {
        if (confirm('Are you sure you want to delete this patient?')) {
            router.delete(route('patients.destroy', id), {
                onSuccess: () => {
                    setSelectedPatient(null);
                }
            });
        }
    };

    return (
        <AuthenticatedLayout>
            <Head title="Patient Management" />

            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                <div className="mb-6">
                    <h1 className="text-3xl font-bold text-cyan-700">PATIENT MANAGEMENT</h1>
                    <p className="text-sm text-cyan-600 mt-1">"Manage and View Patient Information"</p>
                </div>

                <div className="bg-white rounded-lg shadow-md p-6 mb-8">
                    <div className="flex flex-col md:flex-row gap-4 items-end">
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

                        <div className="flex items-center gap-2">
                            <label htmlFor="ward" className="text-sm font-medium text-gray-700">Ward:</label>
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

                        <PrimaryButton onClick={handleCreatePatient}>
                            + Add New Patient
                        </PrimaryButton>
                    </div>

                    <div className="text-gray-700 mt-4">
                        <p>Showing <span className="font-semibold text-cyan-600">{filteredPatients.length}</span> of <span className="font-semibold">{patients.length}</span> patients</p>
                    </div>
                </div>

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
                                        <td className="px-6 py-4 text-sm font-medium text-gray-900">{patient.name}</td>
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
                                            <span className={`inline-block px-3 py-1 rounded-full text-xs font-semibold ${patient.status === 'admitted' ? 'bg-green-100 text-green-800' :
                                                    patient.status === 'discharged' ? 'bg-gray-100 text-gray-800' :
                                                        'bg-yellow-100 text-yellow-800'
                                                }`}>
                                                {patient.status}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 text-sm space-x-2 flex">
                                            <button
                                                onClick={() => handleEditPatient(patient)}
                                                className="text-cyan-600 hover:text-cyan-900 font-medium"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                onClick={() => handleDeletePatient(patient.id)}
                                                className="text-red-600 hover:text-red-900 font-medium"
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

                <Modal show={showModal} onClose={() => setShowModal(false)}>
                    <div className="p-6">
                        <h2 className="text-2xl font-bold text-gray-900 mb-6">
                            {selectedPatient ? 'Edit Patient' : 'Add New Patient'}
                        </h2>

                        <form onSubmit={handleSubmit} className="space-y-6">
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">Patient Name</label>
                                    <input
                                        type="text"
                                        name="name"
                                        value={formData.name}
                                        onChange={handleInputChange}
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                        required
                                    />
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">Allocation ID</label>
                                    <input
                                        type="text"
                                        name="allocation_id"
                                        value={formData.allocation_id}
                                        onChange={handleInputChange}
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                        required
                                        disabled={selectedPatient !== null}
                                    />
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">Ward</label>
                                    <select
                                        name="ward_id"
                                        value={formData.ward_id}
                                        onChange={handleInputChange}
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
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select
                                        name="status"
                                        value={formData.status}
                                        onChange={handleInputChange}
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                    >
                                        <option value="admitted">Admitted</option>
                                        <option value="discharged">Discharged</option>
                                        <option value="transferred">Transferred</option>
                                    </select>
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">Date Admitted</label>
                                    <input
                                        type="date"
                                        name="date_admitted"
                                        value={formData.date_admitted}
                                        onChange={handleInputChange}
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                        required
                                    />
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">Expected Duration (days)</label>
                                    <input
                                        type="number"
                                        name="expected_duration"
                                        value={formData.expected_duration}
                                        onChange={handleInputChange}
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                        min="1"
                                        required
                                    />
                                </div>

                                <div className="md:col-span-2">
                                    <label className="block text-sm font-medium text-gray-700 mb-2">Expected Leave Date</label>
                                    <input
                                        type="date"
                                        name="date_expected_leave"
                                        value={formData.date_expected_leave}
                                        onChange={handleInputChange}
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                        required
                                    />
                                </div>
                            </div>

                            <div className="flex justify-end gap-3">
                                <button
                                    type="button"
                                    onClick={() => setShowModal(false)}
                                    className="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    disabled={isLoading}
                                    className="px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 disabled:bg-gray-400"
                                >
                                    {isLoading ? 'Saving...' : selectedPatient ? 'Update Patient' : 'Add Patient'}
                                </button>
                            </div>
                        </form>
                    </div>
                </Modal>
            </div>
        </AuthenticatedLayout>
    );
}