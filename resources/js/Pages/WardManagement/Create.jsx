import { useState } from 'react';
import { router, Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function WardCreate() {
    const [formData, setFormData] = useState({
        allocationid: '',
        wardNumber: '',
        wardName: '',
        location: '',
        capacity: '',
        telExtn: '',
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
        router.post(route('my-wards.store'), formData, {
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

                    <div className="mb-8">
                        <h1 className="text-3xl font-bold text-cyan-700">ADD NEW WARD</h1>
                        <p className="text-sm text-cyan-600 mt-1">Register a new ward in the hospital system</p>
                    </div>

                    <div className="mb-4">
                        <Link href={route('my-wards.index')} className="text-cyan-600 hover:text-cyan-800">
                            ← Back to Wards
                        </Link>
                    </div>

                    <div className="bg-white rounded-lg shadow-md p-6">
                        <form onSubmit={handleSubmit}>
                            <div className="space-y-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">Allocation ID *</label>
                                    <input
                                        type="text"
                                        name="allocationid"
                                        value={formData.allocationid}
                                        onChange={handleChange}
                                        required
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                    />
                                    {errors.allocationid && <p className="text-red-500 text-sm mt-1">{errors.allocationid}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">Ward Number *</label>
                                    <input
                                        type="text"
                                        name="wardNumber"
                                        value={formData.wardNumber}
                                        onChange={handleChange}
                                        required
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                    />
                                    {errors.wardNumber && <p className="text-red-500 text-sm mt-1">{errors.wardNumber}</p>}
                                </div>

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
                                    {loading ? 'Creating...' : 'Create Ward'}
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