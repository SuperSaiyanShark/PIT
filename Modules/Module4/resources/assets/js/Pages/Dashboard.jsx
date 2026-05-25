import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'; // Points back to your root shell layout
import { Head } from '@inertiajs/react'; // Cleaned up unused Link import

export default function Dashboard() {
    // Array map containing your 5 dashboard action panels
    const features = [
        { name: 'Appointments', desc: 'Manage appointments', icon: '👤', url: '/module4/appointments' },
        { name: 'Treatment History', desc: 'View patient records', icon: '💬', url: '/module4/treatments' },
        { name: 'Record Treatments', desc: 'Add new treatment', icon: '＋', url: '/module4/treatments/create' },
        { name: 'All Treatments', desc: 'View all treatments', icon: '＋', url: '/module4/treatments' },
        { name: 'Staff Management', desc: 'Manage medical staff', icon: '👤', url: route('staff.index') }, // Safe to keep since it's a root app route
    ];

    return (
        <AuthenticatedLayout
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Appointment and Treatment Module</h2>}
        >
            <Head title="Module 4 Dashboard" />

            {/* Embedded Header Branding Banner */}
            <div className="bg-cyan-600 rounded-xl p-6 text-white mb-8 shadow-md">
                <h1 className="text-2xl font-bold tracking-wide uppercase">Wellmeadows Hospital</h1>
                <p className="text-cyan-100 text-xs mt-1 tracking-wider">Appointment and Treatment Module</p>
            </div>

            {/* Native Full-Width Grid Layout */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {features.map((item, index) => (
                    <a 
                        key={index} 
                        href={item.url}
                        /* FIXED: Swapped out Inertia's <Link> for standard anchor elements. 
                           This forces a full browser redirection, ensuring pages render natively 
                           as standalone panels rather than inside a sandboxed iframe window wrapper. */
                        className="bg-white border border-gray-100 p-8 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 flex flex-col items-center text-center group border-b-4 hover:border-b-cyan-500"
                    >
                        <div className="w-16 h-16 bg-cyan-50 rounded-full flex items-center justify-center text-cyan-600 text-2xl mb-4 group-hover:scale-105 transition-transform">
                            {item.icon}
                        </div>
                        <h3 className="text-lg font-bold text-gray-800 mb-1">{item.name}</h3>
                        <p className="text-sm text-gray-500">{item.desc}</p>
                    </a>
                ))}
            </div>
        </AuthenticatedLayout>
    );
}