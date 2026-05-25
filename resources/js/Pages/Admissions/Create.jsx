import { useState } from 'react';
import { Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import InputError from '@/Components/InputError';
import { Head } from '@inertiajs/react';

export default function AdmissionCreate({ patients = [], beds = [], staff = [] }) {
    const [formData, setFormData] = useState({
        Patient_no: '',
        BedID: '',
        Staff_no: '',
        AdmissionDate: new Date().toISOString().split('T')[0],
        reason: '',
        notes: '',
    });
    const [errors, setErrors] = useState({});
    const [isLoading, setIsLoading] = useState(false);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
        if (errors[name]) setErrors(prev => ({ ...prev, [name]: '' }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        setIsLoading(true);
        router.post(route('admissions.store'), formData, {
            onSuccess: () => setIsLoading(false),
            onError: (newErrors) => { setErrors(newErrors); setIsLoading(false); }
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title="Admit Patient" />
            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                <div className="mb-8 flex items-center gap-4">
                    <Link href={route('admissions.index')}>
                        <button className="text-cyan-600 hover:text-cyan-800 font-semibold">← Back to Admissions</button>
                    </Link>
                    <h1 className="text-3xl font-bold text-cyan-600">Admit Patient to Hospital</h1>
                </div>
                <div className="bg-white rounded-lg shadow-md p-8 max-w-2xl">
                    <form onSubmit={handleSubmit} className="space-y-6">

                        {/* Patient Selection */}
                        <div>
                            <InputLabel htmlFor="Patient_no" value="Select Patient *" />
                            <select
                                id="Patient_no"
                                name="Patient_no"
                                className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 p-2"
                                value={formData.Patient_no}
                                onChange={handleChange}
                                required
                            >
                                <option value="">Choose a patient</option>
                                {patients.map(p => (
                                    <option key={p.patient_no} value={p.patient_no}>
                                        {p.firstname} {p.lastname} (ID: {p.patient_no})
                                    </option>
                                ))}
                            </select>
                            {errors.Patient_no && <InputError message={errors.Patient_no} />}
                        </div>

                        {/* Bed Selection */}
                        <div>
                            <InputLabel htmlFor="BedID" value="Bed *" />
                            <select
                                id="BedID"
                                name="BedID"
                                className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 p-2"
                                value={formData.BedID}
                                onChange={handleChange}
                                required
                            >
                                <option value="">Select a bed</option>
                                {beds.map(b => (
                                    <option key={b.bedid} value={b.bedid}>
                                        Bed {b.bednumber} — Ward: {b.ward?.wardname ?? 'N/A'} (Status: {b.status})
                                    </option>
                                ))}
                            </select>
                            {errors.BedID && <InputError message={errors.BedID} />}
                        </div>

                        {/* Staff Assignment */}
                        <div>
                            <InputLabel htmlFor="Staff_no" value="Assigned Staff *" />
                            <select
                                id="Staff_no"
                                name="Staff_no"
                                className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 p-2"
                                value={formData.Staff_no}
                                onChange={handleChange}
                                required
                            >
                                <option value="">Select staff member</option>
                                {staff.map(s => (
                                    <option key={s.id} value={s.id}>
                                        {s.name} ({s.role})
                                    </option>
                                ))}
                            </select>
                            {errors.Staff_no && <InputError message={errors.Staff_no} />}
                        </div>

                        {/* Admission Date */}
                        <div>
                            <InputLabel htmlFor="AdmissionDate" value="Admission Date *" />
                            <TextInput
                                id="AdmissionDate"
                                name="AdmissionDate"
                                type="date"
                                className="mt-1 block w-full"
                                value={formData.AdmissionDate}
                                onChange={handleChange}
                                required
                            />
                            {errors.AdmissionDate && <InputError message={errors.AdmissionDate} />}
                        </div>

                        {/* Reason */}
                        <div>
                            <InputLabel htmlFor="reason" value="Reason for Admission *" />
                            <textarea
                                id="reason"
                                name="reason"
                                className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 p-2"
                                value={formData.reason}
                                onChange={handleChange}
                                placeholder="e.g., Post-surgical observation, Recovery, etc."
                                rows="3"
                                required
                            />
                            {errors.reason && <InputError message={errors.reason} />}
                        </div>

                        {/* Notes */}
                        <div>
                            <InputLabel htmlFor="notes" value="Additional Notes (optional)" />
                            <textarea
                                id="notes"
                                name="notes"
                                className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 p-2"
                                value={formData.notes}
                                onChange={handleChange}
                                placeholder="Any additional information..."
                                rows="3"
                            />
                            {errors.notes && <InputError message={errors.notes} />}
                        </div>

                        {/* Actions */}
                        <div className="flex gap-4 pt-4 border-t">
                            <PrimaryButton type="submit" disabled={isLoading}>
                                {isLoading ? 'Admitting...' : 'ADMIT PATIENT'}
                            </PrimaryButton>
                            <Link href={route('admissions.index')}>
                                <button type="button" className="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                                    Cancel
                                </button>
                            </Link>
                        </div>

                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}