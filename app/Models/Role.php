<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = ['name', 'display_name'];

    protected $hidden = ['name', 'created_at', 'updated_at'];

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function scopeGetAllRoles($query){
        return $query->select('id', 'display_name')->get();
    }

    public function loadRoleWithPermissions(){
        return $this->load('permissions:id,display_name');
    }
}
