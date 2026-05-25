import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function WardsIndex({ wards }) {
    return (
        <AuthenticatedLayout>
            <Head title="Wards & Beds" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="flex justify-between items-center mb-6">
                                <h2 className="text-2xl font-semibold">Wards & Beds</h2>
                                <Link href={route('wards.create')} className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700">
                                    Add Ward
                                </Link>
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                {wards && wards.length > 0 ? (
                                    wards.map((ward) => (
                                        <div key={ward.allocationid} className="border border-gray-300 rounded-lg p-4">
                                            <h3 className="text-lg font-semibold">{ward.wardName}</h3>
                                            <p className="text-sm text-gray-600">Ward #{ward.wardNumber}</p>
                                            <div className="mt-4 space-y-2">
                                                <p>Total Beds: {ward.beds_count || 0}</p>
                                                <p>Occupied: {ward.occupied_beds_count || 0}</p>
                                                <p>Available: {(ward.beds_count || 0) - (ward.occupied_beds_count || 0)}</p>
                                            </div>
                                            <div className="mt-4 flex gap-2">
                                                <Link href={route('my-wards.beds', ward.wardNumber)} className="text-cyan-600 hover:text-cyan-900 text-sm">
                                                    Manage Beds
                                                </Link>
                                                <Link href={route('wards.edit', ward.allocationid)} className="text-cyan-600 hover:text-cyan-900 text-sm">
                                                    Edit
                                                </Link>
                                            </div>
                                        </div>
                                    ))
                                ) : (
                                    <div className="text-center text-gray-500">No wards found</div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
