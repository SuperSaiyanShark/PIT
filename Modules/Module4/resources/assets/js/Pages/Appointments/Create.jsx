import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function AppointmentCreate() {
    // Reading parameter directly from current browser URL query
    const urlParams = new URLSearchParams(window.location.search);
    const typeParam = urlParams.get('type') || '';

    const { data, setData, post, errors, processing } = useForm({
        patient_type: typeParam,
        appointment_date: '',
        appointment_time: '',
        patient_id: '',
        doctor_id: '',
        reason_for_visit: '',
        notes: ''
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('module4.appointments.store'));
    };

    return (
        <AuthenticatedLayout>
            <Head title="Schedule New Appointment" />

            <div className="bg-gradient-to-br from-cyan-50 to-cyan-100 min-h-screen py-12">
                <div className="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white p-6 rounded-2xl shadow-lg mb-6 flex justify-between items-center">
                        <h2 className="text-2xl font-bold leading-tight">Schedule New Appointment</h2>
                        <span className="bg-cyan-700 px-4 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider">
                            {typeParam ? typeParam : 'Standard'}
                        </span>
                    </div>

                    <div className="bg-white rounded-2xl shadow-xl p-8 border-b-4 border-cyan-500">
                        <form onSubmit={handleSubmit} className="space-y-6">
                            
                            <div>
                                <label htmlFor="patient_type" className="block text-sm font-bold text-gray-700 mb-2">Patient Type</label>
                                <select 
                                    id="patient_type" 
                                    value={data.patient_type} 
                                    onChange={e => setData('patient_type', e.target.value)}
                                    className="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-gray-50 text-gray-900 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition"
                                >
                                    <option value="">Select patient type</option>
                                    <option value="inpatient">Inpatient</option>
                                    <option value="outpatient">Outpatient</option>
                                </select>
                                {errors.patient_type && <p className="mt-1 text-sm text-red-600">{errors.patient_type}</p>}
                            </div>

                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label htmlFor="appointment_date" className="block text-sm font-bold text-gray-700 mb-2">Appointment Date</label>
                                    <input 
                                        type="date" 
                                        id="appointment_date" 
                                        value={data.appointment_date}
                                        onChange={e => setData('appointment_date', e.target.value)}
                                        className="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-gray-50 text-gray-900 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition"
                                    />
                                    {errors.appointment_date && <p className="mt-1 text-sm text-red-600">{errors.appointment_date}</p>}
                                </div>
                                <div>
                                    <label htmlFor="appointment_time" className="block text-sm font-bold text-gray-700 mb-2">Appointment Time</label>
                                    <input 
                                        type="time" 
                                        id="appointment_time" 
                                        value={data.appointment_time}
                                        onChange={e => setData('appointment_time', e.target.value)}
                                        className="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-gray-50 text-gray-900 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition"
                                    />
                                    {errors.appointment_time && <p className="mt-1 text-sm text-red-600">{errors.appointment_time}</p>}
                                </div>
                            </div>

                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label htmlFor="patient_id" className="block text-sm font-bold text-gray-700 mb-2">Patient ID Reference</label>
                                    <input 
                                        type="number" 
                                        id="patient_id" 
                                        placeholder="e.g. 104"
                                        value={data.patient_id}
                                        onChange={e => setData('patient_id', e.target.value)}
                                        className="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-gray-50 text-gray-900 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition"
                                    />
                                    {errors.patient_id && <p className="mt-1 text-sm text-red-600">{errors.patient_id}</p>}
                                </div>
                                <div>
                                    <label htmlFor="doctor_id" className="block text-sm font-bold text-gray-700 mb-2">Assigned Doctor ID</label>
                                    <input 
                                        type="number" 
                                        id="doctor_id" 
                                        placeholder="e.g. 12"
                                        value={data.doctor_id}
                                        onChange={e => setData('doctor_id', e.target.value)}
                                        className="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-gray-50 text-gray-900 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition"
                                    />
                                    {errors.doctor_id && <p className="mt-1 text-sm text-red-600">{errors.doctor_id}</p>}
                                </div>
                            </div>

                            <div>
                                <label htmlFor="reason_for_visit" className="block text-sm font-bold text-gray-700 mb-2">Reason for Visit</label>
                                <input 
                                    type="text" 
                                    id="reason_for_visit" 
                                    placeholder="Medical concern descriptions"
                                    value={data.reason_for_visit}
                                    onChange={e => setData('reason_for_visit', e.target.value)}
                                    className="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-gray-50 text-gray-900 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition"
                                />
                                {errors.reason_for_visit && <p className="mt-1 text-sm text-red-600">{errors.reason_for_visit}</p>}
                            </div>

                            <div>
                                <label htmlFor="notes" className="block text-sm font-bold text-gray-700 mb-2">Additional Notes</label>
                                <textarea 
                                    id="notes" 
                                    rows="4" 
                                    placeholder="Any secondary symptoms or requests..."
                                    value={data.notes}
                                    onChange={e => setData('notes', e.target.value)}
                                    className="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-gray-50 text-gray-900 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition"
                                ></textarea>
                                {errors.notes && <p className="mt-1 text-sm text-red-600">{errors.notes}</p>}
                            </div>

                            <div className="flex gap-4 pt-4 border-t border-gray-100">
                                <button 
                                    type="submit" 
                                    disabled={processing}
                                    className="px-6 py-3 bg-cyan-600 text-white font-semibold rounded-xl hover:bg-cyan-700 transition shadow-md flex-1 text-center disabled:opacity-50"
                                >
                                    Schedule Appointment
                                </button>
                                <Link href={route('module4.appointments.choosePatientType')} className="px-6 py-3 bg-gray-100 text-gray-600 font-semibold rounded-xl hover:bg-gray-200 transition text-center">
                                    Back
                                </Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}