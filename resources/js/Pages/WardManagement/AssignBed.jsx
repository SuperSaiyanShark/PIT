import { useState } from 'react';
import { router, Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function AssignBed({ ward, bed }) {
    const [patientName, setPatientName] = useState('');
    const [loading, setLoading] = useState(false);

    const handleSubmit = (e) => {
        e.preventDefault();
        setLoading(true);
        router.post(route('my-wards.beds.assign', [ward.wardNumber, bed.bedNumber]), { patient_name: patientName }, {
            onFinish: () => setLoading(false)
        });
    };

    return (
        <AuthenticatedLayout>
            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                <div className="max-w-2xl mx-auto">

                    <div className="mb-8">
                        <h1 className="text-3xl font-bold text-cyan-700">ASSIGN PATIENT</h1>
                        <p className="text-sm text-cyan-600 mt-1">
                            Assign patient to Bed {bed.bedNumber} in {ward.wardName}
                        </p>
                    </div>

                    <div className="bg-white rounded-lg shadow-md p-6">
                        <form onSubmit={handleSubmit}>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700 mb-2">Patient Name</label>
                                <input
                                    type="text"
                                    value={patientName}
                                    onChange={(e) => setPatientName(e.target.value)}
                                    required
                                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                    placeholder="Enter patient full name"
                                />
                            </div>

                            <div className="flex gap-3">
                                <button
                                    type="submit"
                                    disabled={loading}
                                    className="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2 rounded-lg font-semibold transition"
                                >
                                    {loading ? 'Assigning...' : 'Assign Patient'}
                                </button>
                                <Link
                                    href={route('my-wards.beds', ward.wardNumber)}
                                    className="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-semibold transition text-center"
                                >
                                    Cancel
                                </Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}