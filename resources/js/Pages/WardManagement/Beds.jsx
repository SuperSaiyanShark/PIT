import { router, Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Beds({ ward, beds }) {
    // Sort beds numerically by bed number
    const sortedBeds = [...beds].sort((a, b) => {
        const numA = parseInt(a.bedNumber.replace('B-', ''));
        const numB = parseInt(b.bedNumber.replace('B-', ''));
        return numA - numB;
    });

    const handleAssign = (bedNumber) => {
        router.get(route('my-wards.beds.assign.form', [ward.wardNumber, bedNumber]));
    };

    const handleVacate = (bedNumber) => {
        if (confirm('Vacate this bed?')) {
            router.post(route('my-wards.beds.vacate', [ward.wardNumber, bedNumber]));
        }
    };

    return (
        <AuthenticatedLayout>
            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                <div className="max-w-7xl mx-auto">

                    <div className="mb-8">
                        <h1 className="text-3xl font-bold text-cyan-700">BED MANAGEMENT</h1>
                        <p className="text-sm text-cyan-600 mt-1">
                            Managing beds in {ward.wardName} ({ward.wardNumber})
                        </p>
                    </div>

                    <div className="mb-4">
                        <Link href={route('my-wards.index')} className="text-cyan-600 hover:text-cyan-800">
                            ← Back to Wards
                        </Link>
                    </div>

                    <div className="bg-white rounded-lg shadow-md overflow-x-auto">
                        <table className="w-full">
                            <thead className="bg-cyan-600 text-white">
                                <tr>
                                    <th className="px-6 py-3 text-left text-sm font-semibold">Bed Number</th>
                                    <th className="px-6 py-3 text-left text-sm font-semibold">Status</th>
                                    <th className="px-6 py-3 text-left text-sm font-semibold">Patient Name</th>
                                    <th className="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-200">
                                {sortedBeds.map((bed) => (
                                    <tr key={bed.id} className="hover:bg-gray-50">
                                        <td className="px-6 py-4 text-sm font-medium text-gray-900">{bed.bedNumber}</td>
                                        <td className="px-6 py-4 text-sm">
                                            <span className={`px-2 py-1 rounded-full text-xs font-semibold ${
                                                bed.status === 'Available' ? 'bg-green-100 text-green-800' :
                                                bed.status === 'Occupied' ? 'bg-red-100 text-red-800' :
                                                'bg-yellow-100 text-yellow-800'
                                            }`}>
                                                {bed.status}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 text-sm text-gray-600">{bed.patient_name || '—'}</td>
                                        <td className="px-6 py-4 text-sm">
                                            {bed.status === 'Available' && (
                                                <button
                                                    onClick={() => handleAssign(bed.bedNumber)}
                                                    className="text-green-600 hover:text-green-900 font-medium"
                                                >
                                                    Assign Patient
                                                </button>
                                            )}
                                            {bed.status === 'Occupied' && (
                                                <button
                                                    onClick={() => handleVacate(bed.bedNumber)}
                                                    className="text-orange-600 hover:text-orange-900 font-medium"
                                                >
                                                    Vacate Bed
                                                </button>
                                            )}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}