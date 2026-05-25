import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function AppointmentsIndex({ appointments }) {
    const { delete: destroy } = useForm();

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to cancel this appointment?')) {
            destroy(route('module4.appointments.destroy', id));
        }
    };

    return (
        <AuthenticatedLayout>
            <Head title="Appointments Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    
                    {/* Flash Success Message Alert */}
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div className="p-6 text-gray-900">
                            
                            {/* Heading Header Panel Actions */}
                            <div className="flex justify-between items-center mb-6">
                                <div>
                                    <h2 className="text-2xl font-semibold text-cyan-800">Patient Appointments</h2>
                                    <p className="text-sm text-gray-500">Manage, organize, and track patient clinical scheduling grids.</p>
                                </div>
                                <Link 
                                    href={route('module4.appointments.choose-patient-type')} 
                                    className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700 transition-colors text-sm font-medium"
                                >
                                    Schedule Appointment
                                </Link>
                            </div>

                            {/* Main Appointments Layout Matrix */}
                            <div className="overflow-x-auto rounded-lg border border-gray-200">
                                <table className="min-w-full divide-y divide-gray-200 bg-white text-sm">
                                    <thead className="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        <tr>
                                            <th className="px-6 py-3">Patient</th>
                                            <th className="px-6 py-3">Classification</th>
                                            <th className="px-6 py-3">Date & Time</th>
                                            <th className="px-6 py-3">Reason for Visit</th>
                                            <th className="px-6 py-3">Status</th>
                                            <th className="px-6 py-3 text-right">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody className="divide-y divide-gray-200">
                                        {appointments && appointments.length > 0 ? (
                                            appointments.map((appointment) => (
                                                <tr key={appointment.id} className="hover:bg-gray-50 transition-colors">
                                                    {/* Patient details column */}
                                                    <td className="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                                                        {appointment.patient ? appointment.patient.name : `ID: ${appointment.patient_id}`}
                                                    </td>
                                                    
                                                    {/* Inpatient / Outpatient type details column */}
                                                    <td className="whitespace-nowrap px-6 py-4 capitalize text-gray-600">
                                                        {appointment.patient_type}
                                                    </td>
                                                    
                                                    {/* Timestamp details column */}
                                                    <td className="whitespace-nowrap px-6 py-4 text-gray-600">
                                                        {appointment.appointment_date} <span className="text-gray-400 text-xs">@ {appointment.appointment_time}</span>
                                                    </td>
                                                    
                                                    {/* Shortened reason column text validation */}
                                                    <td className="px-6 py-4 text-gray-600 max-w-xs truncate">
                                                        {appointment.reason_for_visit}
                                                    </td>
                                                    
                                                    {/* Status custom stylized contextual badges column layout */}
                                                    <td className="whitespace-nowrap px-6 py-4">
                                                        <span className={`inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize ${
                                                            appointment.status === 'completed' ? 'bg-green-100 text-green-800' :
                                                            appointment.status === 'cancelled' ? 'bg-red-100 text-red-800' :
                                                            'bg-yellow-100 text-yellow-800'
                                                        }`}>
                                                            {appointment.status}
                                                        </span>
                                                    </td>
                                                    
                                                    {/* Functional navigation anchor point paths links operations controls */}
                                                    <td className="whitespace-nowrap px-6 py-4 text-right text-sm font-medium space-x-3">
                                                        <Link 
                                                            href={route('module4.appointments.show', appointment.id)} 
                                                            className="text-cyan-600 hover:text-cyan-900"
                                                        >
                                                            View
                                                        </Link>
                                                        <Link 
                                                            href={route('module4.appointments.edit', appointment.id)} 
                                                            className="text-gray-600 hover:text-gray-900"
                                                        >
                                                            Edit
                                                        </Link>
                                                        <button 
                                                            onClick={() => handleDelete(appointment.id)}
                                                            className="text-red-600 hover:text-red-900 bg-none border-none cursor-pointer"
                                                        >
                                                            Cancel
                                                        </button>
                                                    </td>
                                                </tr>
                                            ))
                                        ) : (
                                            <tr>
                                                <td colSpan="6" className="px-6 py-12 text-center text-gray-500 bg-gray-50">
                                                    No scheduled patient appointments found in the system.
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