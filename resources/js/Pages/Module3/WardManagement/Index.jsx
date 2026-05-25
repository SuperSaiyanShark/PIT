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
                                <Link href={route('wards.create')} className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700 transition-colors">
                                    Add Ward
                                </Link>
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                {wards && wards.length > 0 ? (
                                    wards.map((ward) => (
                                        // FIXED: Changed key from allocationid to id
                                        <div key={ward.id} className="border border-gray-300 rounded-lg p-4 bg-gray-50 flex flex-col justify-between">
                                            <div>
                                                {/* FIXED: Changed wardName to name */}
                                                <h3 className="text-lg font-semibold text-cyan-800">{ward.name}</h3>
                                                
                                                {/* FIXED: Replaced custom layout with database fields (Department & Floor) */}
                                                <p className="text-xs font-medium uppercase tracking-wider text-gray-400 mt-0.5">
                                                    {ward.department?.name || 'No Department'}
                                                </p>
                                                
                                                <div className="mt-4 space-y-2 text-sm text-gray-700">
                                                    <div className="flex justify-between items-center">
                                                        <span className="font-medium text-gray-500">Floor:</span>
                                                        <span>{ward.floor !== null ? ward.floor : 'N/A'}</span>
                                                    </div>
                                                    <div className="flex justify-between items-center">
                                                        <span className="font-medium text-gray-500">Max Capacity:</span>
                                                        <span>{ward.capacity || 'N/A'}</span>
                                                    </div>
                                                    <div className="flex justify-between items-start">
                                                        <span className="font-medium text-gray-500">Ward Head:</span>
                                                        <span className={`px-3 py-1 rounded-full text-xs font-semibold ${ward.head?.id ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600'}`}>
                                                            {ward.head?.name || 'Unassigned'}
                                                        </span>
                                                    </div>
                                                    <div className="flex justify-between items-center">
                                                        <span className="font-medium text-gray-500">Assigned Staff:</span>
                                                        <span className="bg-cyan-100 text-cyan-800 px-3 py-1 rounded-full text-xs font-semibold">{ward.staff?.length || 0} active</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div className="mt-6 pt-3 border-t border-gray-200 flex gap-4">
                                                {/* FIXED: Changed route parameter from ward.wardNumber to ward.id to satisfy Ziggy */}
                                                <Link href={route('my-wards.beds', ward.id)} className="text-cyan-600 hover:text-cyan-900 text-sm font-medium">
                                                    Manage Beds
                                                </Link>
                                                
                                                {/* FIXED: Changed route parameter from ward.allocationid to ward.id */}
                                                <Link href={route('wards.edit', ward.id)} className="text-gray-600 hover:text-gray-900 text-sm font-medium">
                                                    Edit
                                                </Link>
                                            </div>
                                        </div>
                                    ))
                                ) : (
                                    <div className="col-span-full p-12 text-center text-gray-500 border border-dashed border-gray-300 rounded-lg bg-gray-50">
                                        No wards found in the database.
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}