import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';

export default function DepartmentsCreate({ heads }) {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        description: '',
        head_id: '',
        building: '',
        phone: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('departments.store'));
    };

    return (
        <AuthenticatedLayout>
            <Head title="Create Department" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <h2 className="text-2xl font-semibold mb-6">Create Department</h2>

                            <form onSubmit={submit} className="space-y-6">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Name *</label>
                                    <input
                                        type="text"
                                        value={data.name}
                                        onChange={(e) => setData('name', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                    {errors.name && <div className="text-red-600 text-sm mt-1">{errors.name}</div>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea
                                        value={data.description}
                                        onChange={(e) => setData('description', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Head</label>
                                    <select
                                        value={data.head_id}
                                        onChange={(e) => setData('head_id', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    >
                                        <option value="">Select a head</option>
                                        {heads?.map((head) => (
                                            <option key={head.id} value={head.id}>
                                                {head.name}
                                            </option>
                                        ))}
                                    </select>
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Building</label>
                                    <input
                                        type="text"
                                        value={data.building}
                                        onChange={(e) => setData('building', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Phone</label>
                                    <input
                                        type="text"
                                        value={data.phone}
                                        onChange={(e) => setData('phone', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                </div>

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700 disabled:opacity-50"
                                >
                                    Create Department
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
