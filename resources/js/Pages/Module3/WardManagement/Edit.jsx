import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';

export default function WardsEdit({ ward, departments, heads }) {
    const { data, setData, put, processing, errors } = useForm({
        name: ward.name || '',
        department_id: ward.department_id || '',
        floor: ward.floor || '',
        capacity: ward.capacity || '',
        ward_head_id: ward.ward_head_id || '',
    });

    const submit = (e) => {
        e.preventDefault();
        put(route('wards.update', ward.id));
    };

    return (
        <AuthenticatedLayout>
            <Head title={`Edit Ward - ${ward.name}`} />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <h2 className="text-2xl font-semibold mb-6">Edit Ward</h2>

                            <form onSubmit={submit} className="space-y-6">
                                {/* Ward Name */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Ward Name *</label>
                                    <input
                                        type="text"
                                        value={data.name}
                                        onChange={(e) => setData('name', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                        placeholder="e.g. Intensive Care Unit"
                                    />
                                    {errors.name && <div className="text-red-600 text-sm mt-1">{errors.name}</div>}
                                </div>

                                {/* Department Selector */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Department *</label>
                                    <select
                                        value={data.department_id}
                                        onChange={(e) => setData('department_id', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    >
                                        <option value="">Select Department</option>
                                        {departments?.map((dept) => (
                                            <option key={dept.id} value={dept.id}>
                                                {dept.name}
                                            </option>
                                        ))}
                                    </select>
                                    {errors.department_id && <div className="text-red-600 text-sm mt-1">{errors.department_id}</div>}
                                </div>

                                {/* Floor */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Floor</label>
                                    <input
                                        type="number"
                                        value={data.floor}
                                        onChange={(e) => setData('floor', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                        placeholder="e.g. 3"
                                    />
                                    {errors.floor && <div className="text-red-600 text-sm mt-1">{errors.floor}</div>}
                                </div>

                                {/* Capacity */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Capacity *</label>
                                    <input
                                        type="number"
                                        value={data.capacity}
                                        onChange={(e) => setData('capacity', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                        placeholder="e.g. 15"
                                    />
                                    {errors.capacity && <div className="text-red-600 text-sm mt-1">{errors.capacity}</div>}
                                </div>

                                {/* Ward Head Selector */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Ward Head (Optional)</label>
                                    <select
                                        value={data.ward_head_id}
                                        onChange={(e) => setData('ward_head_id', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    >
                                        <option value="">Select Ward Head</option>
                                        {heads?.map((head) => (
                                            <option key={head.id} value={head.id}>
                                                {head.name} - {head.staffRole?.name || 'No Role'}
                                            </option>
                                        ))}
                                    </select>
                                    {errors.ward_head_id && <div className="text-red-600 text-sm mt-1">{errors.ward_head_id}</div>}
                                </div>

                                <div className="flex flex-col space-y-4">
                                    <div>
                                        <button
                                            type="submit"
                                            disabled={processing}
                                            className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700 disabled:opacity-50 transition-colors"
                                        >
                                            {processing ? 'Updating...' : 'Update Ward'}
                                        </button>
                                    </div>

                                    {/* DYNAMIC ERROR SUMMARY BANNER */}
                                    {Object.keys(errors).length > 0 && (
                                        <div className="p-4 bg-red-50 text-red-700 rounded border border-red-200">
                                            <p className="font-semibold">Please resolve the following submission errors:</p>
                                            <ul className="list-disc pl-5 mt-1 text-sm">
                                                {Object.keys(errors).map((key) => (
                                                    <li key={key}>{errors[key]}</li>
                                                ))}
                                            </ul>
                                        </div>
                                    )}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
