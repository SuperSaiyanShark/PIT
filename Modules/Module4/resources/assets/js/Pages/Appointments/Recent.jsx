import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function RecentTreatments({ appointments }) {
    return (
        <AuthenticatedLayout>
            <Head title="Recent Treatments" />

            <div className="bg-gradient-to-br from-cyan-50 to-cyan-100 min-h-screen py-12">
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white p-8 rounded-2xl shadow-lg mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div>
                            <h2 className="text-3xl font-bold leading-tight">Recent Treatments</h2>
                            <p className="text-cyan-100 mt-1">Historically compiled treatments and medical entries</p>
                        </div>
                        <Link href={route('module4.appointments.index')} className="bg-white text-cyan-600 px-6 py-3 rounded-xl font-semibold hover:bg-cyan-50 transition shadow-md">
                            View All Appointments
                        </Link>
                    </div>

                    {appointments && appointments.length > 0 ? (
                        <div className="grid grid-cols-1 gap-4">
                            {appointments.map((appointment) => (
                                <div key={appointment.id} className="bg-white rounded-2xl shadow-md p-6 border-b-4 border-cyan-500 transition hover:shadow-lg">
                                    <div className="flex justify-between items-start flex-wrap gap-4">
                                        <div className="flex-1">
                                            <h3 className="text-xl font-bold text-gray-800">{appointment.reason_for_visit}</h3>
                                            <div className="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-gray-600">
                                                <p><strong>Date:</strong> {appointment.appointment_date} at {appointment.appointment_time}</p>
                                                <p><strong>Patient Class:</strong> <span className="capitalize font-semibold text-gray-700">{appointment.patient_type}</span></p>
                                            </div>
                                        </div>
                                        <div className="text-right flex flex-col items-end gap-3">
                                            <span className={`px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wider ${
                                                appointment.status === 'completed' ? 'bg-green-100 text-green-800' :
                                                appointment.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                'bg-red-100 text-red-800'
                                            }`}>
                                                {appointment.status}
                                            </span>
                                            <Link href={route('module4.appointments.show', appointment.id)} className="text-cyan-600 font-semibold hover:text-cyan-700 text-sm flex items-center gap-1 mt-2">
                                                View Details &rarr;
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="bg-white rounded-2xl shadow-lg p-12 text-center border-b-4 border-cyan-500">
                            <p className="text-gray-600">You have no recent treatments tracked in this logs block.</p>
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}