import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';

export default function WardsCreate() {
    const { data, setData, post, processing, errors } = useForm({
        allocationid: '',
        wardNumber: '',
        wardName: '',
        location: '',
        capacity: '',
        telExtn: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('wards.store'));
    };

    return (
        <AuthenticatedLayout>
            <Head title="Create Ward" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <h2 className="text-2xl font-semibold mb-6">Create Ward</h2>

                            <form onSubmit={submit} className="space-y-6">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Allocation ID *</label>
                                    <input
                                        type="text"
                                        value={data.allocationid}
                                        onChange={(e) => setData('allocationid', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                    {errors.allocationid && <div className="text-red-600 text-sm mt-1">{errors.allocationid}</div>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Ward Number *</label>
                                    <input
                                        type="text"
                                        value={data.wardNumber}
                                        onChange={(e) => setData('wardNumber', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                    {errors.wardNumber && <div className="text-red-600 text-sm mt-1">{errors.wardNumber}</div>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Ward Name *</label>
                                    <input
                                        type="text"
                                        value={data.wardName}
                                        onChange={(e) => setData('wardName', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                    {errors.wardName && <div className="text-red-600 text-sm mt-1">{errors.wardName}</div>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Location</label>
                                    <input
                                        type="text"
                                        value={data.location}
                                        onChange={(e) => setData('location', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Capacity *</label>
                                    <input
                                        type="number"
                                        value={data.capacity}
                                        onChange={(e) => setData('capacity', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                    {errors.capacity && <div className="text-red-600 text-sm mt-1">{errors.capacity}</div>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Telephone Extension</label>
                                    <input
                                        type="text"
                                        value={data.telExtn}
                                        onChange={(e) => setData('telExtn', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                </div>

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700 disabled:opacity-50"
                                >
                                    Create Ward
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
