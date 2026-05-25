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
        <div className="min-h-screen bg-gray-100 flex">
            {/* Sidebar */}
            <div className={`${sidebarOpen ? 'w-64' : 'w-20'} bg-cyan-600 text-white transition-all duration-300 fixed h-screen flex flex-col`}>
                {/* Logo */}
                <div className="p-6 border-b border-cyan-500">
                    <Link href="/">
                        <ApplicationLogo className="block h-10 w-auto fill-current text-white" />
                    </Link>
                </div>

                {/* Navigation Links */}
                <nav className="flex-1 p-4 space-y-2">
                    <Link
                        href={route('dashboard')}
                        className={`flex items-center space-x-3 px-4 py-3 rounded-lg transition ${route().current('dashboard') ? 'bg-cyan-500' : 'hover:bg-cyan-500'}`}
                    >
                        <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                            <path fillRule="evenodd" d="M3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm8 0a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" clipRule="evenodd"></path>
                        </svg>
                        {sidebarOpen && <span>Dashboard</span>}
                    </Link>

                    <Link
                        href={route('staff.index')}
                        className={`flex items-center space-x-3 px-4 py-3 rounded-lg transition ${route().current('staff.index') ? 'bg-cyan-500' : 'hover:bg-cyan-500'}`}
                    >
                        <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 6a3 3 0 11-6 0 3 3 0 016 0zm0 0h6m-6 0h6m-6 0a3 3 0 11-6 0 3 3 0 016 0zm9-6h6a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path d="M17 16h2a1 1 0 100-2h-2.382l-.447-2.236A2 2 0 0014.414 12H5.586a2 2 0 00-1.757 1.764l-.447 2.236H2a1 1 0 100 2h2z"></path>
                        </svg>
                        {sidebarOpen && <span>Staff</span>}
                    </Link>

                    <Link
                        href={route('responsibilities.index')}
                        className={`flex items-center space-x-3 px-4 py-3 rounded-lg transition ${
                            route().current('responsibilities.index') || route().current('responsibilities.create') || route().current('responsibilities.edit')
                                ? 'bg-cyan-500'
                                : 'hover:bg-cyan-500'
                        }`}
                    >
                        <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fillRule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V5a1 1 0 100 2 1 1 0 011 1v1a1 1 0 100 2V6a3 3 0 00-3-3H4zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd"></path>
                        </svg>
                        {sidebarOpen && <span>Responsibilities</span>}
                    </Link>

                    <Link
                        href={route('admissions.index')}
                        className={`flex items-center space-x-3 px-4 py-3 rounded-lg transition ${
                            route().current('admissions.index') || route().current('admissions.create') || route().current('admissions.edit')
                                ? 'bg-cyan-500'
                                : 'hover:bg-cyan-500'
                        }`}
                    >
                        <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fillRule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v6a1 1 0 102 0V8z" clipRule="evenodd"></path>
                        </svg>
                        {sidebarOpen && <span>Admissions</span>}
                    </Link>
                </nav>

                {/* Logout Section */}
                <div className="p-4 border-t border-cyan-500">
                    <form method="POST" action={route('logout')}>
                        <button
                            type="submit"
                            className="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-cyan-500 transition"
                        >
                            <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fillRule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 00-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clipRule="evenodd"></path>
                            </svg>
                            {sidebarOpen && <span>Log Out</span>}
                        </button>
                    </form>
                </div>

                {/* Toggle Button */}
                <div className="p-4 border-t border-cyan-500">
                    <button
                        onClick={() => setSidebarOpen(!sidebarOpen)}
                        className="w-full flex justify-center hover:bg-cyan-500 rounded-lg p-2 transition"
                    >
                        <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fillRule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clipRule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {/* Main Content */}
            <div className={`flex-1 ${sidebarOpen ? 'ml-64' : 'ml-20'} transition-all duration-300`}>
                <main>{children}</main>
            </div>
        </div>
    );
}