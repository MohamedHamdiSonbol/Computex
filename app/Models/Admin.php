<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'role_id'];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token',];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = ['email_verified_at' => 'datetime',];

    public function profile(): MorphOne{
        return $this->morphOne(Profile::class, 'profileable');
    }


    // 1. Relationship to Roles
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // Helper: Check if Admin has a specific role
    public function hasRole(string $roleName): bool
    {
//        return $this->roles->contains('name', $roleName);
        return $this->role && $this->role->name === $roleName;
    }

    // Helper: Check if Admin has a specific permission via any of their roles
    public function hasPermission(string $permissionName): bool
    {
        // Eager load roles and their permissions to avoid N+1 issues
//        return $this->roles->flatMap(function ($role) {
//            return $role->permissions;
//        })->contains('name', $permissionName);
        return ($this->roles ?? collect())
            ->flatMap(fn($role) => $role->permissions)
            ->contains('name', $permissionName);
    }

    public function scopeGetAllAdmins($query){
        return $query->whereNot('id', Auth::id())->select('id', 'name', 'email', 'role_id');
    }

    public function scopeWithRoles($query){
        return $query->with(['role' => fn($q)=> $q->select('id', 'display_name')]);
    }

    public function loadWithProfileAndRole(){
        return $this->load(['profile:id,profileable_id,governorate_id,city_id,mobile,address', 'role:id,display_name']);
    }
}
