import { useState, useMemo } from 'react';
import { Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import StaffCard from '@/Components/StaffCard';
import StaffForm from '@/Components/StaffForm';
import ScheduleForm from '@/Components/ScheduleForm';
import ResponsibilityForm from '@/Components/ResponsibilityForm';
import PrimaryButton from '@/Components/PrimaryButton';
import Modal from '@/Components/Modal';
import { Head } from '@inertiajs/react';

export default function Staff({ staff = [], departments = [], wards = [], staffRoles = [] }) {
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedDepartment, setSelectedDepartment] = useState('');
    const [view, setView] = useState('grid'); // grid, list, details
    const [selectedStaff, setSelectedStaff] = useState(null);
    const [showModal, setShowModal] = useState(false);
    const [modalType, setModalType] = useState(''); // create, edit, schedule, responsibility
    const [isLoading, setIsLoading] = useState(false);

    const uniqueDepartments = [...new Set(staff.map(s => {
        if (typeof s.department === 'object' && s.department) {
            return s.department.name;
        }
        return s.department;
    }).filter(Boolean))];

    const filteredStaff = useMemo(() => {
        return staff.filter(member => {
            const deptName = typeof member.department === 'object' && member.department 
                ? member.department.name 
                : member.department || '';
            
            const matchesSearch = 
                member.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                member.role?.toLowerCase().includes(searchTerm.toLowerCase()) ||
                deptName.toLowerCase().includes(searchTerm.toLowerCase());
            
            const matchesDepartment = selectedDepartment === '' || deptName === selectedDepartment;
            
            return matchesSearch && matchesDepartment;
        });
    }, [searchTerm, selectedDepartment, staff]);

    const handleCreateStaff = () => {
        setSelectedStaff(null);
        setModalType('create');
        setShowModal(true);
    };

    const handleEditStaff = (staffMember) => {
        setSelectedStaff(staffMember);
        setModalType('edit');
        setShowModal(true);
    };

    const handleAddSchedule = (staffMember) => {
        setSelectedStaff(staffMember);
        setModalType('schedule');
        setShowModal(true);
    };

    const handleAddResponsibility = (staffMember) => {
        setSelectedStaff(staffMember);
        setModalType('responsibility');
        setShowModal(true);
    };

    const handleDeleteStaff = (id) => {
        if (confirm('Are you sure you want to delete this staff member?')) {
            router.delete(route('staff.destroy', id), {
                onSuccess: () => {
                    setSelectedStaff(null);
                }
            });
        }
    };

    const handleSubmitStaffForm = (formData, setErrors) => {
        setIsLoading(true);
        const url = selectedStaff ? route('staff.update', selectedStaff.id) : route('staff.store');
        const method = selectedStaff ? 'patch' : 'post';

        router[method](url, formData, {
            onSuccess: () => {
                setShowModal(false);
                setIsLoading(false);
                setSelectedStaff(null);
            },
            onError: (errors) => {
                setIsLoading(false);
                setErrors(errors);
            }
        });
    };

    const handleSubmitScheduleForm = (formData, setErrors) => {
        setIsLoading(true);
        router.post(route('schedules.store'), formData, {
            onSuccess: () => {
                setShowModal(false);
                setIsLoading(false);
            },
            onError: (errors) => {
                setIsLoading(false);
                setErrors(errors);
            }
        });
    };

    const handleSubmitResponsibilityForm = (formData, setErrors) => {
        setIsLoading(true);
        router.post(route('responsibilities.store'), formData, {
            onSuccess: () => {
                setShowModal(false);
                setIsLoading(false);
            },
            onError: (errors) => {
                setIsLoading(false);
                setErrors(errors);
            }
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title="Medical Staff Management" />

            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                {/* Header */}
                <div className="mb-6">
                    <h1 className="text-3xl font-bold text-cyan-700">MEDICAL STAFF MANAGEMENT</h1>
                    <p className="text-sm text-cyan-600 mt-1">"Manage and View Medical Members"</p>
                </div>

                {/* Search and Filter Section */}
                <div className="bg-white rounded-lg shadow-md p-6 mb-8">
                    <div className="flex flex-col md:flex-row gap-4 items-end mb-4">
                        {/* Search Input */}
                        <div className="flex-1 min-w-0">
                            <label className="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <input
                                type="text"
                                placeholder="Search by name, role, department, email..."
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                            />
                        </div>

                        {/* Department Filter */}
                        <div className="flex items-center gap-2">
                            <label htmlFor="dept" className="text-sm font-medium text-gray-700">Department:</label>
                            <select
                                id="dept"
                                value={selectedDepartment}
                                onChange={(e) => setSelectedDepartment(e.target.value)}
                                className="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white font-semibold"
                            >
                                <option value="">ALL DEPARTMENTS</option>
                                {uniqueDepartments.map(dept => (
                                    <option key={dept} value={dept}>
                                        {dept}
                                    </option>
                                ))}
                            </select>
                        </div>

                        {/* View Toggle */}
                        <div className="flex gap-2">
                            <button
                                onClick={() => setView('grid')}
                                className={`px-4 py-2 rounded-lg transition font-semibold ${view === 'grid' ? 'bg-cyan-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`}
                            >
                                <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                                    <path d="M3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z"></path>
                                    <path d="M14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                </svg>
                            </button>
                            <button
                                onClick={() => setView('list')}
                                className={`px-4 py-2 rounded-lg transition font-semibold ${view === 'list' ? 'bg-cyan-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`}
                            >
                                <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fillRule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clipRule="evenodd"></path>
                                </svg>
                            </button>
                        </div>

                        {/* Add Staff Button */}
                        <button
                            onClick={handleCreateStaff}
                            className="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors flex items-center gap-2 whitespace-nowrap"
                        >
                            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fillRule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clipRule="evenodd"></path>
                            </svg>
                            Add Staff
                        </button>
                    </div>

                    {/* Results Summary */}
                    <div className="text-gray-700 mt-4">
                        <p>Showing <span className="font-semibold text-cyan-600">{filteredStaff.length}</span> of <span className="font-semibold">{staff.length}</span> staff members</p>
                    </div>
                </div>

                {/* Staff Display */}
                {filteredStaff.length > 0 ? (
                    view === 'grid' ? (
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            {filteredStaff.map(member => (
                                <StaffCard 
                                    key={member.id} 
                                    staff={member}
                                    onEdit={handleEditStaff}
                                    onDelete={handleDeleteStaff}
                                />
                            ))}
                        </div>
                    ) : (
                        <div className="bg-white rounded-lg shadow-md overflow-x-auto">
                            <table className="w-full">
                                <thead className="bg-cyan-600 text-white">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-sm font-semibold">Name</th>
                                        <th className="px-6 py-3 text-left text-sm font-semibold">Type</th>
                                        <th className="px-6 py-3 text-left text-sm font-semibold">Role/Position</th>
                                        <th className="px-6 py-3 text-left text-sm font-semibold">Department</th>
                                        <th className="px-6 py-3 text-left text-sm font-semibold">Email</th>
                                        <th className="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200">
                                    {filteredStaff.map(member => {
                                        const deptName = typeof member.department === 'object' && member.department 
                                            ? member.department.name 
                                            : member.department || 'N/A';
                                        const roleName = member.staffRole?.name || member.role || 'N/A';
                                        return (
                                            <tr key={member.id} className="hover:bg-gray-50">
                                                <td className="px-6 py-4 text-sm font-medium text-gray-900">{member.name}</td>
                                                <td className="px-6 py-4 text-sm">
                                                    <span className={`inline-block ${
                                                        member.staff_type === 'doctor' ? 'bg-blue-100 text-blue-800' :
                                                        member.staff_type === 'nurse' ? 'bg-pink-100 text-pink-800' :
                                                        'bg-purple-100 text-purple-800'
                                                    } px-3 py-1 rounded-full text-xs font-bold uppercase`}>
                                                        {member.staff_type || 'Staff'}
                                                    </span>
                                                </td>
                                                <td className="px-6 py-4 text-sm">
                                                    <span className="inline-block bg-cyan-50 text-cyan-700 border border-cyan-200 px-3 py-1 rounded font-semibold">
                                                        {roleName}
                                                    </span>
                                                </td>
                                                <td className="px-6 py-4 text-sm text-gray-600">{deptName}</td>
                                                <td className="px-6 py-4 text-sm text-gray-600">{member.email}</td>
                                                <td className="px-6 py-4 text-sm space-x-2 flex">
                                                    <button
                                                        onClick={() => handleEditStaff(member)}
                                                        className="text-cyan-600 hover:text-cyan-900 font-medium hover:underline"
                                                    >
                                                        Edit
                                                    </button>
                                                    <button
                                                        onClick={() => handleAddSchedule(member)}
                                                        className="text-green-600 hover:text-green-900 font-medium hover:underline"
                                                    >
                                                        Schedule
                                                    </button>
                                                    <button
                                                        onClick={() => handleAddResponsibility(member)}
                                                        className="text-purple-600 hover:text-purple-900 font-medium hover:underline"
                                                    >
                                                        Tasks
                                                    </button>
                                                    <button
                                                        onClick={() => handleDeleteStaff(member.id)}
                                                        className="text-red-600 hover:text-red-900 font-medium hover:underline"
                                                    >
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        );
                                    })}
                                </tbody>
                            </table>
                        </div>
                    )
                ) : (
                    <div className="text-center py-12 bg-white rounded-lg shadow-md">
                        <p className="text-gray-600 text-lg">No staff members found matching your search.</p>
                        <button
                            onClick={handleCreateStaff}
                            className="mt-4 px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors"
                        >
                            Add First Staff Member
                        </button>
                    </div>
                )}

                {/* Modal for Forms */}
                <Modal show={showModal} onClose={() => setShowModal(false)}>
                    <div className="p-6">
                        {modalType === 'create' && (
                            <div>
                                <h2 className="text-2xl font-bold text-gray-900 mb-6">Add New Staff Member</h2>
                                <StaffForm 
                                    departments={departments}
                                    wards={wards}
                                    staffRoles={staffRoles}
                                    onSubmit={handleSubmitStaffForm}
                                    isLoading={isLoading}
                                />
                            </div>
                        )}
                        {modalType === 'edit' && selectedStaff && (
                            <div>
                                <h2 className="text-2xl font-bold text-gray-900 mb-6">Edit Staff Member</h2>
                                <StaffForm 
                                    staff={selectedStaff}
                                    departments={departments}
                                    wards={wards}
                                    staffRoles={staffRoles}
                                    onSubmit={handleSubmitStaffForm}
                                    isLoading={isLoading}
                                />
                            </div>
                        )}
                        {modalType === 'schedule' && selectedStaff && (
                            <div>
                                <h2 className="text-2xl font-bold text-gray-900 mb-6">Add Schedule for {selectedStaff.name}</h2>
                                <ScheduleForm 
                                    staffId={selectedStaff.id}
                                    onSubmit={handleSubmitScheduleForm}
                                    isLoading={isLoading}
                                />
                            </div>
                        )}
                        {modalType === 'responsibility' && selectedStaff && (
                            <div>
                                <h2 className="text-2xl font-bold text-gray-900 mb-6">Add Responsibility for {selectedStaff.name}</h2>
                                <ResponsibilityForm 
                                    staffId={selectedStaff.id}
                                    onSubmit={handleSubmitResponsibilityForm}
                                    isLoading={isLoading}
                                />
                            </div>
                        )}
                    </div>
                </Modal>
            </div>
        </AuthenticatedLayout>
    );
}
