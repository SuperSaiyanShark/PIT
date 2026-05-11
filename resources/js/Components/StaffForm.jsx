import { useState } from 'react';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import InputLabel from '@/Components/InputLabel';
import InputError from '@/Components/InputError';

export default function StaffForm({ staff, departments, wards, staffRoles, onSubmit, isLoading }) {
    const [formData, setFormData] = useState({
        name: staff?.name || '',
        email: staff?.email || '',
        role: staff?.role || '',
        staff_type: staff?.staff_type || 'nurse', // doctor, nurse, admin
        department_id: staff?.department_id || '',
        ward_id: staff?.ward_id || '',
        staff_role_id: staff?.staff_role_id || '',
        phone: staff?.phone || '',
        building: staff?.building || '',
        employment_type: staff?.employment_type || 'full-time', // full-time, part-time
        hire_date: staff?.hire_date || '',
    });

    const [errors, setErrors] = useState({});

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
        // Clear error for this field when user starts typing
        if (errors[name]) {
            setErrors(prev => ({ ...prev, [name]: '' }));
        }
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        onSubmit(formData, (newErrors) => {
            if (newErrors) {
                setErrors(newErrors);
            }
        });
    };

    return (
        <form onSubmit={handleSubmit} className="space-y-6">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                {/* Name */}
                <div>
                    <InputLabel htmlFor="name" value="Full Name" />
                    <TextInput
                        id="name"
                        name="name"
                        type="text"
                        className="mt-1 block w-full"
                        value={formData.name}
                        onChange={handleChange}
                        required
                    />
                    {errors.name && <InputError message={errors.name} />}
                </div>

                {/* Email */}
                <div>
                    <InputLabel htmlFor="email" value="Email (@meadow.com)" />
                    <TextInput
                        id="email"
                        name="email"
                        type="email"
                        className="mt-1 block w-full"
                        value={formData.email}
                        onChange={handleChange}
                        required
                        placeholder="user@meadow.com"
                    />
                    {errors.email && <InputError message={errors.email} />}
                </div>

                {/* Staff Type */}
                <div>
                    <InputLabel htmlFor="staff_type" value="Staff Type" />
                    <select
                        id="staff_type"
                        name="staff_type"
                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                        value={formData.staff_type}
                        onChange={handleChange}
                    >
                        <option value="">Select Type</option>
                        <option value="doctor">Doctor</option>
                        <option value="nurse">Nurse</option>
                        <option value="admin">Administrative Staff</option>
                    </select>
                    {errors.staff_type && <InputError message={errors.staff_type} />}
                </div>

                {/* Role */}
                <div>
                    <InputLabel htmlFor="role" value="Job Title/Role" />
                    <TextInput
                        id="role"
                        name="role"
                        type="text"
                        className="mt-1 block w-full"
                        value={formData.role}
                        onChange={handleChange}
                        placeholder="e.g., Senior Nurse, Radiologist"
                    />
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
                        <option value="">Select Department</option>
                        {departments.map(dept => (
                            <option key={dept.id} value={dept.id}>
                                {dept.name}
                            </option>
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
                        <option value="">Select Ward</option>
                        {wards.map(ward => (
                            <option key={ward.id} value={ward.id}>
                                {ward.name}
                            </option>
                        ))}
                    </select>
                </div>

                {/* Staff Role */}
                <div>
                    <InputLabel htmlFor="staff_role_id" value="Staff Role" />
                    <select
                        id="staff_role_id"
                        name="staff_role_id"
                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                        value={formData.staff_role_id}
                        onChange={handleChange}
                    >
                        <option value="">Select Role</option>
                        {staffRoles.map(role => (
                            <option key={role.id} value={role.id}>
                                {role.name}
                            </option>
                        ))}
                    </select>
                </div>

                {/* Phone */}
                <div>
                    <InputLabel htmlFor="phone" value="Phone Number" />
                    <TextInput
                        id="phone"
                        name="phone"
                        type="tel"
                        className="mt-1 block w-full"
                        value={formData.phone}
                        onChange={handleChange}
                    />
                </div>

                {/* Building */}
                <div>
                    <InputLabel htmlFor="building" value="Building/Office" />
                    <TextInput
                        id="building"
                        name="building"
                        type="text"
                        className="mt-1 block w-full"
                        value={formData.building}
                        onChange={handleChange}
                        placeholder="e.g., Building A, Room 101"
                    />
                </div>

                {/* Employment Type */}
                <div>
                    <InputLabel htmlFor="employment_type" value="Employment Type" />
                    <select
                        id="employment_type"
                        name="employment_type"
                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                        value={formData.employment_type}
                        onChange={handleChange}
                    >
                        <option value="full-time">Full-Time</option>
                        <option value="part-time">Part-Time</option>
                        <option value="contract">Contract</option>
                    </select>
                </div>

                {/* Hire Date */}
                <div>
                    <InputLabel htmlFor="hire_date" value="Hire Date" />
                    <TextInput
                        id="hire_date"
                        name="hire_date"
                        type="date"
                        className="mt-1 block w-full"
                        value={formData.hire_date}
                        onChange={handleChange}
                    />
                </div>
            </div>

            <div className="flex gap-4">
                <PrimaryButton type="submit" disabled={isLoading}>
                    {isLoading ? 'Saving...' : staff ? 'Update Staff' : 'Add Staff'}
                </PrimaryButton>
            </div>
        </form>
    );
}
