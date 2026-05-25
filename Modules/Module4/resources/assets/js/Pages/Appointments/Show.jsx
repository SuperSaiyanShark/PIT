import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function AppointmentShow({ appointment }) {
    return (
        <AuthenticatedLayout>
            <Head title={`Appointment Details - Patient #${appointment?.patient_id}`} />

            <div className="py-12">
                <div className="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div className="p-6 text-gray-900">
                            
                            {/* Header Section */}
                            <div className="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
                                <div>
                                    <h2 className="text-2xl font-semibold text-cyan-800">Appointment Details</h2>
                                    <p className="text-sm text-gray-500 mt-1">
                                        Status: <span className="px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 capitalize">{appointment?.status}</span>
                                    </p>
                                </div>
                                <Link 
                                    href={route('module4.appointments.index')} 
                                    className="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors text-sm font-medium"
                                >
                                    Back to List
                                </Link>
                            </div>

                            {/* Data Grid */}
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div className="space-y-4">
                                    <div>
                                        <h4 className="text-xs font-medium text-gray-400 uppercase tracking-wider">Patient Name / ID</h4>
                                        <p className="text-base font-medium text-gray-900">
                                            {appointment?.patient ? appointment.patient.name : `Patient ID: ${appointment?.patient_id}`}
                                        </p>
                                    </div>

                                    <div>
                                        <h4 className="text-xs font-medium text-gray-400 uppercase tracking-wider">Patient Classification</h4>
                                        <p className="text-base font-medium text-gray-900 capitalize">{appointment?.patient_type}</p>
                                    </div>
                                </div>

                                <div className="space-y-4">
                                    <div>
                                        <h4 className="text-xs font-medium text-gray-400 uppercase tracking-wider">Appointment Schedule</h4>
                                        <p className="text-base font-medium text-gray-900">
                                            {appointment?.appointment_date} at {appointment?.appointment_time}
                                        </p>
                                    </div>

                                    <div>
                                        <h4 className="text-xs font-medium text-gray-400 uppercase tracking-wider">Reason for Visit</h4>
                                        <p className="text-base font-medium text-gray-900">{appointment?.reason_for_visit}</p>
                                    </div>
                                </div>
                            </div>

                            {/* Notes Field */}
                            {appointment?.notes && (
                                <div className="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-8">
                                    <h4 className="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Clinical Notes</h4>
                                    <p className="text-sm text-gray-700 whitespace-pre-line">{appointment.notes}</p>
                                </div>
                            )}

                            {/* Action Buttons */}
                            <div className="flex gap-3 pt-4 border-t border-gray-200">
                                <Link 
                                    href={route('module4.appointments.edit', appointment?.id)} 
                                    className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700 transition-colors text-sm font-medium"
                                >
                                    Modify Appointment
                                </Link>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}