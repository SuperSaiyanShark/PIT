export default function StaffCard({ staff, onEdit, onDelete }) {
    const getRoleBadgeColor = (staffType) => {
        switch(staffType) {
            case 'doctor':
                return 'bg-blue-100 text-blue-800';
            case 'nurse':
                return 'bg-pink-100 text-pink-800';
            case 'admin':
                return 'bg-purple-100 text-purple-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    };

    return (
        <div className="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow relative h-full flex flex-col">
            {/* Action Buttons */}
            <div className="absolute top-4 right-4 flex gap-2">
                <button
                    onClick={() => onEdit && onEdit(staff)}
                    className="bg-cyan-500 hover:bg-cyan-600 text-white p-2 rounded-lg transition"
                    title="Edit Staff"
                >
                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                    </svg>
                </button>
                <button
                    onClick={() => onDelete && onDelete(staff.id)}
                    className="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition"
                    title="Delete Staff"
                >
                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fillRule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clipRule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <div className="flex flex-col items-center pt-6 flex-grow">
                {/* Profile Image */}
                <div className="w-20 h-20 mb-4 rounded-full overflow-hidden bg-gray-300 flex items-center justify-center text-gray-600 font-bold text-2xl border-4 border-cyan-200">
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

                {/* Staff Type Badge */}
                <div className="mt-2 mb-3">
                    <span className={`inline-block ${getRoleBadgeColor(staff.staff_type)} text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide`}>
                        {staff.staff_type || 'Staff'}
                    </span>
                </div>

                {/* Role/Position - Enhanced */}
                {staff.staffRole && (
                    <div className="mb-3 text-center">
                        <p className="text-sm font-semibold text-cyan-700 bg-cyan-50 px-3 py-2 rounded border border-cyan-200">
                            {staff.staffRole.name}
                        </p>
                    </div>
                )}

                {/* Role fallback */}
                {!staff.staffRole && staff.role && (
                    <p className="text-sm text-gray-600 text-center mb-3 font-semibold">{staff.role}</p>
                )}

                {/* Department Badge */}
                <span className="inline-block bg-cyan-500 text-white text-xs font-semibold px-3 py-1 rounded-full mb-4">
                    {staff.department?.name || staff.department || 'No Dept'}
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
