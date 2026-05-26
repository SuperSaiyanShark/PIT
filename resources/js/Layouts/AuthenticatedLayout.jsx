import ApplicationLogo from '@/Components/ApplicationLogo';
import Dropdown from '@/Components/Dropdown';
import NavLink from '@/Components/NavLink';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';
import { Link, usePage } from '@inertiajs/react';
import { useState } from 'react';

export default function AuthenticatedLayout({ header, children }) {
    const user = usePage().props.auth.user;
    const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);
    const [sidebarOpen, setSidebarOpen] = useState(true);

    return (
        <div className="min-h-screen bg-gray-100 flex relative">
            {/* Sidebar */}
            <div className={`${sidebarOpen ? 'w-64' : 'w-20'} bg-cyan-600 text-white transition-all duration-300 fixed left-0 top-0 bottom-0 h-screen flex flex-col z-50 shadow-lg`}>
                
                {/* Logo Section */}
                <div className="p-5 border-b border-cyan-500 flex-shrink-0 flex items-center justify-center h-20">
                    <Link href="/" className="flex items-center justify-center">
                        <ApplicationLogo className="block h-10 w-auto fill-current text-white" />
                    </Link>
                </div>

                {/* Navigation Links with Hidden Scrollbar functionality */}
                <nav className="flex-1 px-3 py-4 space-y-1 overflow-y-auto min-h-0 scrollbar-none custom-sidebar-nav">
                    
                    {/* Dashboard */}
                    <Link
                        href={route('dashboard')}
                        className={`flex items-center ${sidebarOpen ? 'justify-start px-4' : 'justify-center'} py-3 rounded-lg transition-all duration-200 group ${
                            route().current('dashboard') ? 'bg-cyan-500 text-white shadow-sm' : 'hover:bg-cyan-500/50 text-cyan-100 hover:text-white'
                        }`}
                        title={!sidebarOpen ? "Dashboard" : ""}
                    >
                        <svg className="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                            <path fillRule="evenodd" d="M3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm8 0a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" clipRule="evenodd"></path>
                        </svg>
                        {sidebarOpen && <span className="ml-3 text-sm font-medium transition-opacity duration-200">Dashboard</span>}
                    </Link>

                    {/* Appointments */}
                    <Link
                        href={route('module4.dashboard')}
                        className={`flex items-center ${sidebarOpen ? 'justify-start px-4' : 'justify-center'} py-3 rounded-lg transition-all duration-200 group ${
                            route().current('module4.dashboard') ? 'bg-cyan-500 text-white shadow-sm' : 'hover:bg-cyan-500/50 text-cyan-100 hover:text-white'
                        }`}
                        title={!sidebarOpen ? "Appointments & Treatments" : ""}
                    >
                        <svg className="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.5 1.5H5.75A2.75 2.75 0 003 4.25v11.5A2.75 2.75 0 005.75 18.5h8.5a2.75 2.75 0 002.75-2.75V9.5m-11-6h6m-6 4h6m-6 4h6"></path>
                        </svg>
                        {sidebarOpen && <span className="ml-3 text-sm font-medium truncate transition-opacity duration-200">Appointments & Tr...</span>}
                    </Link>

                    {/* Staff */}
                    <Link
                        href={route('staff.index')}
                        className={`flex items-center ${sidebarOpen ? 'justify-start px-4' : 'justify-center'} py-3 rounded-lg transition-all duration-200 group ${
                            route().current('staff.index') ? 'bg-cyan-500 text-white shadow-sm' : 'hover:bg-cyan-500/50 text-cyan-100 hover:text-white'
                        }`}
                        title={!sidebarOpen ? "Staff" : ""}
                    >
                        <svg className="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 6a3 3 0 11-6 0 3 3 0 016 0zm0 0h6m-6 0h6m-6 0a3 3 0 11-6 0 3 3 0 016 0zm9-6h6a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path d="M17 16h2a1 1 0 100-2h-2.382l-.447-2.236A2 2 0 0014.414 12H5.586a2 2 0 00-1.757 1.764l-.447 2.236H2a1 1 0 100 2h2z"></path>
                        </svg>
                        {sidebarOpen && <span className="ml-3 text-sm font-medium transition-opacity duration-200">Staff</span>}
                    </Link>

                    {/* Patients */}
                    <Link
                        href={route('patients.index')}
                        className={`flex items-center ${sidebarOpen ? 'justify-start px-4' : 'justify-center'} py-3 rounded-lg transition-all duration-200 group ${
                            route().current('patients.*') ? 'bg-cyan-500 text-white shadow-sm' : 'hover:bg-cyan-500/50 text-cyan-100 hover:text-white'
                        }`}
                        title={!sidebarOpen ? "Patients" : ""}
                    >
                        <svg className="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 6a3 3 0 11-6 0 3 3 0 016 0zm0 0h6m-6 0h6m-6 0a3 3 0 11-6 0 3 3 0 016 0zm9-6h6a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path d="M17 16h2a1 1 0 100-2h-2.382l-.447-2.236A2 2 0 0014.414 12H5.586a2 2 0 00-1.757 1.764l-.447 2.236H2a1 1 0 100 2h2z"></path>
                        </svg>
                        {sidebarOpen && <span className="ml-3 text-sm font-medium transition-opacity duration-200">Patients</span>}
                    </Link>

                    {/* Responsibilities */}
                    <Link
                        href={route('responsibilities.index')}
                        className={`flex items-center ${sidebarOpen ? 'justify-start px-4' : 'justify-center'} py-3 rounded-lg transition-all duration-200 group ${
                            route().current('responsibilities.*') ? 'bg-cyan-500 text-white shadow-sm' : 'hover:bg-cyan-500/50 text-cyan-100 hover:text-white'
                        }`}
                        title={!sidebarOpen ? "Responsibilities" : ""}
                    >
                        <svg className="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fillRule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V5a1 1 0 100 2 1 1 0 011 1v1a1 1 0 100 2V6a3 3 0 00-3-3H4zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd"></path>
                        </svg>
                        {sidebarOpen && <span className="ml-3 text-sm font-medium transition-opacity duration-200">Responsibilities</span>}
                    </Link>

                    {/* Admissions */}
                    <Link
                        href={route('admissions.index')}
                        className={`flex items-center ${sidebarOpen ? 'justify-start px-4' : 'justify-center'} py-3 rounded-lg transition-all duration-200 group ${
                            route().current('admissions.*') ? 'bg-cyan-500 text-white shadow-sm' : 'hover:bg-cyan-500/50 text-cyan-100 hover:text-white'
                        }`}
                        title={!sidebarOpen ? "Admissions" : ""}
                    >
                        <svg className="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fillRule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v6a1 1 0 102 0V8z" clipRule="evenodd"></path>
                        </svg>
                        {sidebarOpen && <span className="ml-3 text-sm font-medium transition-opacity duration-200">Admissions</span>}
                    </Link>

                    {/* Module1 Section - Patient Management */}
                    <div className="my-4 pt-4 border-t border-cyan-500/60 space-y-1">
                        {sidebarOpen ? (
                            <span className="text-cyan-200 text-[10px] font-bold px-4 py-1 block uppercase tracking-wider">Module1</span>
                        ) : (
                            <div className="border-b border-cyan-500/30 my-2 mx-4" />
                        )}
                        
                        {/* Module1 Dashboard Link */}
                        <Link
                            href={route('module1.dashboard')}
                            className={`flex items-center ${sidebarOpen ? 'justify-start px-4' : 'justify-center'} py-3 rounded-lg transition-all duration-200 group ${
                                route().current('module1.dashboard') ? 'bg-cyan-500 text-white shadow-sm' : 'hover:bg-cyan-500/50 text-cyan-100 hover:text-white'
                            }`}
                            title={!sidebarOpen ? "Staff & Patients" : ""}
                        >
                            <svg className="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {sidebarOpen && <span className="ml-3 text-sm font-medium transition-opacity duration-200">Staff & Patients</span>}
                        </Link>
                    </div>

                    {/* Module3 Section - Hospital Management */}
                    <div className="my-4 pt-4 border-t border-cyan-500/60 space-y-1">
                        {sidebarOpen ? (
                            <span className="text-cyan-200 text-[10px] font-bold px-4 py-1 block uppercase tracking-wider">Hospital Mgmt</span>
                        ) : (
                            <div className="border-b border-cyan-500/30 my-2 mx-4" />
                        )}
                        
                        {/* 1. Departments Link */}
                        <Link
                            href={route('departments.index')}
                            className={`flex items-center ${sidebarOpen ? 'justify-start px-4' : 'justify-center'} py-3 rounded-lg transition-all duration-200 group ${
                                route().current('departments.*') ? 'bg-cyan-500 text-white shadow-sm' : 'hover:bg-cyan-500/50 text-cyan-100 hover:text-white'
                            }`}
                            title={!sidebarOpen ? "Departments" : ""}
                        >
                            <svg className="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            {sidebarOpen && <span className="ml-3 text-sm font-medium transition-opacity duration-200">Departments</span>}
                        </Link>

                        {/* 2. Ward Management Link */}
                        <Link
                            href={route('wards.index')}
                            className={`flex items-center ${sidebarOpen ? 'justify-start px-4' : 'justify-center'} py-3 rounded-lg transition-all duration-200 group ${
                                route().current('wards.*') ? 'bg-cyan-500 text-white shadow-sm' : 'hover:bg-cyan-500/50 text-cyan-100 hover:text-white'
                            }`}
                            title={!sidebarOpen ? "Ward Management" : ""}
                        >
                            <svg className="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            {sidebarOpen && <span className="ml-3 text-sm font-medium transition-opacity duration-200">Ward Management</span>}
                        </Link>

                        {/* 3. Staff Roles Link */}
                        <Link
                            href={route('staff-roles.index')}
                            className={`flex items-center ${sidebarOpen ? 'justify-start px-4' : 'justify-center'} py-3 rounded-lg transition-all duration-200 group ${
                                route().current('staff-roles.*') ? 'bg-cyan-500 text-white shadow-sm' : 'hover:bg-cyan-500/50 text-cyan-100 hover:text-white'
                            }`}
                            title={!sidebarOpen ? "Staff Roles" : ""}
                        >
                            <svg className="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            {sidebarOpen && <span className="ml-3 text-sm font-medium transition-opacity duration-200">Staff Roles</span>}
                        </Link>

                        {/* 4. Schedules Link */}
                        <Link
                            href={route('schedules.index')}
                            className={`flex items-center ${sidebarOpen ? 'justify-start px-4' : 'justify-center'} py-3 rounded-lg transition-all duration-200 group ${
                                route().current('schedules.*') ? 'bg-cyan-500 text-white shadow-sm' : 'hover:bg-cyan-500/50 text-cyan-100 hover:text-white'
                            }`}
                            title={!sidebarOpen ? "Schedules" : ""}
                        >
                            <svg className="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fillRule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clipRule="evenodd"></path>
                            </svg>
                            {sidebarOpen && <span className="ml-3 text-sm font-medium transition-opacity duration-200">Schedules</span>}
                        </Link>
                    </div>
                </nav>

                {/* Bottom Action Footer */}
                <div className="p-3 border-t border-cyan-500 bg-cyan-600/50 flex-shrink-0 space-y-1">
                    {/* Logout Link */}
                    <form method="POST" action={route('logout')}>
                        <button
                            type="submit"
                            className={`w-full flex items-center ${sidebarOpen ? 'justify-start px-4' : 'justify-center'} py-3 rounded-lg text-cyan-100 hover:text-white hover:bg-cyan-500/50 transition-all duration-200`}
                            title={!sidebarOpen ? "Log Out" : ""}
                        >
                            <svg className="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fillRule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 00-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clipRule="evenodd"></path>
                            </svg>
                            {sidebarOpen && <span className="ml-3 text-sm font-medium">Log Out</span>}
                        </button>
                    </form>

                    {/* Collapse Toggle Arrow Button */}
                    <button
                        onClick={() => setSidebarOpen(!sidebarOpen)}
                        className="w-full flex justify-center text-cyan-200 hover:text-white hover:bg-cyan-500/50 rounded-lg py-2 transition-all duration-200"
                        title={sidebarOpen ? "Collapse Menu" : "Expand Menu"}
                    >
                        <svg className={`w-5 h-5 transform transition-transform duration-300 ${!sidebarOpen ? 'rotate-180' : ''}`} fill="currentColor" viewBox="0 0 20 20">
                            <path fillRule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clipRule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {/* Main Content View Window */}
            <div className={`flex-1 min-h-screen ${sidebarOpen ? 'pl-64' : 'pl-20'} transition-all duration-300 w-full`}>
                {header && (
                    <header className="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40 h-20 flex items-center">
                        <div className="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            {header}
                        </div>
                    </header>
                )}
                <main className="w-full min-h-[calc(100vh-5rem)] p-6">{children}</main>
            </div>
        </div>
    );
}