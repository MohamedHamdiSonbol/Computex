<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = ['name', 'display_name'];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function scopeGetAllPermissions($query){
        return $query->select('id', 'display_name')->get();
    }

    public function loadPermissionData(){
        return $this->load(['profile:id,profileable_id,governorate_id,city_id,mobile,address']);
    }

}
