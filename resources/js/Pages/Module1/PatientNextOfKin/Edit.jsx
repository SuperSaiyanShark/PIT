import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, Link } from '@inertiajs/react';

export default function PatientNextOfKinEdit({ nextOfKin, patients }) {
    const { data, setData, put, processing, errors } = useForm({
        patient_id: nextOfKin.patient_id || '',
        full_name: nextOfKin.full_name || '',
        relationship: nextOfKin.relationship || '',
        address: nextOfKin.address || '',
        phone_number: nextOfKin.phone_number || '',
    });

    const submit = (e) => {
        e.preventDefault();
        put(route('patient-next-of-kin.update', nextOfKin.id));
    };

    return (
        <AuthenticatedLayout>
            <Head title={`Edit Next of Kin - ${nextOfKin.full_name}`} />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <h2 className="text-2xl font-semibold mb-6">Edit Next of Kin</h2>

                            <form onSubmit={submit} className="space-y-6">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Patient *</label>
                                    <select
                                        value={data.patient_id}
                                        onChange={(e) => setData('patient_id', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    >
                                        <option value="">Select a patient</option>
                                        {patients?.map((patient) => (
                                            <option key={patient.id} value={patient.id}>
                                                {patient.first_name} {patient.last_name}
                                            </option>
                                        ))}
                                    </select>
                                    {errors.patient_id && <div className="text-red-600 text-sm mt-1">{errors.patient_id}</div>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Full Name *</label>
                                    <input
                                        type="text"
                                        value={data.full_name}
                                        onChange={(e) => setData('full_name', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                    {errors.full_name && <div className="text-red-600 text-sm mt-1">{errors.full_name}</div>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Relationship</label>
                                    <input
                                        type="text"
                                        value={data.relationship}
                                        onChange={(e) => setData('relationship', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                    {errors.relationship && <div className="text-red-600 text-sm mt-1">{errors.relationship}</div>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input
                                        type="tel"
                                        value={data.phone_number}
                                        onChange={(e) => setData('phone_number', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                    {errors.phone_number && <div className="text-red-600 text-sm mt-1">{errors.phone_number}</div>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Address</label>
                                    <input
                                        type="text"
                                        value={data.address}
                                        onChange={(e) => setData('address', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                    {errors.address && <div className="text-red-600 text-sm mt-1">{errors.address}</div>}
                                </div>

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700 disabled:opacity-50"
                                >
                                    Update Next of Kin
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
