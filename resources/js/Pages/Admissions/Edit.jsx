import { useState } from 'react';
import { Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import InputError from '@/Components/InputError';
import { Head } from '@inertiajs/react';

export default function AdmissionEdit({ admission, patients = [], beds = [], staff = [] }) {
    // FIXED: Mapped state properties to match the exact database keys passed by Inertia
    const [formData, setFormData] = useState({
        Patient_no: admission.patient_no,
        BedID: admission.bedid,
        Staff_no: admission.Staff_no, // Case-sensitive capital S matching DB schema
        AdmissionDate: admission.admissiondate,
        DischargeDate: admission.dischargedate || '',
        reason: admission.reason || '',
        notes: admission.notes || '',
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
        
        // FIXED: Target 'admission.admissionid' instead of uppercase 'AdmissionID'
        router.put(route('admissions.update', admission.admissionid), formData, {
            onSuccess: () => setIsLoading(false),
            onError: (newErrors) => { setErrors(newErrors); setIsLoading(false); }
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title="Edit Admission" />
            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                <div className="mb-8 flex items-center gap-4">
                    <Link href={route('admissions.index')}>
                        <button className="text-cyan-600 hover:text-cyan-800 font-semibold">← Back to Admissions</button>
                    </Link>
                    <h1 className="text-3xl font-bold text-cyan-600">Edit Patient Admission</h1>
                </div>
                <div className="bg-white rounded-lg shadow-md p-8 max-w-2xl">
                    <form onSubmit={handleSubmit} className="space-y-6">
                        {/* Patient Selection */}
                        <div>
                            <InputLabel htmlFor="Patient_no" value="Patient *" />
                            <select 
                                id="Patient_no" 
                                name="Patient_no" 
                                className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" 
                                value={formData.Patient_no} 
                                onChange={handleChange} 
                                required
                                disabled
                            >
                                {patients.map(p => (
                                    <option key={p.patient_no} value={p.patient_no}>
                                        {p.firstname} {p.lastname}
                                    </option>
                                ))}
                            </select>
                        </div>

                        {/* Bed Selection - Admission */}
                        <div>
                            <InputLabel htmlFor="BedID" value="Admission *" />
                            <select 
                                id="BedID" 
                                name="BedID" 
                                className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" 
                                value={formData.BedID} 
                                onChange={handleChange} 
                                required
                            >
                                {beds.map(b => (
                                    <option key={b.bedid} value={b.bedid}>
                                        Admission {b.BedNumber || b.bedid}
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
                                className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" 
                                value={formData.Staff_no} 
                                onChange={handleChange} 
                                required
                            >
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

                        {/* Discharge Date */}
                        <div>
                            <InputLabel htmlFor="DischargeDate" value="Discharge Date (optional)" />
                            <TextInput 
                                id="DischargeDate" 
                                name="DischargeDate" 
                                type="date" 
                                className="mt-1 block w-full" 
                                value={formData.DischargeDate} 
                                onChange={handleChange}
                            />
                            {errors.DischargeDate && <InputError message={errors.DischargeDate} />}
                        </div>

                        {/* Admission Reason */}
                        <div>
                            <InputLabel htmlFor="reason" value="Reason for Admission *" />
                            <textarea 
                                id="reason" 
                                name="reason" 
                                className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 p-2" 
                                value={formData.reason} 
                                onChange={handleChange}
                                rows="3"
                                required
                            />
                            {errors.reason && <InputError message={errors.reason} />}
                        </div>

                        {/* Additional Notes */}
                        <div>
                            <InputLabel htmlFor="notes" value="Additional Notes (optional)" />
                            <textarea 
                                id="notes" 
                                name="notes" 
                                className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 p-2" 
                                value={formData.notes} 
                                onChange={handleChange}
                                rows="3"
                            />
                            {errors.notes && <InputError message={errors.notes} />}
                        </div>

                        {/* Form Actions */}
                        <div className="flex gap-4 pt-4 border-t">
                            <PrimaryButton disabled={isLoading}>
                                {isLoading ? 'Saving...' : 'Update Admission'}
                            </PrimaryButton>
                            <Link href={route('admissions.index')}>
                                <button type="button" className="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">Cancel</button>
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}