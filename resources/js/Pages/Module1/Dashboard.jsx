import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Dashboard({ totalDepartments = 0, totalStaff = 0, totalPatients = 0, totalWards = 0 }) {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Appointment and Treatment Module
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="w-full">
                <div>
                    {/* Main Title */}
                    <div className="mb-8 px-4 sm:px-6 lg:px-8">
                        <h1 className="text-3xl font-bold text-gray-900">Staff & Patient Management</h1>
                    </div>

                    {/* Statistics Cards */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12 px-4 sm:px-6 lg:px-8">
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-gray-600 text-sm font-medium">Total Staff</p>
                                    <p className="text-3xl font-bold text-blue-600 mt-2">{totalStaff}</p>
                                </div>
                                <svg className="w-12 h-12 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 6a3 3 0 11-6 0 3 3 0 016 0zm0 0h6m-6 0h6m-6 0a3 3 0 11-6 0 3 3 0 016 0zm9-6h6a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path d="M17 16h2a1 1 0 100-2h-2.382l-.447-2.236A2 2 0 0014.414 12H5.586a2 2 0 00-1.757 1.764l-.447 2.236H2a1 1 0 100 2h2z"></path>
                                </svg>
                            </div>
                        </div>

                        <div className="bg-white rounded-lg shadow-md p-6">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-gray-600 text-sm font-medium">Total Patients</p>
                                    <p className="text-3xl font-bold text-green-600 mt-2">{totalPatients}</p>
                                </div>
                                <svg className="w-12 h-12 text-green-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fillRule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clipRule="evenodd"></path>
                                </svg>
                            </div>
                        </div>

                        <div className="bg-white rounded-lg shadow-md p-6">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-gray-600 text-sm font-medium">Departments</p>
                                    <p className="text-3xl font-bold text-purple-600 mt-2">{totalDepartments}</p>
                                </div>
                                <svg className="w-12 h-12 text-purple-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                            </div>
                        </div>

                        <div className="bg-white rounded-lg shadow-md p-6">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-gray-600 text-sm font-medium">Wards</p>
                                    <p className="text-3xl font-bold text-red-600 mt-2">{totalWards}</p>
                                </div>
                                <svg className="w-12 h-12 text-red-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.5 1.5H5.75A2.75 2.75 0 003 4.25v11A2.75 2.75 0 005.75 18h8.5A2.75 2.75 0 0017 15.25v-11A2.75 2.75 0 0014.25 1.5h-3.75m0 0V.75a.75.75 0 00-1.5 0v.75m0 0h1.5"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {/* Staff Management Section */}
                    <div className="mb-12 px-4 sm:px-6 lg:px-8">
                        <h2 className="text-2xl font-bold text-gray-900 mb-6">Staff Management</h2>
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <Link href={route('staff.index')}>
                                <div className="bg-white rounded-lg shadow-md p-8 hover:shadow-lg transition-shadow cursor-pointer">
                                    <div className="bg-blue-50 text-blue-600 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                                        <svg className="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 6a3 3 0 11-6 0 3 3 0 016 0zm0 0h6m-6 0h6m-6 0a3 3 0 11-6 0 3 3 0 016 0zm9-6h6a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path d="M17 16h2a1 1 0 100-2h-2.382l-.447-2.236A2 2 0 0014.414 12H5.586a2 2 0 00-1.757 1.764l-.447 2.236H2a1 1 0 100 2h2z"></path>
                                        </svg>
                                    </div>
                                    <h3 className="text-lg font-semibold text-gray-900 mb-2 text-center">Manage Staff</h3>
                                    <p className="text-gray-600 text-sm text-center">View, create, and manage staff members</p>
                                </div>
                            </Link>

                            <Link href={route('staff.index')}>
                                <div className="bg-white rounded-lg shadow-md p-8 hover:shadow-lg transition-shadow cursor-pointer">
                                    <div className="bg-yellow-50 text-yellow-600 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                                        <svg className="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM16 15a2 2 0 114 0v2h-4v-2z"></path>
                                        </svg>
                                    </div>
                                    <h3 className="text-lg font-semibold text-gray-900 mb-2 text-center">Staff by Role</h3>
                                    <p className="text-gray-600 text-sm text-center">Filter staff members by job roles</p>
                                </div>
                            </Link>

                            <Link href={route('staff.index')}>
                                <div className="bg-white rounded-lg shadow-md p-8 hover:shadow-lg transition-shadow cursor-pointer">
                                    <div className="bg-green-50 text-green-600 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                                        <svg className="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            <path fillRule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clipRule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h3 className="text-lg font-semibold text-gray-900 mb-2 text-center">Staff Statistics</h3>
                                    <p className="text-gray-600 text-sm text-center">View staff analytics and reports</p>
                                </div>
                            </Link>
                        </div>
                    </div>

                    {/* More Management Options */}
                    <div className="mb-12 px-4 sm:px-6 lg:px-8">
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <Link href={route('staff.index')}>
                                <div className="bg-white rounded-lg shadow-md p-8 hover:shadow-lg transition-shadow cursor-pointer">
                                    <div className="bg-purple-50 text-purple-600 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                                        <svg className="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                            <path fillRule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V5a1 1 0 100 2 1 1 0 011 1v1a1 1 0 100 2V6a3 3 0 00-3-3H4zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h3 className="text-lg font-semibold text-gray-900 mb-2 text-center">Schedules</h3>
                                    <p className="text-gray-600 text-sm text-center">Manage staff schedules and shifts</p>
                                </div>
                            </Link>

                            <Link href={route('responsibilities.index')}>
                                <div className="bg-white rounded-lg shadow-md p-8 hover:shadow-lg transition-shadow cursor-pointer">
                                    <div className="bg-pink-50 text-pink-600 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                                        <svg className="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h3 className="text-lg font-semibold text-gray-900 mb-2 text-center">Responsibilities</h3>
                                    <p className="text-gray-600 text-sm text-center">Assign and manage staff duties</p>
                                </div>
                            </Link>

                            <Link href={route('staff.index')}>
                                <div className="bg-white rounded-lg shadow-md p-8 hover:shadow-lg transition-shadow cursor-pointer">
                                    <div className="bg-red-50 text-red-600 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                                        <svg className="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            <path fillRule="evenodd" d="M4 4a2 2 0 00-2 2v4a1 1 0 001 1h12a1 1 0 001-1V6a2 2 0 00-2-2H4zm12 4V6a2 2 0 00-2-2H4a2 2 0 00-2 2v2h12z" clipRule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h3 className="text-lg font-semibold text-gray-900 mb-2 text-center">Staff Roles</h3>
                                    <p className="text-gray-600 text-sm text-center">Configure job roles and positions</p>
                                </div>
                            </Link>
                        </div>
                    </div>

                    {/* Patient Management Section */}
                    <div className="px-4 sm:px-6 lg:px-8">
                        <h2 className="text-2xl font-bold text-gray-900 mb-6">Patient Management</h2>
                        <div className="bg-white rounded-lg shadow-md p-12">
                            <div className="text-center">
                                <svg className="w-16 h-16 text-gray-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fillRule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clipRule="evenodd"></path>
                                </svg>
                                <h3 className="text-lg font-semibold text-gray-900 mb-2">Patient Records</h3>
                                <p className="text-gray-600 mb-6">Manage patient admissions, medical records, and allocations</p>
                                <Link href={route('patients.index')}>
                                    <button className="bg-cyan-600 text-white px-8 py-3 rounded-lg hover:bg-cyan-700 transition-colors">
                                        View Patients
                                    </button>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}