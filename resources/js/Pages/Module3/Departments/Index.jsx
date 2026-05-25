import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function DepartmentsIndex({ departments }) {
    return (
        <AuthenticatedLayout>
            <Head title="Departments" />
            
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="flex justify-between items-center mb-6">
                                <h2 className="text-2xl font-semibold">Departments</h2>
                                <Link href={route('departments.create')} className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700">
                                    Add Department
                                </Link>
                            </div>

                            <div className="overflow-x-auto">
                                <table className="min-w-full border-collapse border border-gray-300">
                                    <thead className="bg-gray-100">
                                        <tr>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Name</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Description</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Building</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Phone</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {departments && departments.length > 0 ? (
                                            departments.map((dept) => (
                                                <tr key={dept.id}>
                                                    <td className="border border-gray-300 px-4 py-2">{dept.name}</td>
                                                    <td className="border border-gray-300 px-4 py-2">{dept.description}</td>
                                                    <td className="border border-gray-300 px-4 py-2">{dept.building}</td>
                                                    <td className="border border-gray-300 px-4 py-2">{dept.phone}</td>
                                                    <td className="border border-gray-300 px-4 py-2">
                                                        <Link href={route('departments.edit', dept.id)} className="text-cyan-600 hover:text-cyan-900 mr-2">
                                                            Edit
                                                        </Link>
                                                        <button className="text-red-600 hover:text-red-900">Delete</button>
                                                    </td>
                                                </tr>
                                            ))
                                        ) : (
                                            <tr>
                                                <td colSpan="5" className="border border-gray-300 px-4 py-2 text-center">
                                                    No departments found
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
