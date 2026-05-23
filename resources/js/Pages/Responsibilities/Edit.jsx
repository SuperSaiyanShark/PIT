import { useState } from 'react';
import { Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import InputError from '@/Components/InputError';
import { Head } from '@inertiajs/react';

export default function ResponsibilitiesEdit({ responsibility, staff = [], departments = [], wards = [] }) {
    const [formData, setFormData] = useState({
        staff_id: responsibility.staff_id || '',
        responsibility_type: responsibility.responsibility_type || '',
        description: responsibility.description || '',
        department_id: responsibility.department_id || '',
        ward_id: responsibility.ward_id || '',
        patient_id: responsibility.patient_id || '',
        status: responsibility.status || 'active',
        start_date: responsibility.start_date || '',
        end_date: responsibility.end_date || '',
    });

    const [errors, setErrors] = useState({});
    const [isLoading, setIsLoading] = useState(false);

    const responsibilityTypes = [
        'Patient Monitoring',
        'Medication Administration',
        'Wound Care',
        'Physical Therapy',
        'Patient Education',
        'Lab Work',
        'Ward Rounds',
        'Documentation',
        'Emergency Response',
        'Patient Admission',
        'Patient Discharge',
        'Surgery Support',
        'Anesthesia Support',
        'Nursing Care',
        'Administrative Tasks',
        'Other'
    ];

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
        if (errors[name]) {
            setErrors(prev => ({ ...prev, [name]: '' }));
        }
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        setIsLoading(true);

        router.put(route('responsibilities.update', responsibility.id), formData, {
            onSuccess: () => {
                setIsLoading(false);
            },
            onError: (newErrors) => {
                setErrors(newErrors);
                setIsLoading(false);
            }
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title="Edit Responsibility" />

            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                {/* Header */}
                <div className="mb-8">
                    <div className="flex items-center gap-4">
                        <Link href={route('responsibilities.index')}>
                            <button className="text-cyan-600 hover:text-cyan-800 font-semibold">
                                ← Back to Responsibilities
                            </button>
                        </Link>
                        <h1 className="text-3xl font-bold text-cyan-600">Edit Responsibility</h1>
                    </div>
                </div>

                {/* Form Container */}
                <div className="bg-white rounded-lg shadow-md p-8 max-w-4xl">
                    <form onSubmit={handleSubmit} className="space-y-6">
                        {/* Row 1: Staff and Type */}
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {/* Staff Member */}
                            <div>
                                <InputLabel htmlFor="staff_id" value="Staff Member *" />
                                <select
                                    id="staff_id"
                                    name="staff_id"
                                    className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                    value={formData.staff_id}
                                    onChange={handleChange}
                                    required
                                >
                                    <option value="">Select a staff member</option>
                                    {staff.map(s => (
                                        <option key={s.id} value={s.id}>
                                            {s.name} ({s.role})
                                        </option>
                                    ))}
                                </select>
                                {errors.staff_id && <InputError message={errors.staff_id} />}
                            </div>

                            {/* Responsibility Type */}
                            <div>
                                <InputLabel htmlFor="responsibility_type" value="Responsibility Type *" />
                                <select
                                    id="responsibility_type"
                                    name="responsibility_type"
                                    className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                    value={formData.responsibility_type}
                                    onChange={handleChange}
                                    required
                                >
                                    <option value="">Select responsibility type</option>
                                    {responsibilityTypes.map(type => (
                                        <option key={type} value={type}>{type}</option>
                                    ))}
                                </select>
                                {errors.responsibility_type && <InputError message={errors.responsibility_type} />}
                            </div>
                        </div>

                        {/* Row 2: Description */}
                        <div>
                            <InputLabel htmlFor="description" value="Description *" />
                            <textarea
                                id="description"
                                name="description"
                                className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                rows="4"
                                value={formData.description}
                                onChange={handleChange}
                                placeholder="Detailed description of the responsibility, tasks, and patient care requirements..."
                                required
                            />
                            {errors.description && <InputError message={errors.description} />}
                        </div>

                        {/* Row 3: Department and Ward */}
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {/* Department */}
                            <div>
                                <InputLabel htmlFor="department_id" value="Department" />
                                <select
                                    id="department_id"
                                    name="department_id"
                                    className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                    value={formData.department_id}
                                    onChange={handleChange}
                                >
                                    <option value="">Select department (optional)</option>
                                    {departments.map(d => (
                                        <option key={d.id} value={d.id}>{d.name}</option>
                                    ))}
                                </select>
                                {errors.department_id && <InputError message={errors.department_id} />}
                            </div>

                            {/* Ward */}
                            <div>
                                <InputLabel htmlFor="ward_id" value="Ward" />
                                <select
                                    id="ward_id"
                                    name="ward_id"
                                    className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                    value={formData.ward_id}
                                    onChange={handleChange}
                                >
                                    <option value="">Select ward (optional)</option>
                                    {wards.map(w => (
                                        <option key={w.id} value={w.id}>{w.name}</option>
                                    ))}
                                </select>
                                {errors.ward_id && <InputError message={errors.ward_id} />}
                            </div>
                        </div>

                        {/* Row 4: Dates and Status */}
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {/* Start Date */}
                            <div>
                                <InputLabel htmlFor="start_date" value="Start Date" />
                                <TextInput
                                    id="start_date"
                                    name="start_date"
                                    type="date"
                                    className="mt-1 block w-full"
                                    value={formData.start_date}
                                    onChange={handleChange}
                                />
                                {errors.start_date && <InputError message={errors.start_date} />}
                            </div>

                            {/* End Date */}
                            <div>
                                <InputLabel htmlFor="end_date" value="End Date" />
                                <TextInput
                                    id="end_date"
                                    name="end_date"
                                    type="date"
                                    className="mt-1 block w-full"
                                    value={formData.end_date}
                                    onChange={handleChange}
                                    min={formData.start_date}
                                />
                                {errors.end_date && <InputError message={errors.end_date} />}
                            </div>

                            {/* Status */}
                            <div>
                                <InputLabel htmlFor="status" value="Status" />
                                <select
                                    id="status"
                                    name="status"
                                    className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                    value={formData.status}
                                    onChange={handleChange}
                                >
                                    <option value="active">Active</option>
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                    <option value="on-hold">On Hold</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                {errors.status && <InputError message={errors.status} />}
                            </div>
                        </div>

                        {/* Row 5: Patient ID (Optional) */}
                        <div>
                            <InputLabel htmlFor="patient_id" value="Patient ID (Optional)" />
                            <TextInput
                                id="patient_id"
                                name="patient_id"
                                type="text"
                                className="mt-1 block w-full"
                                value={formData.patient_id}
                                onChange={handleChange}
                                placeholder="Patient identification if applicable"
                            />
                            {errors.patient_id && <InputError message={errors.patient_id} />}
                        </div>

                        {/* Buttons */}
                        <div className="flex gap-4 pt-6 border-t">
                            <PrimaryButton disabled={isLoading}>
                                {isLoading ? 'Saving...' : 'Update Responsibility'}
                            </PrimaryButton>
                            <Link href={route('responsibilities.index')}>
                                <button
                                    type="button"
                                    className="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition"
                                >
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
