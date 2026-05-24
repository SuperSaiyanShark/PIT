import { useState } from 'react';
import { router, Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function WardEdit({ ward }) {
    const [formData, setFormData] = useState({
        wardName: ward.wardName,
        location: ward.location || '',
        capacity: ward.capacity,
        telExtn: ward.telExtn || '',
    });
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState({});

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        setLoading(true);
        router.put(route('my-wards.update', ward.allocationid), formData, {
            onSuccess: () => {
                setLoading(false);
            },
            onError: (errors) => {
                setErrors(errors);
                setLoading(false);
            }
        });
    };

    return (
        <AuthenticatedLayout>
            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                <div className="max-w-2xl mx-auto">

                    {/* Header */}
                    <div className="mb-8">
                        <h1 className="text-3xl font-bold text-cyan-700">EDIT WARD</h1>
                        <p className="text-sm text-cyan-600 mt-1">Modify ward information</p>
                    </div>

                    {/* Back Link */}
                    <div className="mb-4">
                        <Link href={route('my-wards.index')} className="text-cyan-600 hover:text-cyan-800">
                            ← Back to Wards
                        </Link>
                    </div>

                    {/* Edit Form */}
                    <div className="bg-white rounded-lg shadow-md p-6">
                        {/* Read-only fields */}
                        <div className="mb-4 p-4 bg-gray-50 rounded-lg">
                            <p className="text-sm"><strong>Allocation ID:</strong> {ward.allocationid}</p>
                            <p className="text-sm mt-1"><strong>Ward Number:</strong> {ward.wardNumber}</p>
                        </div>

                        <form onSubmit={handleSubmit}>
                            <div className="space-y-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">Ward Name *</label>
                                    <input
                                        type="text"
                                        name="wardName"
                                        value={formData.wardName}
                                        onChange={handleChange}
                                        required
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                    />
                                    {errors.wardName && <p className="text-red-500 text-sm mt-1">{errors.wardName}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                    <input
                                        type="text"
                                        name="location"
                                        value={formData.location}
                                        onChange={handleChange}
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                    />
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">Capacity (Beds) *</label>
                                    <input
                                        type="number"
                                        name="capacity"
                                        value={formData.capacity}
                                        onChange={handleChange}
                                        required
                                        min="1"
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                    />
                                    {errors.capacity && <p className="text-red-500 text-sm mt-1">{errors.capacity}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">Telephone Extension</label>
                                    <input
                                        type="text"
                                        name="telExtn"
                                        value={formData.telExtn}
                                        onChange={handleChange}
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                    />
                                </div>
                            </div>

                            <div className="mt-6 flex gap-3">
                                <button
                                    type="submit"
                                    disabled={loading}
                                    className="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2 rounded-lg font-semibold transition"
                                >
                                    {loading ? 'Updating...' : 'Update Ward'}
                                </button>
                                <Link
                                    href={route('my-wards.index')}
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