import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';

export default function StaffRolesCreate() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        description: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('staff-roles.store'));
    };

    return (
        <AuthenticatedLayout>
            <Head title="Create Staff Role" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <h2 className="text-2xl font-semibold mb-6">Create Staff Role</h2>

                            <form onSubmit={submit} className="space-y-6">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Role Name *</label>
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

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700 disabled:opacity-50"
                                >
                                    Create Role
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
