import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';

export default function SchedulesEdit({ schedule, staff }) {
    const { data, setData, put, processing, errors } = useForm({
        staff_id: schedule.staff_id || '',
        day_of_week: schedule.day_of_week || '',
        start_time: schedule.start_time || '',
        end_time: schedule.end_time || '',
    });

    const submit = (e) => {
        e.preventDefault();
        put(route('schedules.update', schedule.id));
    };

    return (
        <AuthenticatedLayout>
            <Head title="Edit Schedule" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <h2 className="text-2xl font-semibold mb-6">Edit Schedule</h2>

                            <form onSubmit={submit} className="space-y-6">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Staff Member *</label>
                                    <select
                                        value={data.staff_id}
                                        onChange={(e) => setData('staff_id', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    >
                                        <option value="">Select staff member</option>
                                        {staff?.map((s) => (
                                            <option key={s.id} value={s.id}>
                                                {s.name}
                                            </option>
                                        ))}
                                    </select>
                                    {errors.staff_id && <div className="text-red-600 text-sm mt-1">{errors.staff_id}</div>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Day of Week *</label>
                                    <select
                                        value={data.day_of_week}
                                        onChange={(e) => setData('day_of_week', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    >
                                        <option value="">Select day</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                        <option value="Sunday">Sunday</option>
                                    </select>
                                    {errors.day_of_week && <div className="text-red-600 text-sm mt-1">{errors.day_of_week}</div>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Start Time *</label>
                                    <input
                                        type="time"
                                        value={data.start_time}
                                        onChange={(e) => setData('start_time', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                    {errors.start_time && <div className="text-red-600 text-sm mt-1">{errors.start_time}</div>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">End Time *</label>
                                    <input
                                        type="time"
                                        value={data.end_time}
                                        onChange={(e) => setData('end_time', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                    {errors.end_time && <div className="text-red-600 text-sm mt-1">{errors.end_time}</div>}
                                </div>

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700 disabled:opacity-50"
                                >
                                    Update Schedule
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
