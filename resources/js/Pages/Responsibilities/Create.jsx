import { useState } from 'react';
import { Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import InputError from '@/Components/InputError';
import { Head } from '@inertiajs/react';

export default function ResponsibilitiesCreate({ staff = [], departments = [], wards = [], staffRoles = [] }) {
    const [formData, setFormData] = useState({
        staff_id: '',
        responsibility_type: '',
        description: '',
        department_id: '',
        ward_id: '',
        shift_type: '',
        staff_role_id: '',
        patient_id: '',
        status: 'active',
        start_date: new Date().toISOString().split('T')[0],
        end_date: '',
        prevent_double_booking: true,
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
        const { name, value, type, checked } = e.target;
        setFormData(prev => ({ ...prev, [name]: type === 'checkbox' ? checked : value }));
        if (errors[name]) {
            setErrors(prev => ({ ...prev, [name]: '' }));
        }
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        setIsLoading(true);

        router.post(route('responsibilities.store'), formData, {
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
            <Head title="Assign New Responsibility" />

            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                {/* Header */}
                <div className="mb-8">
                    <div className="flex items-center gap-4">
                        <Link href={route('responsibilities.index')}>
                            <button className="text-cyan-600 hover:text-cyan-800 font-semibold">
                                ← Back to Responsibilities
                            </button>
                        </Link>
                        <h1 className="text-3xl font-bold text-cyan-600">Assign New Responsibility</h1>
                    </div>
                </div>

                {/* Form Container */}
                <div className="bg-white rounded-lg shadow-md p-8 max-w-4xl">
                    <form onSubmit={handleSubmit} className="space-y-6">

                        {/* Row 1: Staff and Type */}
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                        {/* Row 4: Shift Type and Staff Role */}
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel htmlFor="shift_type" value="Ward Allocation (Shift Type)" />
                                <select
                                    id="shift_type"
                                    name="shift_type"
                                    className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                    value={formData.shift_type}
                                    onChange={handleChange}
                                >
                                    <option value="">Select shift type (optional)</option>
                                    <option value="morning">Morning</option>
                                    <option value="afternoon">Afternoon</option>
                                    <option value="night">Night</option>
                                    <option value="full-day">Full Day</option>
                                </select>
                                {errors.shift_type && <InputError message={errors.shift_type} />}
                            </div>

                            <div>
                                <InputLabel htmlFor="staff_role_id" value="Staff Allocation Role" />
                                <select
                                    id="staff_role_id"
                                    name="staff_role_id"
                                    className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                    value={formData.staff_role_id}
                                    onChange={handleChange}
                                >
                                    <option value="">Select role (optional)</option>
                                    {staffRoles.map(role => (
                                        <option key={role.id} value={role.id}>{role.name}</option>
                                    ))}
                                </select>
                                {errors.staff_role_id && <InputError message={errors.staff_role_id} />}
                            </div>
                        </div>

                        {/* Row 5: Dates and Status */}
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
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

                        {/* Row 6: Patient ID */}
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

                        {/* Row 7: Prevent Double Booking */}
                        <div className="flex items-start gap-3 p-4 bg-blue-50 border border-blue-100 rounded-lg">
                            <input
                                id="prevent_double_booking"
                                name="prevent_double_booking"
                                type="checkbox"
                                className="mt-1 h-4 w-4 text-cyan-600 border-gray-300 rounded focus:ring-cyan-500"
                                checked={formData.prevent_double_booking}
                                onChange={handleChange}
                            />
                            <div>
                                <label htmlFor="prevent_double_booking" className="text-sm font-medium text-gray-800 cursor-pointer">
                                    Prevent Staff Double Booking: Check if staff has conflicts on selected date/shift
                                </label>
                                <p className="text-xs text-gray-500 mt-1">
                                    ⚠️ If enabled, the system will validate that the staff member is not already allocated to another responsibility on the same date with the selected shift.
                                </p>
                            </div>
                        </div>

                        {/* Buttons */}
                        <div className="flex gap-4 pt-6 border-t">
                            <PrimaryButton disabled={isLoading}>
                                {isLoading ? 'Saving...' : 'Assign Responsibility'}
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