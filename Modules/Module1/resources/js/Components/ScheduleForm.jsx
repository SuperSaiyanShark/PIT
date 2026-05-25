import { useState } from 'react';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import InputLabel from '@/Components/InputLabel';
import InputError from '@/Components/InputError';

export default function ScheduleForm({ staffId, onSubmit, isLoading }) {
    const [formData, setFormData] = useState({
        day_of_week: '',
        start_time: '',
        end_time: '',
        shift_type: 'morning', // morning, afternoon, night
    });

    const [errors, setErrors] = useState({});

    const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

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
                {/* Day of Week */}
                <div>
                    <InputLabel htmlFor="day_of_week" value="Day of Week" />
                    <select
                        id="day_of_week"
                        name="day_of_week"
                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                        value={formData.day_of_week}
                        onChange={handleChange}
                        required
                    >
                        <option value="">Select Day</option>
                        {daysOfWeek.map(day => (
                            <option key={day} value={day}>{day}</option>
                        ))}
                    </select>
                    {errors.day_of_week && <InputError message={errors.day_of_week} />}
                </div>

                {/* Shift Type */}
                <div>
                    <InputLabel htmlFor="shift_type" value="Shift Type" />
                    <select
                        id="shift_type"
                        name="shift_type"
                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                        value={formData.shift_type}
                        onChange={handleChange}
                    >
                        <option value="morning">Morning (6 AM - 2 PM)</option>
                        <option value="afternoon">Afternoon (2 PM - 10 PM)</option>
                        <option value="night">Night (10 PM - 6 AM)</option>
                    </select>
                </div>

                {/* Start Time */}
                <div>
                    <InputLabel htmlFor="start_time" value="Start Time" />
                    <TextInput
                        id="start_time"
                        name="start_time"
                        type="time"
                        className="mt-1 block w-full"
                        value={formData.start_time}
                        onChange={handleChange}
                        required
                    />
                    {errors.start_time && <InputError message={errors.start_time} />}
                </div>

                {/* End Time */}
                <div>
                    <InputLabel htmlFor="end_time" value="End Time" />
                    <TextInput
                        id="end_time"
                        name="end_time"
                        type="time"
                        className="mt-1 block w-full"
                        value={formData.end_time}
                        onChange={handleChange}
                        required
                    />
                    {errors.end_time && <InputError message={errors.end_time} />}
                </div>
            </div>

            <div className="flex gap-4">
                <PrimaryButton type="submit" disabled={isLoading}>
                    {isLoading ? 'Saving...' : 'Add Schedule'}
                </PrimaryButton>
            </div>
        </form>
    );
}
