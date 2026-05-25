import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';

export default function SchedulesCreate({ staff }) {
    // Swapped day_of_week, start_time, and end_time for exact database column names
    const { data, setData, post, processing, errors } = useForm({
        staff_id: '',
        start_date: '',
        end_date: '',
        shift_type: '', // Optional/Nullable field based on your controller validation
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('schedules.store'));
    };

    return (
        <AuthenticatedLayout>
            <Head title="Create Schedule" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <h2 className="text-2xl font-semibold mb-6">Create Schedule</h2>

                            <form onSubmit={submit} className="space-y-6">
                                {/* Staff Member Selector */}
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

                                {/* Start Date & Time picker */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Start Date & Time *</label>
                                    <input
                                        type="datetime-local"
                                        value={data.start_date}
                                        onChange={(e) => setData('start_date', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                    {errors.start_date && <div className="text-red-600 text-sm mt-1">{errors.start_date}</div>}
                                </div>

                                {/* End Date & Time picker */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">End Date & Time *</label>
                                    <input
                                        type="datetime-local"
                                        value={data.end_date}
                                        onChange={(e) => setData('end_date', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    />
                                    {errors.end_date && <div className="text-red-600 text-sm mt-1">{errors.end_date}</div>}
                                </div>

                                {/* Shift Type Selector */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Shift Type</label>
                                    <select
                                        value={data.shift_type}
                                        onChange={(e) => setData('shift_type', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-3 py-2 border"
                                    >
                                        <option value="">Select shift window (Optional)</option>
                                        <option value="morning">Morning</option>
                                        <option value="afternoon">Afternoon</option>
                                        <option value="night">Night</option>
                                    </select>
                                    {errors.shift_type && <div className="text-red-600 text-sm mt-1">{errors.shift_type}</div>}
                                </div>

                                <div className="flex flex-col space-y-4">
                                    <div>
                                        <button
                                            type="submit"
                                            disabled={processing}
                                            className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700 disabled:opacity-50 transition-colors"
                                        >
                                            {processing ? 'Creating...' : 'Create Schedule'}
                                        </button>
                                    </div>

                                    {/* DYNAMIC ERROR SUMMARY BANNER */}
                                    {Object.keys(errors).length > 0 && (
                                        <div className="p-4 bg-red-50 text-red-700 rounded border border-red-200">
                                            <p className="font-semibold">Please resolve the following submission errors:</p>
                                            <ul className="list-disc pl-5 mt-1 text-sm">
                                                {Object.keys(errors).map((key) => (
                                                    <li key={key}>{errors[key]}</li>
                                                ))}
                                            </ul>
                                        </div>
                                    )}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}