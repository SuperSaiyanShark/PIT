export default function StaffCard({ staff }) {
    return (
        <div className="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow relative h-full">
            {/* Action Buttons */}
            <div className="absolute top-4 right-4 flex gap-2">
                <button
                    className="bg-cyan-500 hover:bg-cyan-600 text-white p-2 rounded-lg transition"
                    title="Approve"
                >
                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd"></path>
                    </svg>
                </button>
                <button
                    className="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition"
                    title="Delete"
                >
                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fillRule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clipRule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <div className="flex flex-col items-center pt-6">
                {/* Profile Image */}
                <div className="w-20 h-20 mb-4 rounded-full overflow-hidden bg-gray-300 flex items-center justify-center text-gray-600 font-bold text-2xl">
                    {staff.profile_image ? (
                        <img
                            src={staff.profile_image}
                            alt={staff.name}
                            className="w-full h-full object-cover"
                        />
                    ) : (
                        <span>{staff.name.charAt(0).toUpperCase()}</span>
                    )}
                </div>

                {/* Name */}
                <h3 className="text-base font-bold text-gray-800 text-center">{staff.name}</h3>

                {/* Role */}
                <p className="text-sm text-gray-600 text-center mb-3">{staff.role || staff.staff_type || 'Staff'}</p>

                {/* Department Badge */}
                <span className="inline-block bg-cyan-500 text-white text-xs font-semibold px-3 py-1 rounded-full mb-4">
                    {staff.department?.name || staff.department || 'N/A'}
                </span>

                {/* Email */}
                <div className="flex items-center text-gray-600 mb-2 w-full px-2 text-center justify-center">
                    <svg className="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </svg>
                    <span className="text-xs truncate">{staff.email}</span>
                </div>

                {/* Phone */}
                {staff.phone && (
                    <div className="flex items-center text-gray-600 mb-2 w-full px-2 text-center justify-center">
                        <svg className="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.418 1.02 1.004 1.989 1.839 2.823.835.835 1.803 1.421 2.823 1.839l.773-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2.57C6.75 18 1 12.25 1 5.43V3z"></path>
                        </svg>
                        <span className="text-xs">{staff.phone}</span>
                    </div>
                )}

                {/* Building */}
                {staff.building && (
                    <div className="flex items-center text-gray-600 w-full px-2 text-center justify-center">
                        <svg className="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        <span className="text-xs">{staff.building}</span>
                    </div>
                )}
            </div>
        </div>
    );
}
