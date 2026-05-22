import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

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

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
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
                                                    {supervisor.name.charAt(0).toUpperCase()}
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
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
