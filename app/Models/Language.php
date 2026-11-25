<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'abbr',
        'local',
        'name',
        'direction',
        'active',
    ];



    // Keep 'active' as a number. Create 'active_text' for the UI.
    protected function activeText(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->active ? 'مفعل' : 'غير مفعل',
        );
    }

    public function scopeActive($query){
        return $query->where('active', 1);
    }

    public function scopeSelection($query){
        return $query->select('id', 'abbr', 'local', 'name', 'direction', 'active');
    }
}
