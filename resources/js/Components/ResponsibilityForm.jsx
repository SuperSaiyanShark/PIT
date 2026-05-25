import { useState } from 'react';
import PrimaryButton from '@/Components/PrimaryButton';
import SecondaryButton from '@/Components/SecondaryButton';
import TextInput from '@/Components/TextInput';
import InputLabel from '@/Components/InputLabel';
import InputError from '@/Components/InputError';

export default function ResponsibilityForm({ staffId, staff, departments, wards, staffRoles, onSubmit, onCancel, isLoading }) {
    const [formData, setFormData] = useState({
        description: '',
        responsibility_type: '',
        priority: 'medium',
        status: 'active',
        department_id: '',
        ward_id: '',
        shift_type: '',
        staff_role_id: '',
        start_date: new Date().toISOString().split('T')[0],
        end_date: '',
        patient_id: '',
        prevent_double_booking: true,
    });

    const [errors, setErrors] = useState({});

    const handleChange = (e) => {
        const { name, value, type, checked } = e.target;
        setFormData(prev => ({ ...prev, [name]: type === 'checkbox' ? checked : value }));
        if (errors[name]) {
            setErrors(prev => ({ ...prev, [name]: '' }));
        }
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        onSubmit({ ...formData, staff_id: staffId }, (newErrors) => {
            if (newErrors) {
                setErrors(newErrors);
            }
        });
    };

    return (
        <form onSubmit={handleSubmit} className="space-y-4">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">

                {/* Description */}
                <div className="md:col-span-2">
                    <InputLabel htmlFor="description" value="Responsibility Description" />
                    <textarea
                        id="description"
                        name="description"
                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                        rows="3"
                        value={formData.description}
                        onChange={handleChange}
                        placeholder="Describe the staff responsibility..."
                        required
                    />
                    {errors.description && <InputError message={errors.description} />}
                </div>

                {/* Department */}
                <div>
                    <InputLabel htmlFor="department_id" value="Department" />
                    <select
                        id="department_id"
                        name="department_id"
                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                        value={formData.department_id}
                        onChange={handleChange}
                    >
                        <option value="">Select department (optional)</option>
                        {departments?.map(dept => (
                            <option key={dept.id} value={dept.id}>{dept.name}</option>
                        ))}
                    </select>
                </div>

                {/* Ward */}
                <div>
                    <InputLabel htmlFor="ward_id" value="Ward" />
                    <select
                        id="ward_id"
                        name="ward_id"
                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                        value={formData.ward_id}
                        onChange={handleChange}
                    >
                        <option value="">Select ward (optional)</option>
                        {wards?.map(ward => (
                            <option key={ward.id} value={ward.id}>{ward.name}</option>
                        ))}
                    </select>
                </div>

                {/* Ward Allocation / Shift Type */}
                <div>
                    <InputLabel htmlFor="shift_type" value="Ward Allocation (Shift Type)" />
                    <select
                        id="shift_type"
                        name="shift_type"
                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                        value={formData.shift_type}
                        onChange={handleChange}
                    >
                        <option value="">Select shift type (optional)</option>
                        <option value="morning">Morning</option>
                        <option value="afternoon">Afternoon</option>
                        <option value="night">Night</option>
                        <option value="full-day">Full Day</option>
                    </select>
                </div>

                {/* Staff Allocation Role */}
                <div>
                    <InputLabel htmlFor="staff_role_id" value="Staff Allocation Role" />
                    <select
                        id="staff_role_id"
                        name="staff_role_id"
                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                        value={formData.staff_role_id}
                        onChange={handleChange}
                    >
                        <option value="">Select role (optional)</option>
                        {staffRoles?.map(role => (
                            <option key={role.id} value={role.id}>{role.name}</option>
                        ))}
                    </select>
                </div>

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
                    />
                    {errors.end_date && <InputError message={errors.end_date} />}
                </div>

                {/* Status */}
                <div>
                    <InputLabel htmlFor="status" value="Status" />
                    <select
                        id="status"
                        name="status"
                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                        value={formData.status}
                        onChange={handleChange}
                    >
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="on-hold">On Hold</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                {/* Patient ID */}
                <div className="md:col-span-2">
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
                </div>

                {/* Prevent Double Booking */}
                <div className="md:col-span-2">
                    <div className="flex items-start gap-3 p-4 bg-blue-50 border border-blue-100 rounded-md">
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
                </div>

            </div>

            <div className="flex gap-4">
                <PrimaryButton type="submit" disabled={isLoading}>
                    {isLoading ? 'Saving...' : 'Assign Responsibility'}
                </PrimaryButton>
                {onCancel && (
                    <SecondaryButton type="button" onClick={onCancel}>
                        Cancel
                    </SecondaryButton>
                )}
            </div>
        </form>
    );
}