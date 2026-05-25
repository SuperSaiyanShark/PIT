<?php

namespace Modules\Module3\app\Http\Controllers;

use Modules\Module3\app\Models\User;
use Modules\Module3\app\Models\Department;
use Modules\Module3\app\Models\Ward;
use Modules\Module3\app\Models\StaffRole;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::with('department', 'ward', 'staffRole', 'schedules', 'responsibilities')->get();
        $departments = Department::all();
        $wards = Ward::all();
        $staffRoles = StaffRole::all();
        
        return Inertia::render('Staff', [
            'staff' => $staff,
            'departments' => $departments,
            'wards' => $wards,
            'staffRoles' => $staffRoles,
        ]);
    }

    public function create()
    {
        $departments = Department::all();
        $wards = Ward::all();
        $staffRoles = StaffRole::all();
        
        return Inertia::render('Staff', [
            'departments' => $departments,
            'wards' => $wards,
            'staffRoles' => $staffRoles,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'nullable|string|min:8',
            'role' => 'nullable|string',
            'staff_type' => 'nullable|in:doctor,nurse,admin',
            'department_id' => 'nullable|exists:departments,id',
            'ward_id' => 'nullable|exists:wards,id',
            'staff_role_id' => 'nullable|exists:staff_roles,id',
            'phone' => 'nullable|string',
            'building' => 'nullable|string',
            'employment_type' => 'nullable|string',
            'hire_date' => 'nullable|date',
        ]);

        // Generate default password if not provided
        if (!isset($validated['password']) || empty($validated['password'])) {
            $validated['password'] = bcrypt('Password123!');
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }

        User::create($validated);

        return back()->with('success', 'Staff member added successfully.');
    }

    public function show(User $staff)
    {
        $staff->load('department', 'ward', 'staffRole', 'schedules', 'responsibilities');
        
        return Inertia::render('Staff', [
            'staff' => $staff,
        ]);
    }

    public function edit(User $staff)
    {
        $departments = Department::all();
        $wards = Ward::all();
        $staffRoles = StaffRole::all();
        
        return Inertia::render('Staff', [
            'staff' => $staff,
            'departments' => $departments,
            'wards' => $wards,
            'staffRoles' => $staffRoles,
        ]);
    }

    public function update(Request $request, User $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'staff_type' => 'nullable|in:doctor,nurse,admin',
            'department_id' => 'nullable|exists:departments,id',
            'ward_id' => 'nullable|exists:wards,id',
            'staff_role_id' => 'nullable|exists:staff_roles,id',
            'phone' => 'nullable|string',
            'building' => 'nullable|string',
            'employment_type' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'termination_date' => 'nullable|date',
            'status' => 'nullable|in:active,inactive,suspended',
        ]);

        $staff->update($validated);

        return back()->with('success', 'Staff member updated successfully.');
    }

    public function destroy(User $staff)
    {
        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Staff member deleted successfully.');
    }

    /**
     * Get staff by role
     */
    public function byRole($role)
    {
        $staff = User::with('department', 'ward', 'staffRole')
            ->where('role', $role)
            ->get();

        $departments = Department::all();
        $wards = Ward::all();
        $staffRoles = StaffRole::all();

        return Inertia::render('Staff', [
            'staff' => $staff,
            'departments' => $departments,
            'wards' => $wards,
            'staffRoles' => $staffRoles,
            'filter' => ['role' => $role],
        ]);
    }

    /**
     * Get staff by department
     */
    public function byDepartment($departmentId)
    {
        $department = Department::findOrFail($departmentId);
        $staff = User::with('department', 'ward', 'staffRole')
            ->where('department_id', $departmentId)
            ->get();

        $departments = Department::all();
        $wards = Ward::all();
        $staffRoles = StaffRole::all();

        return Inertia::render('Staff', [
            'staff' => $staff,
            'departments' => $departments,
            'wards' => $wards,
            'staffRoles' => $staffRoles,
            'department' => $department,
            'filter' => ['department_id' => $departmentId],
        ]);
    }

    /**
     * Get staff by ward
     */
    public function byWard($wardId)
    {
        $ward = Ward::findOrFail($wardId);
        $staff = User::with('department', 'ward', 'staffRole')
            ->where('ward_id', $wardId)
            ->get();

        $departments = Department::all();
        $wards = Ward::all();
        $staffRoles = StaffRole::all();

        return Inertia::render('Staff', [
            'staff' => $staff,
            'departments' => $departments,
            'wards' => $wards,
            'staffRoles' => $staffRoles,
            'ward' => $ward,
            'filter' => ['ward_id' => $wardId],
        ]);
    }

    /**
     * Assign staff to ward
     */
    public function assignWard(Request $request, User $staff)
    {
        $validated = $request->validate([
            'ward_id' => 'required|exists:wards,id',
        ]);

        $staff->update($validated);

        return back()->with('success', 'Staff member assigned to ward successfully.');
    }

    /**
     * Assign staff to department
     */
    public function assignDepartment(Request $request, User $staff)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
        ]);

        $staff->update($validated);

        return back()->with('success', 'Staff member assigned to department successfully.');
    }

    /**
     * Get staff schedule
     */
    public function schedule(User $staff)
    {
        $staff->load('schedules');

        return Inertia::render('Staff', [
            'staff' => $staff,
            'schedules' => $staff->schedules,
        ]);
    }

    /**
     * Get staff responsibilities
     */
    public function responsibilities(User $staff)
    {
        $staff->load('responsibilities');

        return Inertia::render('Staff', [
            'staff' => $staff,
            'responsibilities' => $staff->responsibilities,
        ]);
    }

    /**
     * Update staff status
     */
    public function updateStatus(Request $request, User $staff)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $staff->update($validated);

        return back()->with('success', 'Staff status updated successfully.');
    }

    /**
     * Search staff
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $staff = User::with('department', 'ward', 'staffRole')
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhere('phone', 'LIKE', "%{$query}%");
            })
            ->where('role', '!=', 'patient')
            ->get();

        $departments = Department::all();
        $wards = Ward::all();
        $staffRoles = StaffRole::all();

        return Inertia::render('Staff', [
            'staff' => $staff,
            'departments' => $departments,
            'wards' => $wards,
            'staffRoles' => $staffRoles,
            'searchQuery' => $query,
        ]);
    }

    /**
     * Get staff statistics
     */
    public function statistics()
    {
        $stats = [
            'total_staff' => User::where('role', '!=', 'patient')->count(),
            'doctors' => User::where('role', 'doctor')->count(),
            'nurses' => User::where('role', 'nurse')->count(),
            'admin' => User::where('role', 'admin')->count(),
            'technicians' => User::where('role', 'technician')->count(),
            'active' => User::where('status', 'active')->where('role', '!=', 'patient')->count(),
            'inactive' => User::where('status', 'inactive')->where('role', '!=', 'patient')->count(),
            'suspended' => User::where('status', 'suspended')->where('role', '!=', 'patient')->count(),
            'by_department' => Department::withCount('staff')->get(),
            'by_ward' => Ward::withCount('staff')->get(),
        ];

        return Inertia::render('Staff', [
            'stats' => $stats,
        ]);
    }
}
