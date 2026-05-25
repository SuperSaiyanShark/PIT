import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

// FIXED: Changed component name from 'SchedulesIndex' to 'Index' to match Inertia file-routing standards
export default function Index({ schedules }) {
    
    // Helper function to format calendar date cleanly
    const formatDate = (dateString) => {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleDateString(undefined, { 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric' 
        });
    };

    // Helper function to format time strings cleanly
    const formatTime = (dateString) => {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleTimeString(undefined, { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title="Schedules" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="flex justify-between items-center mb-6">
                                <h2 className="text-2xl font-semibold">Staff Schedules</h2>
                                <Link href={route('schedules.create')} className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700 transition-colors">
                                    Add Schedule
                                </Link>
                            </div>

                            <div className="overflow-x-auto">
                                <table className="min-w-full border-collapse border border-gray-300">
                                    <thead className="bg-gray-100">
                                        <tr>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Staff Member</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Date</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Start Time</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">End Time</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Shift Type</th>
                                            <th className="border border-gray-300 px-4 py-2 text-left">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {schedules && schedules.length > 0 ? (
                                            schedules.map((schedule) => (
                                                <tr key={schedule.id} className="hover:bg-gray-50">
                                                    <td className="border border-gray-300 px-4 py-2 font-medium">
                                                        {schedule.staff?.name || 'N/A'}
                                                    </td>
                                                    {/* Maps Option A: start_date calendar data */}
                                                    <td className="border border-gray-300 px-4 py-2">
                                                        {formatDate(schedule.start_date)}
                                                    </td>
                                                    {/* Maps Option A: start_date clock timestamp */}
                                                    <td className="border border-gray-300 px-4 py-2 text-green-700 font-medium">
                                                        {formatTime(schedule.start_date)}
                                                    </td>
                                                    {/* Maps Option A: end_date clock timestamp */}
                                                    <td className="border border-gray-300 px-4 py-2 text-red-700 font-medium">
                                                        {formatTime(schedule.end_date)}
                                                    </td>
                                                    <td className="border border-gray-300 px-4 py-2 capitalize">
                                                        {schedule.shift_type ? (
                                                            <span className="px-2 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-800">
                                                                {schedule.shift_type}
                                                            </span>
                                                        ) : (
                                                            <span className="text-gray-400 text-sm">Standard</span>
                                                        )}
                                                    </td>
                                                    <td className="border border-gray-300 px-4 py-2">
                                                        <Link href={route('schedules.edit', schedule.id)} className="text-cyan-600 hover:text-cyan-900 mr-3 font-medium">
                                                            Edit
                                                        </Link>
                                                        <button className="text-red-600 hover:text-red-900 font-medium">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            ))
                                        ) : (
                                            <tr>
                                                <td colSpan="6" className="border border-gray-300 px-4 py-12 text-center text-gray-500">
                                                    No schedules found
                                                </td>
                                            </tr>
                                        )}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}