import { useState } from 'react';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import InputLabel from '@/Components/InputLabel';
import InputError from '@/Components/InputError';

export default function ResponsibilityForm({ staffId, onSubmit, isLoading }) {
    const [formData, setFormData] = useState({
        description: '',
        priority: 'medium',
        status: 'active',
        assigned_date: new Date().toISOString().split('T')[0],
    });

    const [errors, setErrors] = useState({});

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
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

                {/* Priority */}
                <div>
                    <InputLabel htmlFor="priority" value="Priority" />
                    <select
                        id="priority"
                        name="priority"
                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                        value={formData.priority}
                        onChange={handleChange}
                    >
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
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
                    </select>
                </div>

                {/* Assigned Date */}
                <div>
                    <InputLabel htmlFor="assigned_date" value="Assigned Date" />
                    <TextInput
                        id="assigned_date"
                        name="assigned_date"
                        type="date"
                        className="mt-1 block w-full"
                        value={formData.assigned_date}
                        onChange={handleChange}
                    />
                </div>
            </div>

            <div className="flex gap-4">
                <PrimaryButton type="submit" disabled={isLoading}>
                    {isLoading ? 'Saving...' : 'Add Responsibility'}
                </PrimaryButton>
            </div>
        </form>
    );
}
