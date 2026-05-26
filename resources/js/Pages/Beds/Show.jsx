import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function BedsShow({ bed }) {
    const getStatusBadge = (status) => {
        const colors = {
            available: 'bg-green-100 text-green-800',
            occupied: 'bg-red-100 text-red-800',
            maintenance: 'bg-yellow-100 text-yellow-800',
        };
        return colors[status] || 'bg-gray-100 text-gray-800';
    };

    return (
        <AuthenticatedLayout>
            <Head title={`Bed - ${bed.bednumber}`} />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="flex justify-between items-center mb-6">
                                <h2 className="text-2xl font-semibold">Bed Details</h2>
                                <div className="space-x-2">
                                    <Link href={route('beds.edit', bed.bedid)} className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700">
                                        Edit
                                    </Link>
                                    <Link href={route('beds.index')} className="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                        Back
                                    </Link>
                                </div>
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Bed Number</label>
                                    <p className="mt-1 text-gray-900">{bed.bednumber}</p>
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Ward</label>
                                    <p className="mt-1 text-gray-900">{bed.ward?.name}</p>
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Status</label>
                                    <p className="mt-1">
                                        <span className={`px-3 py-1 rounded-full text-sm font-medium ${getStatusBadge(bed.status)}`}>
                                            {bed.status}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
