export default function StaffCard({ staff }) {
    return (
        <div className="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div className="flex flex-col items-center">
                {/* Profile Image */}
                <div className="w-24 h-24 mb-4 rounded-full overflow-hidden bg-gray-200">
                    {staff.profile_image ? (
                        <img
                            src={staff.profile_image}
                            alt={staff.name}
                            className="w-full h-full object-cover"
                        />
                    ) : (
                        <div className="w-full h-full flex items-center justify-center bg-gray-300 text-gray-600 font-bold text-2xl">
                            {staff.name.charAt(0)}
                        </div>
                    )}
                </div>

                {/* Name */}
                <h3 className="text-lg font-semibold text-gray-800 text-center">{staff.name}</h3>

                {/* Role */}
                <p className="text-sm text-gray-600 text-center mb-3">{staff.role}</p>

                {/* Department Badge */}
                <span className="inline-block bg-cyan-500 text-white text-xs font-semibold px-3 py-1 rounded-full mb-4">
                    {staff.department?.name || staff.department || 'N/A'}
                </span>

                {/* Email */}
                <div className="flex items-center text-gray-700 mb-2 w-full justify-center">
                    <svg className="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </svg>
                    <span className="text-sm truncate">{staff.email}</span>
                </div>

                {/* Phone */}
                <div className="flex items-center text-gray-700 mb-2 w-full justify-center">
                    <svg className="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.418 1.02 1.004 1.989 1.839 2.823.835.835 1.803 1.421 2.823 1.839l.773-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2.57C6.75 18 1 12.25 1 5.43V3z"></path>
                    </svg>
                    <span className="text-sm">{staff.phone}</span>
                </div>

                {/* Building */}
                <div className="flex items-center text-gray-700 w-full justify-center">
                    <svg className="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    <span className="text-sm">{staff.building}</span>
                </div>
            </div>
        </div>
    );
}
