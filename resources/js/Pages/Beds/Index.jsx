import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, router } from '@inertiajs/react';

export default function BedsIndex({ beds }) {
    const handleDelete = (id) => {
        if (confirm('Are you sure?')) {
            router.delete(route('beds.destroy', id));
        }
    };

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
            <Head title="Hospital Beds" />
            
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="flex justify-between items-center mb-6">
                                <h2 className="text-2xl font-semibold">Hospital Beds</h2>
                                <Link href={route('beds.create')} className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700">
                                    Add Bed
                                </Link>
                            </div>

                            <div className="overflow-x-auto">
                                <table className="min-w-full border-collapse border border-gray-300">
                                    <thead className="bg-gray-100">
                                        <tr>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Bed Number</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Ward</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Status</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {beds && beds.data && beds.data.length > 0 ? (
                                            beds.data.map((bed) => (
                                                <tr key={bed.bedid}>
                                                    <td className="border border-gray-300 px-4 py-2">{bed.bednumber}</td>
                                                    <td className="border border-gray-300 px-4 py-2">{bed.ward?.name}</td>
                                                    <td className="border border-gray-300 px-4 py-2">
                                                        <span className={`px-3 py-1 rounded-full text-sm font-medium ${getStatusBadge(bed.status)}`}>
                                                            {bed.status}
                                                        </span>
                                                    </td>
                                                    <td className="border border-gray-300 px-4 py-2">
                                                        <Link href={route('beds.show', bed.bedid)} className="text-blue-600 hover:text-blue-900 mr-2">
                                                            View
                                                        </Link>
                                                        <Link href={route('beds.edit', bed.bedid)} className="text-cyan-600 hover:text-cyan-900 mr-2">
                                                            Edit
                                                        </Link>
                                                        <button onClick={() => handleDelete(bed.bedid)} className="text-red-600 hover:text-red-900">Delete</button>
                                                    </td>
                                                </tr>
                                            ))
                                        ) : (
                                            <tr>
                                                <td colSpan="4" className="border border-gray-300 px-4 py-2 text-center">
                                                    No beds found
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
