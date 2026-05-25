import { useState } from 'react';
import { router, Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function WardIndex({ wards }) {
    const [searchTerm, setSearchTerm] = useState('');

    const filteredWards = wards.filter(ward =>
        ward.wardName?.toLowerCase().includes(searchTerm.toLowerCase()) ||
        ward.wardNumber?.toLowerCase().includes(searchTerm.toLowerCase()) ||
        (ward.location && ward.location.toLowerCase().includes(searchTerm.toLowerCase()))
    );

    const handleDelete = (allocationid, wardName) => {
        if (confirm(`Are you sure you want to delete "${wardName}"?`)) {
            router.delete(route('my-wards.destroy', allocationid));
        }
    };

    const getOccupancyPercentage = (ward) => {
        const occupied = ward.occupied_beds_count || 0;
        const capacity = ward.capacity || 1;
        return Math.round((occupied / capacity) * 100);
    };

    return (
        <AuthenticatedLayout>
            {/* Main container with cyan gradient background */}
            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                <div className="max-w-7xl mx-auto">

                    {/* Header */}
                    <div className="mb-8">
                        <h1 className="text-3xl font-bold text-cyan-700">WARD & BED MANAGEMENT</h1>
                        <p className="text-sm text-cyan-600 mt-1">"Manage hospital wards and bed allocations"</p>
                    </div>

                    {/* Search Section */}
                    <div className="bg-white rounded-lg shadow-md p-6 mb-8">
                        <div className="flex flex-col md:flex-row gap-4 items-end">
                            <div className="flex-1 min-w-0">
                                <label className="block text-sm font-medium text-gray-700 mb-2">Search</label>
                                <input
                                    type="text"
                                    placeholder="Search by ward name, ward number, or location..."
                                    value={searchTerm}
                                    onChange={(e) => setSearchTerm(e.target.value)}
                                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                />
                            </div>
                            <Link href={route('my-wards.create')}>
                                <button className="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2 rounded-lg font-semibold">
                                    + Add New Ward
                                </button>
                            </Link>
                        </div>
                        <div className="text-gray-700 mt-4">
                            <p>Showing <span className="font-semibold text-cyan-600">{filteredWards.length}</span> of <span className="font-semibold">{wards.length}</span> wards</p>
                        </div>
                    </div>

                    {/* Wards Table */}
                    {filteredWards.length > 0 ? (
                        <div className="bg-white rounded-lg shadow-md overflow-x-auto">
                            <table className="w-full min-w-[800px]">
                                <thead className="bg-cyan-600 text-white">
                                    <tr>
                                        <th className="px-4 py-3 text-left text-sm font-semibold">Ward Name</th>
                                        <th className="px-4 py-3 text-left text-sm font-semibold">Ward Number</th>
                                        <th className="px-4 py-3 text-left text-sm font-semibold">Location</th>
                                        <th className="px-4 py-3 text-left text-sm font-semibold">Beds / Capacity</th>
                                        <th className="px-4 py-3 text-left text-sm font-semibold">Occupied</th>
                                        <th className="px-4 py-3 text-left text-sm font-semibold">Available</th>
                                        <th className="px-4 py-3 text-left text-sm font-semibold">Occupancy %</th>
                                        <th className="px-4 py-3 text-left text-sm font-semibold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200">
                                    {filteredWards.map(ward => (
                                        <tr key={ward.allocationid} className="hover:bg-gray-50">
                                            <td className="px-4 py-3 text-sm font-medium text-gray-900">{ward.wardName}</td>
                                            <td className="px-4 py-3 text-sm text-gray-600">{ward.wardNumber}</td>
                                            <td className="px-4 py-3 text-sm text-gray-600">{ward.location || 'N/A'}</td>
                                            <td className="px-4 py-3 text-sm text-gray-600">
                                                <span className="font-bold text-cyan-600">{ward.beds_count || 0}</span>
                                                <span className="text-gray-400"> / </span>
                                                <span>{ward.capacity}</span>
                                            </td>
                                            <td className="px-4 py-3 text-sm text-red-600 font-semibold">
                                                {ward.occupied_beds_count || 0}
                                            </td>
                                            <td className="px-4 py-3 text-sm text-green-600 font-semibold">
                                                {(ward.beds_count || 0) - (ward.occupied_beds_count || 0)}
                                            </td>
                                            <td className="px-4 py-3 text-sm">
                                                <div className="flex items-center gap-2">
                                                    <div className="w-16 bg-gray-200 rounded-full h-2">
                                                        <div
                                                            className="bg-cyan-600 rounded-full h-2 transition-all"
                                                            style={{ width: `${getOccupancyPercentage(ward)}%` }}
                                                        ></div>
                                                    </div>
                                                    <span className="text-xs text-gray-500 min-w-[35px]">
                                                        {getOccupancyPercentage(ward)}%
                                                    </span>
                                                </div>
                                            </td>
                                            <td className="px-4 py-3 text-sm whitespace-nowrap">
                                                <div className="flex gap-2">
                                                    <Link
                                                        href={route('my-wards.beds', ward.wardNumber)}
                                                        className="text-green-600 hover:text-green-900 font-medium text-xs"
                                                    >
                                                        View Beds
                                                    </Link>
                                                    <Link
                                                        href={route('my-wards.edit', ward.allocationid)}
                                                        className="text-blue-600 hover:text-blue-900 font-medium text-xs"
                                                    >
                                                        Edit
                                                    </Link>
                                                    <button
                                                        onClick={() => handleDelete(ward.allocationid, ward.wardName)}
                                                        className="text-red-600 hover:text-red-900 font-medium text-xs"
                                                    >
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    ) : (
                        <div className="text-center py-12 bg-white rounded-lg shadow-md">
                            <p className="text-gray-600 text-lg">No wards found matching your search.</p>
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}