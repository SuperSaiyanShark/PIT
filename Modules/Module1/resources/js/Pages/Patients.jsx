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

    // Helper function to get full name from first_name and last_name
    const getFullName = (patient) => {
        const firstName = patient.first_name || '';
        const lastName = patient.last_name || '';
        return (firstName + ' ' + lastName).trim();
    };

    const filteredPatients = useMemo(() => {
        return patients.filter(patient => {
            const wardName = patient.ward?.name || '';
            const fullName = getFullName(patient);
            
            const matchesSearch = 
                fullName.toLowerCase().includes(searchTerm.toLowerCase()) ||
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
        const fullName = getFullName(patient);
        setFormData({
            name: fullName,
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

    return (\n        <AuthenticatedLayout>\n            <Head title=\"Patient Management\" />\n\n            <div className=\"min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8\">\n                {/* Header */}\n                <div className=\"mb-6\">\n                    <h1 className=\"text-3xl font-bold text-cyan-700\">PATIENT MANAGEMENT</h1>\n                    <p className=\"text-sm text-cyan-600 mt-1\">\"Manage and View Patient Information\"</p>\n                </div>\n\n                {/* Search and Filter Section */}\n                <div className=\"bg-white rounded-lg shadow-md p-6 mb-8\">\n                    <div className=\"flex flex-col md:flex-row gap-4 items-end\">\n                        {/* Search Input */}\n                        <div className=\"flex-1 min-w-0\">\n                            <label className=\"block text-sm font-medium text-gray-700 mb-2\">Search</label>\n                            <input\n                                type=\"text\"\n                                placeholder=\"Search by patient name, allocation ID, ward...\"\n                                value={searchTerm}\n                                onChange={(e) => setSearchTerm(e.target.value)}\n                                className=\"w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent\"\n                            />\n                        </div>\n\n                        {/* Ward Filter */}\n                        <div className=\"flex items-center gap-2\">\n                            <label htmlFor=\"ward\" className=\"text-sm font-medium text-gray-700\">Ward:</label>\n                            <select\n                                id=\"ward\"\n                                value={selectedWard}\n                                onChange={(e) => setSelectedWard(e.target.value)}\n                                className=\"px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white font-semibold\"\n                            >\n                                <option value=\"\">ALL WARDS</option>\n                                {wards.map(ward => (\n                                    <option key={ward.id} value={ward.id}>\n                                        {ward.name}\n                                    </option>\n                                ))}\n                            </select>\n                        </div>\n\n                        {/* Add Patient Button */}\n                        <PrimaryButton onClick={handleCreatePatient}>\n                            + Add New Patient\n                        </PrimaryButton>\n                    </div>\n\n                    {/* Results Summary */}\n                    <div className=\"text-gray-700 mt-4\">\n                        <p>Showing <span className=\"font-semibold text-cyan-600\">{filteredPatients.length}</span> of <span className=\"font-semibold\">{patients.length}</span> patients</p>\n                    </div>\n                </div>\n\n                {/* Patients Table */}\n                {filteredPatients.length > 0 ? (\n                    <div className=\"bg-white rounded-lg shadow-md overflow-x-auto\">\n                        <table className=\"w-full\">\n                            <thead className=\"bg-cyan-600 text-white\">\n                                <tr>\n                                    <th className=\"px-6 py-3 text-left text-sm font-semibold\">Patient Name</th>\n                                    <th className=\"px-6 py-3 text-left text-sm font-semibold\">Allocation ID</th>\n                                    <th className=\"px-6 py-3 text-left text-sm font-semibold\">Ward</th>\n                                    <th className=\"px-6 py-3 text-left text-sm font-semibold\">Date Admitted</th>\n                                    <th className=\"px-6 py-3 text-left text-sm font-semibold\">Expected Duration</th>\n                                    <th className=\"px-6 py-3 text-left text-sm font-semibold\">Expected Leave Date</th>\n                                    <th className=\"px-6 py-3 text-left text-sm font-semibold\">Status</th>\n                                    <th className=\"px-6 py-3 text-left text-sm font-semibold\">Actions</th>\n                                </tr>\n                            </thead>\n                            <tbody className=\"divide-y divide-gray-200\">\n                                {filteredPatients.map(patient => (\n                                    <tr key={patient.id} className=\"hover:bg-gray-50\">\n                                        <td className=\"px-6 py-4 text-sm font-medium text-gray-900\">{getFullName(patient)}</td>\n                                        <td className=\"px-6 py-4 text-sm text-gray-600 font-semibold\">{patient.allocation_id}</td>\n                                        <td className=\"px-6 py-4 text-sm text-gray-600\">\n                                            <span className=\"inline-block bg-cyan-100 text-cyan-800 px-3 py-1 rounded-full text-xs font-semibold\">\n                                                {patient.ward?.name || 'N/A'}\n                                            </span>\n                                        </td>\n                                        <td className=\"px-6 py-4 text-sm text-gray-600\">{new Date(patient.date_admitted).toLocaleDateString()}</td>\n                                        <td className=\"px-6 py-4 text-sm text-gray-600 text-center\">{patient.expected_duration} days</td>\n                                        <td className=\"px-6 py-4 text-sm text-gray-600\">{new Date(patient.date_expected_leave).toLocaleDateString()}</td>\n                                        <td className=\"px-6 py-4 text-sm\">\n                                            <span className={`inline-block px-3 py-1 rounded-full text-xs font-semibold ${\n                                                patient.status === 'admitted' ? 'bg-green-100 text-green-800' :\n                                                patient.status === 'discharged' ? 'bg-gray-100 text-gray-800' :\n                                                'bg-yellow-100 text-yellow-800'\n                                            }`}>\n                                                {patient.status}\n                                            </span>\n                                        </td>\n                                        <td className=\"px-6 py-4 text-sm space-x-2 flex\">\n                                            <button\n                                                onClick={() => handleEditPatient(patient)}\n                                                className=\"text-cyan-600 hover:text-cyan-900 font-medium\"\n                                            >\n                                                Edit\n                                            </button>\n                                            <button\n                                                onClick={() => handleDeletePatient(patient.id)}\n                                                className=\"text-red-600 hover:text-red-900 font-medium\"\n                                            >\n                                                Delete\n                                            </button>\n                                        </td>\n                                    </tr>\n                                ))}\n                            </tbody>\n                        </table>\n                    </div>\n                ) : (\n                    <div className=\"text-center py-12 bg-white rounded-lg shadow-md\">\n                        <p className=\"text-gray-600 text-lg\">No patients found matching your search.</p>\n                    </div>\n                )}\n\n                {/* Modal for Patient Form */}\n                <Modal show={showModal} onClose={() => setShowModal(false)}>\n                    <div className=\"p-6\">\n                        <h2 className=\"text-2xl font-bold text-gray-900 mb-6\">\n                            {selectedPatient ? 'Edit Patient' : 'Add New Patient'}\n                        </h2>\n\n                        <form onSubmit={handleSubmit} className=\"space-y-6\">\n                            <div className=\"grid grid-cols-1 md:grid-cols-2 gap-6\">\n                                {/* Patient Name */}\n                                <div>\n                                    <label className=\"block text-sm font-medium text-gray-700 mb-2\">Patient Name</label>\n                                    <input\n                                        type=\"text\"\n                                        name=\"name\"\n                                        value={formData.name}\n                                        onChange={handleInputChange}\n                                        className=\"w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent\"\n                                        required\n                                    />\n                                </div>\n\n                                {/* Allocation ID */}\n                                <div>\n                                    <label className=\"block text-sm font-medium text-gray-700 mb-2\">Allocation ID</label>\n                                    <input\n                                        type=\"text\"\n                                        name=\"allocation_id\"\n                                        value={formData.allocation_id}\n                                        onChange={handleInputChange}\n                                        className=\"w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent\"\n                                        required\n                                        disabled={selectedPatient !== null}\n                                    />\n                                </div>\n\n                                {/* Ward */}\n                                <div>\n                                    <label className=\"block text-sm font-medium text-gray-700 mb-2\">Ward</label>\n                                    <select\n                                        name=\"ward_id\"\n                                        value={formData.ward_id}\n                                        onChange={handleInputChange}\n                                        className=\"w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent\"\n                                        required\n                                    >\n                                        <option value=\"\">Select a ward</option>\n                                        {wards.map(ward => (\n                                            <option key={ward.id} value={ward.id}>\n                                                {ward.name}\n                                            </option>\n                                        ))}\n                                    </select>\n                                </div>\n\n                                {/* Status */}\n                                <div>\n                                    <label className=\"block text-sm font-medium text-gray-700 mb-2\">Status</label>\n                                    <select\n                                        name=\"status\"\n                                        value={formData.status}\n                                        onChange={handleInputChange}\n                                        className=\"w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent\"\n                                    >\n                                        <option value=\"admitted\">Admitted</option>\n                                        <option value=\"discharged\">Discharged</option>\n                                        <option value=\"transferred\">Transferred</option>\n                                    </select>\n                                </div>\n\n                                {/* Date Admitted */}\n                                <div>\n                                    <label className=\"block text-sm font-medium text-gray-700 mb-2\">Date Admitted</label>\n                                    <input\n                                        type=\"date\"\n                                        name=\"date_admitted\"\n                                        value={formData.date_admitted}\n                                        onChange={handleInputChange}\n                                        className=\"w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent\"\n                                        required\n                                    />\n                                </div>\n\n                                {/* Expected Duration */}\n                                <div>\n                                    <label className=\"block text-sm font-medium text-gray-700 mb-2\">Expected Duration (days)</label>\n                                    <input\n                                        type=\"number\"\n                                        name=\"expected_duration\"\n                                        value={formData.expected_duration}\n                                        onChange={handleInputChange}\n                                        className=\"w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent\"\n                                        min=\"1\"\n                                        required\n                                    />\n                                </div>\n\n                                {/* Expected Leave Date */}\n                                <div className=\"md:col-span-2\">\n                                    <label className=\"block text-sm font-medium text-gray-700 mb-2\">Expected Leave Date</label>\n                                    <input\n                                        type=\"date\"\n                                        name=\"date_expected_leave\"\n                                        value={formData.date_expected_leave}\n                                        onChange={handleInputChange}\n                                        className=\"w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent\"\n                                        required\n                                    />\n                                </div>\n                            </div>\n\n                            {/* Submit Button */}\n                            <div className=\"flex justify-end gap-3\">\n                                <button\n                                    type=\"button\"\n                                    onClick={() => setShowModal(false)}\n                                    className=\"px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300\"\n                                >\n                                    Cancel\n                                </button>\n                                <button\n                                    type=\"submit\"\n                                    disabled={isLoading}\n                                    className=\"px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 disabled:bg-gray-400\"\n                                >\n                                    {isLoading ? 'Saving...' : selectedPatient ? 'Update Patient' : 'Add Patient'}\n                                </button>\n                            </div>\n                        </form>\n                    </div>\n                </Modal>\n            </div>\n        </AuthenticatedLayout>\n    );\n}
