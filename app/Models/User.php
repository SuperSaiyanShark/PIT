<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'staff_type', 'department_id', 'ward_id', 'staff_role_id', 'phone', 'building', 'profile_image', 'employment_type', 'hire_date', 'termination_date', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'hire_date' => 'date',
            'termination_date' => 'date',
        ];
    }

    // Relationships
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function staffRole()
    {
        return $this->belongsTo(StaffRole::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'staff_id');
    }

    public function responsibilities()
    {
        return $this->hasMany(Responsibility::class, 'staff_id');
    }

    public function departmentHead()
    {
        return $this->hasMany(Department::class, 'head_id');
    }

    public function wardHead()
    {
        return $this->hasMany(Ward::class, 'ward_head_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function treatments()
    {
        return $this->hasMany(\Modules\Module4\app\Models\Treatment::class);
    }

    /**
     * Check if user is a Meadow staff member (@meadow.com email)
     */
    public function isMeadowStaff(): bool
    {
        return str_ends_with($this->email, '@meadow.com');
    }
}
