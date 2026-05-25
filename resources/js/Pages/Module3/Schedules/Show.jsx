import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function SchedulesShow({ schedule }) {
    return (
        <AuthenticatedLayout>
            <Head title="Schedule Details" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="flex justify-between items-center mb-6">
                                <h2 className="text-2xl font-semibold">Schedule Details</h2>
                                <Link href={route('schedules.edit', schedule.id)} className="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700">
                                    Edit
                                </Link>
                            </div>

                            <div className="space-y-4">
                                <div>
                                    <label className="font-semibold">Staff Member</label>
                                    <p>{schedule.staff?.name || 'N/A'}</p>
                                </div>

                                <div>
                                    <label className="font-semibold">Day of Week</label>
                                    <p>{schedule.day_of_week}</p>
                                </div>

                                <div>
                                    <label className="font-semibold">Start Time</label>
                                    <p>{schedule.start_time}</p>
                                </div>

                                <div>
                                    <label className="font-semibold">End Time</label>
                                    <p>{schedule.end_time}</p>
                                </div>
                            </div>

                            <div className="mt-6">
                                <Link href={route('schedules.index')} className="text-cyan-600 hover:text-cyan-900">
                                    Back to Schedules
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
