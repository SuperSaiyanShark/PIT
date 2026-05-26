import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, router } from '@inertiajs/react';

export default function PatientNextOfKinIndex({ nextOfKins }) {
    const handleDelete = (id) => {
        if (confirm('Are you sure?')) {
            router.delete(route('patient-next-of-kin.destroy', id));
        }
    };

    return (
        <AuthenticatedLayout>
            <Head title="Patient Next of Kin" />
            
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="flex justify-between items-center mb-6">
                                <h2 className="text-2xl font-semibold">Patient Next of Kin</h2>
                                <Link href={route('patient-next-of-kin.create')} className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700">
                                    Add Next of Kin
                                </Link>
                            </div>

                            <div className="overflow-x-auto">
                                <table className="min-w-full border-collapse border border-gray-300">
                                    <thead className="bg-gray-100">
                                        <tr>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Patient Name</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Full Name</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Relationship</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Phone</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Address</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {nextOfKins && nextOfKins.data && nextOfKins.data.length > 0 ? (
                                            nextOfKins.data.map((kin) => (
                                                <tr key={kin.id}>
                                                    <td className="border border-gray-300 px-4 py-2">{kin.patient?.first_name} {kin.patient?.last_name}</td>
                                                    <td className="border border-gray-300 px-4 py-2">{kin.full_name}</td>
                                                    <td className="border border-gray-300 px-4 py-2">{kin.relationship}</td>
                                                    <td className="border border-gray-300 px-4 py-2">{kin.phone_number}</td>
                                                    <td className="border border-gray-300 px-4 py-2">{kin.address}</td>
                                                    <td className="border border-gray-300 px-4 py-2">
                                                        <Link href={route('patient-next-of-kin.edit', kin.id)} className="text-cyan-600 hover:text-cyan-900 mr-2">
                                                            Edit
                                                        </Link>
                                                        <button onClick={() => handleDelete(kin.id)} className="text-red-600 hover:text-red-900">Delete</button>
                                                    </td>
                                                </tr>
                                            ))
                                        ) : (
                                            <tr>
                                                <td colSpan="6" className="border border-gray-300 px-4 py-2 text-center">
                                                    No next of kin found
                                                </td>
                                            </tr>
                                        )}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
