import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function StaffRolesShow({ staffRole }) {
    return (
        <AuthenticatedLayout>
            <Head title={`Staff Role - ${staffRole.name}`} />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="flex justify-between items-center mb-6">
                                <h2 className="text-2xl font-semibold">{staffRole.name}</h2>
                                <Link href={route('staff-roles.edit', staffRole.id)} className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700">
                                    Edit
                                </Link>
                            </div>

                            <div className="space-y-4">
                                <div>
                                    <label className="font-semibold">Description</label>
                                    <p>{staffRole.description || 'N/A'}</p>
                                </div>

                                <div>
                                    <label className="font-semibold">Staff Members</label>
                                    {staffRole.staff && staffRole.staff.length > 0 ? (
                                        <ul className="list-disc pl-5">
                                            {staffRole.staff.map((member) => (
                                                <li key={member.id}>{member.name}</li>
                                            ))}
                                        </ul>
                                    ) : (
                                        <p>No staff members assigned</p>
                                    )}
                                </div>
                            </div>

                            <div className="mt-6">
                                <Link href={route('staff-roles.index')} className="text-cyan-600 hover:text-cyan-900">
                                    Back to Roles
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
