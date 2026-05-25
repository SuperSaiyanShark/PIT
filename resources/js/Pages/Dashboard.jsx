import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Dashboard({ totalDepartments, totalStaff, totalSupervisors, compliance, staffByRole, supervisors }) {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />

            {/* Changed py-12 to p-6 or py-6 to work seamlessly inside the new AuthenticatedLayout viewport structure */}
            <div className="py-6 px-4 sm:px-6 lg:px-8">
                <div className="mx-auto max-w-7xl space-y-6">
                    {/* Stats Cards */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        {/* Branches Card */}
                        <div className="bg-gradient-to-br from-red-900 to-red-800 text-white rounded-lg shadow-md p-6">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm font-semibold opacity-80">BRANCHES</p>
                                    <p className="text-3xl font-bold mt-2">{totalDepartments}</p>
                                    <p className="text-xs mt-2 opacity-70">Office branches</p>
                                </div>
                                <div className="text-4xl opacity-30">🏢</div>
                            </div>
                        </div>

                        {/* Total Staff Card */}
                        <div className="bg-white rounded-lg shadow-md p-6 border-l-4 border-gray-300">
                            <p className="text-sm font-semibold text-gray-600">TOTAL STAFF</p>
                            <p className="text-3xl font-bold text-gray-800 mt-2">{totalStaff}</p>
                            <p className="text-xs text-gray-500 mt-2">All employees</p>
                        </div>

                        {/* Supervisors Card */}
                        <div className="bg-white rounded-lg shadow-md p-6 border-l-4 border-pink-300">
                            <p className="text-sm font-semibold text-gray-600">SUPERVISORS</p>
                            <p className="text-3xl font-bold text-gray-800 mt-2">{totalSupervisors}</p>
                            <p className="text-xs text-gray-500 mt-2">5-10 staff per group</p>
                        </div>

                        {/* Compliance Card */}
                        <div className="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-400">
                            <p className="text-sm font-semibold text-gray-600">COMPLIANCE</p>
                            <p className="text-3xl font-bold text-gray-800 mt-2">{compliance}%</p>
                            <p className="text-xs text-gray-500 mt-2">All groups within rule</p>
                        </div>
                    </div>

                    {/* Main Content Grid */}
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {/* Supervisor Group Capacity */}
                        <div className="bg-white rounded-lg shadow-md p-6">
                            <h3 className="text-lg font-semibold text-gray-800 mb-4">Supervisor Group Capacity</h3>
                            <div className="text-xs text-gray-500 mb-4">5-10 per group</div>
                            
                            <div className="space-y-3">
                                {supervisors && supervisors.length > 0 ? (
                                    supervisors.map((supervisor, index) => (
                                        <div key={supervisor.id || index} className="flex items-center justify-between pb-3 border-b border-gray-100">
                                            <div className="flex items-center space-x-3">
                                                <div className="w-8 h-8 rounded-full bg-pink-300 flex items-center justify-center text-white text-sm font-semibold">
                                                    {supervisor.name ? supervisor.name.charAt(0).toUpperCase() : 'S'}
                                                </div>
                                                <div>
                                                    <p className="font-semibold text-sm text-gray-800">{supervisor.name}</p>
                                                    <p className="text-xs text-gray-500">S{String(supervisor.id).padStart(3, '0')}</p>
                                                </div>
                                            </div>
                                            <div className="flex items-center space-x-2">
                                                <div className="w-24 h-2 bg-gray-200 rounded-full">
                                                    <div 
                                                        className="h-full bg-red-900 rounded-full" 
                                                        style={{ width: `${Math.min((supervisor.staffCount / 10) * 100, 100)}%` }}
                                                    ></div>
                                                </div>
                                                <span className="text-sm font-semibold text-gray-700 w-12 text-right">
                                                    {supervisor.staffCount}/10 <span className="text-green-600">✓</span>
                                                </span>
                                            </div>
                                        </div>
                                    ))
                                ) : (
                                    <p className="text-gray-500 text-center py-4">No supervisors found</p>
                                )}
                            </div>
                        </div>

                        {/* Right Column */}
                        <div className="space-y-6">
                            {/* Reporting Hierarchy */}
                            <div className="bg-white rounded-lg shadow-md p-6">
                                <h3 className="text-lg font-semibold text-gray-800 mb-4">Reporting Hierarchy</h3>
                                <div className="text-xs text-gray-500 mb-4">Trigger: 1, 2, 3</div>
                                
                                <div className="space-y-3">
                                    {[
                                        { icon: '📋', label: 'Manager', role: 'Manager', count: staffByRole?.Manager || 0 },
                                        { icon: '👤', label: 'Supervisor', role: 'Supervisor', count: staffByRole?.Supervisor || 0 },
                                        { icon: '👥', label: 'Staff', role: 'Staff', count: staffByRole?.Staff || 0 },
                                        { icon: '📝', label: 'Secretary', role: 'Secretary', count: staffByRole?.Secretary || 0 },
                                    ].map((item, idx) => (
                                        <div key={idx} className="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                            <div className="flex items-center space-x-3">
                                                <span className="text-lg">{item.icon}</span>
                                                <div>
                                                    <p className="font-semibold text-sm text-gray-800">{item.label}</p>
                                                    <p className="text-xs text-gray-500">{item.role}</p>
                                                </div>
                                            </div>
                                            <div className="flex items-center space-x-2">
                                                <span className="text-lg text-gray-600">●</span>
                                                <span className="text-sm text-gray-700 font-semibold">{item.count}</span>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            {/* Staff by Position */}
                            <div className="bg-white rounded-lg shadow-md p-6">
                                <h3 className="text-lg font-semibold text-gray-800 mb-4">Staff by Position</h3>
                                
                                <div className="space-y-2">
                                    <div className="grid grid-cols-3 gap-4 pb-3 border-b border-gray-200">
                                        <p className="text-sm font-semibold text-gray-600">POSITION</p>
                                        <p className="text-sm font-semibold text-gray-600">COUNT</p>
                                        <p className="text-sm font-semibold text-gray-600">RULE</p>
                                    </div>
                                    {[
                                        { position: 'Manager', count: staffByRole?.Manager || 0, rule: '1 per branch · car + bonus' },
                                        { position: 'Supervisor', count: staffByRole?.Supervisor || 0, rule: '5-10 staff per group' },
                                        { position: 'Secretary', count: staffByRole?.Secretary || 0, rule: 'Typing speed required' },
                                        { position: 'Staff', count: staffByRole?.Staff || 0, rule: 'Must have supervisor_no' },
                                    ].map((item, idx) => (
                                        <div key={idx} className="grid grid-cols-3 gap-4 py-3 border-b border-gray-100 last:border-b-0">
                                            <p className="text-sm font-semibold text-gray-700">{item.position}</p>
                                            <p className="text-sm font-bold text-gray-800">{item.count}</p>
                                            <p className="text-xs text-gray-500">{item.rule}</p>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Module3 - Hospital Management Quick Access */}
                    <div className="bg-white rounded-lg shadow-md p-6">
                        <h3 className="text-lg font-semibold text-gray-800 mb-4">Module3 - Hospital Management</h3>
                        <p className="text-sm text-gray-600 mb-6">Quick access to hospital management features</p>
                        
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            {/* Departments Button */}
                            <Link
                                href={route('departments.index')}
                                className="flex flex-col items-center justify-center p-6 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 transition shadow-md"
                            >
                                <svg className="w-8 h-8 mb-2" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span className="font-semibold">Departments</span>
                                <span className="text-xs opacity-80 mt-1">Manage departments</span>
                            </Link>

                            {/* Wards & Beds Button */}
                            <Link
                                href={route('wards.index')}
                                className="flex flex-col items-center justify-center p-6 rounded-lg bg-gradient-to-br from-purple-500 to-purple-600 text-white hover:from-purple-600 hover:to-purple-700 transition shadow-md"
                            >
                                <svg className="w-8 h-8 mb-2" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span className="font-semibold">Wards & Beds</span>
                                <span className="text-xs opacity-80 mt-1">Manage beds</span>
                            </Link>

                            {/* Staff Roles Button */}
                            <Link
                                href={route('staff-roles.index')}
                                className="flex flex-col items-center justify-center p-6 rounded-lg bg-gradient-to-br from-green-500 to-green-600 text-white hover:from-green-600 hover:to-green-700 transition shadow-md"
                            >
                                <svg className="w-8 h-8 mb-2" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span className="font-semibold">Staff Roles</span>
                                <span className="text-xs opacity-80 mt-1">Manage roles</span>
                            </Link>

                            {/* Schedules Button */}
                            <Link
                                href={route('schedules.index')}
                                className="flex flex-col items-center justify-center p-6 rounded-lg bg-gradient-to-br from-orange-500 to-orange-600 text-white hover:from-orange-600 hover:to-orange-700 transition shadow-md"
                            >
                                <svg className="w-8 h-8 mb-2" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span className="font-semibold">Schedules</span>
                                <span className="text-xs opacity-80 mt-1">Manage schedules</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}