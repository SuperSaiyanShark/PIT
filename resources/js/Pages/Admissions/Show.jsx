import { Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import { Head } from '@inertiajs/react';

export default function AdmissionShow({ admission }) {
    const handleDischarge = () => {
        if (window.confirm('Are you sure you want to discharge this patient?')) {
            router.patch(route('admissions.discharge', admission.AdmissionID), {
                DischargeDate: new Date().toISOString().split('T')[0]
            });
        }
    };

    return (
        <AuthenticatedLayout>
            <Head title="Admission Details" />
            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                <div className="mb-8 flex items-center justify-between">
                    <div className="flex items-center gap-4">
                        <Link href={route('admissions.index')}>
                            <button className="text-cyan-600 hover:text-cyan-800 font-semibold">← Back to Admissions</button>
                        </Link>
                        <h1 className="text-3xl font-bold text-cyan-600">Admission Details</h1>
                    </div>
                    <span className={`px-4 py-2 rounded-full text-sm font-semibold ${
                        admission.DischargeDate 
                            ? 'bg-gray-200 text-gray-800' 
                            : 'bg-green-200 text-green-800'
                    }`}>
                        {admission.DischargeDate ? 'Discharged' : 'Active'}
                    </span>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Main Details */}
                    <div className="lg:col-span-2 bg-white rounded-lg shadow-md p-8">
                        <div className="space-y-6">
                            {/* Patient Info */}
                            <div className="border-b pb-6">
                                <h2 className="text-xl font-bold text-cyan-600 mb-4">Patient Information</h2>
                                <div className="grid grid-cols-2 gap-4">
                                    <div>
                                        <p className="text-gray-600 text-sm">Patient Name</p>
                                        <p className="text-lg font-semibold">{admission.patient?.firstname} {admission.patient?.lastname}</p>
                                    </div>
                                    <div>
                                        <p className="text-gray-600 text-sm">Patient ID</p>
                                        <p className="text-lg font-semibold">#{admission.patient?.Patient_no}</p>
                                    </div>
                                </div>
                            </div>

                            {/* Ward & Staff Info */}
                            <div className="border-b pb-6">
                                <h2 className="text-xl font-bold text-cyan-600 mb-4">Ward & Staff Assignment</h2>
                                <div className="grid grid-cols-2 gap-4">
                                    <div>
                                        <p className="text-gray-600 text-sm">Assigned Ward</p>
                                        <p className="text-lg font-semibold">{admission.bed?.ward?.WardName}</p>
                                        <p className="text-gray-500">Bed: {admission.bed?.BedNumber}</p>
                                    </div>
                                    <div>
                                        <p className="text-gray-600 text-sm">Assigned Staff</p>
                                        <p className="text-lg font-semibold">{admission.staff?.name}</p>
                                        <p className="text-gray-500 capitalize">{admission.staff?.role}</p>
                                    </div>
                                </div>
                            </div>

                            {/* Admission Dates */}
                            <div className="border-b pb-6">
                                <h2 className="text-xl font-bold text-cyan-600 mb-4">Admission Timeline</h2>
                                <div className="grid grid-cols-2 gap-4">
                                    <div>
                                        <p className="text-gray-600 text-sm">Admission Date</p>
                                        <p className="text-lg font-semibold">{new Date(admission.AdmissionDate).toLocaleDateString()}</p>
                                    </div>
                                    {admission.DischargeDate && (
                                        <div>
                                            <p className="text-gray-600 text-sm">Discharge Date</p>
                                            <p className="text-lg font-semibold">{new Date(admission.DischargeDate).toLocaleDateString()}</p>
                                        </div>
                                    )}
                                </div>
                            </div>

                            {/* Reason for Admission */}
                            <div className="border-b pb-6">
                                <h2 className="text-xl font-bold text-cyan-600 mb-4">Reason for Admission</h2>
                                <p className="text-gray-700 whitespace-pre-wrap">{admission.reason}</p>
                            </div>

                            {/* Additional Notes */}
                            {admission.notes && (
                                <div>
                                    <h2 className="text-xl font-bold text-cyan-600 mb-4">Additional Notes</h2>
                                    <p className="text-gray-700 whitespace-pre-wrap">{admission.notes}</p>
                                </div>
                            )}
                        </div>
                    </div>

                    {/* Actions Sidebar */}
                    <div className="bg-white rounded-lg shadow-md p-6 h-fit">
                        <h2 className="text-lg font-bold text-cyan-600 mb-4">Actions</h2>
                        <div className="space-y-3">
                            <Link href={route('admissions.edit', admission.AdmissionID)}>
                                <button className="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                                    Edit Admission
                                </button>
                            </Link>
                            {!admission.DischargeDate && (
                                <button 
                                    onClick={handleDischarge}
                                    className="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-semibold"
                                >
                                    Discharge Patient
                                </button>
                            )}
                            <Link href={route('admissions.index')}>
                                <button className="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-semibold">
                                    Back to List
                                </button>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
