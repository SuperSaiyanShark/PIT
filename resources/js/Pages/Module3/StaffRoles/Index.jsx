import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function StaffRolesIndex({ staffRoles }) {
    return (
        <AuthenticatedLayout>
            <Head title="Staff Roles" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="flex justify-between items-center mb-6">
                                <h2 className="text-2xl font-semibold">Staff Roles</h2>
                                <Link href={route('staff-roles.create')} className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700">
                                    Add Role
                                </Link>
                            </div>

                            <div className="overflow-x-auto">
                                <table className="min-w-full border-collapse border border-gray-300">
                                    <thead className="bg-gray-100">
                                        <tr>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Role Name</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Description</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Staff Count</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {staffRoles && staffRoles.length > 0 ? (
                                            staffRoles.map((role) => (
                                                <tr key={role.id}>
                                                    <td className="border border-gray-300 px-4 py-2">{role.name}</td>
                                                    <td className="border border-gray-300 px-4 py-2">{role.description}</td>
                                                    <td className="border border-gray-300 px-4 py-2">{role.staff_count || 0}</td>
                                                    <td className="border border-gray-300 px-4 py-2">
                                                        <Link href={route('staff-roles.edit', role.id)} className="text-cyan-600 hover:text-cyan-900 mr-2">
                                                            Edit
                                                        </Link>
                                                        <button className="text-red-600 hover:text-red-900">Delete</button>
                                                    </td>
                                                </tr>
                                            ))
                                        ) : (
                                            <tr>
                                                <td colSpan="4" className="border border-gray-300 px-4 py-2 text-center">
                                                    No staff roles found
                                                </td>
                                            </tr>
                                        )}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
