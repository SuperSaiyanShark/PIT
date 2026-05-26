import { useState } from 'react';
import { Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import InputError from '@/Components/InputError';
import { Head } from '@inertiajs/react';

export default function AdmissionCreate({ patients = [], wards = [] }) {
    const [formData, setFormData] = useState({
        patient_id: '',
        ward_id: '',
        bed_number: '',
        expected_stay_days: '',
        date_admitted: new Date().toISOString().split('T')[0],
        date_expected_leave: '',
        discharge_notes: '',
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
                            <InputLabel htmlFor="patient_id" value="Select Patient *" />
                            <select
                                id="patient_id"
                                name="patient_id"
                                className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 p-2"
                                value={formData.patient_id}
                                onChange={handleChange}
                                required
                            >
                                <option value="">Choose a patient</option>
                                {patients.map(p => (
                                    <option key={p.id} value={p.id}>
                                        {p.first_name} {p.last_name} {p.allocation_id && `(${p.allocation_id})`}
                                    </option>
                                ))}
                            </select>
                            {errors.patient_id && <InputError message={errors.patient_id} />}
                        </div>

                        {/* Ward Selection */}
                        <div>
                            <InputLabel htmlFor="ward_id" value="Ward (optional)" />
                            <select
                                id="ward_id"
                                name="ward_id"
                                className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 p-2"
                                value={formData.ward_id}
                                onChange={handleChange}
                            >
                                <option value="">Select a ward</option>
                                {wards.map(w => (
                                    <option key={w.id} value={w.id}>
                                        {w.wardname}
                                    </option>
                                ))}
                            </select>
                            {errors.ward_id && <InputError message={errors.ward_id} />}
                        </div>

                        {/* Bed Number */}
                        <div>
                            <InputLabel htmlFor="bed_number" value="Bed Number (optional)" />
                            <TextInput
                                id="bed_number"
                                name="bed_number"
                                type="text"
                                className="mt-1 block w-full"
                                value={formData.bed_number}
                                onChange={handleChange}
                                placeholder="e.g., A101"
                            />
                            {errors.bed_number && <InputError message={errors.bed_number} />}
                        </div>

                        {/* Admission Date */}
                        <div>
                            <InputLabel htmlFor="date_admitted" value="Date of Admission *" />
                            <TextInput
                                id="date_admitted"
                                name="date_admitted"
                                type="date"
                                className="mt-1 block w-full"
                                value={formData.date_admitted}
                                onChange={handleChange}
                                required
                            />
                            {errors.date_admitted && <InputError message={errors.date_admitted} />}
                        </div>

                        {/* Expected Stay Days */}
                        <div>
                            <InputLabel htmlFor="expected_stay_days" value="Expected Stay Duration (days - optional)" />
                            <TextInput
                                id="expected_stay_days"
                                name="expected_stay_days"
                                type="number"
                                min="1"
                                className="mt-1 block w-full"
                                value={formData.expected_stay_days}
                                onChange={handleChange}
                                placeholder="e.g., 5"
                            />
                            {errors.expected_stay_days && <InputError message={errors.expected_stay_days} />}
                        </div>

                        {/* Expected Leave Date */}
                        <div>
                            <InputLabel htmlFor="date_expected_leave" value="Expected Discharge Date (optional)" />
                            <TextInput
                                id="date_expected_leave"
                                name="date_expected_leave"
                                type="date"
                                className="mt-1 block w-full"
                                value={formData.date_expected_leave}
                                onChange={handleChange}
                            />
                            {errors.date_expected_leave && <InputError message={errors.date_expected_leave} />}
                        </div>

                        {/* Discharge Notes */}
                        <div>
                            <InputLabel htmlFor="discharge_notes" value="Additional Notes (optional)" />
                            <textarea
                                id="discharge_notes"
                                name="discharge_notes"
                                className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 p-2"
                                value={formData.discharge_notes}
                                onChange={handleChange}
                                placeholder="Any additional information..."
                                rows="3"
                            />
                            {errors.discharge_notes && <InputError message={errors.discharge_notes} />}
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