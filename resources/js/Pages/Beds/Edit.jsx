import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';

export default function BedsEdit({ bed, wards }) {
    const { data, setData, put, processing, errors } = useForm({
        wardid: bed.wardid || '',
        bednumber: bed.bednumber || '',
        status: bed.status || 'available',
    });

    const submit = (e) => {
        e.preventDefault();
        put(route('beds.update', bed.bedid));
    };

    return (
        <AuthenticatedLayout>
            <Head title={`Edit Bed - ${bed.bednumber}`} />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <h2 className="text-2xl font-semibold mb-6">Edit Bed</h2>

                            <form onSubmit={submit} className="space-y-6">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Ward *</label>
                                    <select
                                        value={data.wardid}
                                        onChange={(e) => setData('wardid', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    >
                                        <option value="">Select a ward</option>
                                        {wards?.map((ward) => (
                                            <option key={ward.id} value={ward.id}>
                                                {ward.name}
                                            </option>
                                        ))}
                                    </select>
                                    {errors.wardid && <div className="text-red-600 text-sm mt-1">{errors.wardid}</div>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Bed Number *</label>
                                    <input
                                        type="text"
                                        value={data.bednumber}
                                        onChange={(e) => setData('bednumber', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                    {errors.bednumber && <div className="text-red-600 text-sm mt-1">{errors.bednumber}</div>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Status</label>
                                    <select
                                        value={data.status}
                                        onChange={(e) => setData('status', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    >
                                        <option value="available">Available</option>
                                        <option value="occupied">Occupied</option>
                                        <option value="maintenance">Maintenance</option>
                                    </select>
                                    {errors.status && <div className="text-red-600 text-sm mt-1">{errors.status}</div>}
                                </div>

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700 disabled:opacity-50"
                                >
                                    Update Bed
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
