import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Dashboard() {

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Appointments & Treatment Dashboard
                </h2>
            }
        >
            <Head title="Appointments Dashboard" />

            <div className="w-full">
                <div>
                    {/* Main Title */}
                    <div className="mb-8">
                        <h1 className="text-3xl font-bold text-gray-900">Appointments & Treatments Management</h1>
                    </div>

                    {/* Quick Actions Cards */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                        <Link href={route('module4.appointments.index')}>
                            <div className="bg-white rounded-lg shadow-md p-8 hover:shadow-lg transition-shadow cursor-pointer">
                                <div className="bg-blue-50 text-blue-600 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                                    <svg className="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.5 1.5H5.75A2.75 2.75 0 003 4.25v11.5A2.75 2.75 0 005.75 18.5h8.5a2.75 2.75 0 002.75-2.75V4.25a2.75 2.75 0 00-2.75-2.75zm-3.75 6h6m-6 4h6m-6 4h3"></path>
                                    </svg>
                                </div>
                                <h3 className="text-lg font-semibold text-gray-900 mb-2 text-center">View Appointments</h3>
                                <p className="text-gray-600 text-sm text-center">Browse and manage all scheduled appointments</p>
                            </div>
                        </Link>

                        <Link href={route('module4.appointments.create')}>
                            <div className="bg-white rounded-lg shadow-md p-8 hover:shadow-lg transition-shadow cursor-pointer">
                                <div className="bg-green-50 text-green-600 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                                    <svg className="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path fillRule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clipRule="evenodd"></path>
                                    </svg>
                                </div>
                                <h3 className="text-lg font-semibold text-gray-900 mb-2 text-center">Create Appointment</h3>
                                <p className="text-gray-600 text-sm text-center">Schedule a new appointment for a patient</p>
                            </div>
                        </Link>

                        <Link href={route('module4.appointments.recent')}>
                            <div className="bg-white rounded-lg shadow-md p-8 hover:shadow-lg transition-shadow cursor-pointer">
                                <div className="bg-purple-50 text-purple-600 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                                    <svg className="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path fillRule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clipRule="evenodd"></path>
                                    </svg>
                                </div>
                                <h3 className="text-lg font-semibold text-gray-900 mb-2 text-center">Recent Appointments</h3>
                                <p className="text-gray-600 text-sm text-center">View recently updated appointments</p>
                            </div>
                        </Link>
                    </div>

                    {/* Information Section */}
                    <div className="bg-white rounded-lg shadow-md p-8 mb-8">
                        <h2 className="text-2xl font-bold text-gray-900 mb-6">Appointments & Treatment Module</h2>
                        <p className="text-gray-600 mb-4">
                            Welcome to the Appointments & Treatment Management system. This module allows you to:
                        </p>
                        <ul className="space-y-2 text-gray-600 mb-6 ml-4">
                            <li className="flex items-start">
                                <svg className="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd"></path>
                                </svg>
                                <span>Schedule and manage patient appointments</span>
                            </li>
                            <li className="flex items-start">
                                <svg className="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd"></path>
                                </svg>
                                <span>Track and manage patient treatments</span>
                            </li>
                            <li className="flex items-start">
                                <svg className="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd"></path>
                                </svg>
                                <span>Assign treatments to appointments</span>
                            </li>
                            <li className="flex items-start">
                                <svg className="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd"></path>
                                </svg>
                                <span>Monitor appointment and treatment statuses</span>
                            </li>
                        </ul>
                        <Link href={route('module4.appointments.index')}>
                            <button className="bg-cyan-600 text-white px-6 py-2 rounded-lg hover:bg-cyan-700 transition-colors">
                                Get Started
                            </button>
                        </Link>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
