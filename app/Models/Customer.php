<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'password',];

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

    public function cartItem(): HasOne{
        return $this->hasOne(CartItem::class);
    }

    public function cartItems(): HasMany{
        return $this->hasMany(CartItem::class);
    }

    public function orders(): HasMany{
        return $this->hasMany(Order::class);
    }

    public function profile(): MorphOne{
        return $this->morphOne(Profile::class, 'profileable');
    }

    public function scopeGetCustomerData($query, $id, $lang)
    {
        return $query
            ->where('id', $id)
            ->select(['id', 'first_name', 'last_name', 'email'])
            // Use eager loading with specific columns and no redundant closures
            ->with([
                'profile' => fn($q) => $q->select([
                    'profileable_id', 'profileable_type', 'mobile', 'address', 'governorate_id', 'city_id'
                ]),
                // Optimize the deep nesting by joining the translation directly if possible,
                // but for standard Eloquent, we use strict constraints:
                'profile.governorate.translation' => fn($q) => $q
                    ->join('languages', 'languages.id', '=', 'governorate_translations.language_id')
                    ->where('languages.abbr', $lang)
                    ->select(['governorate_translations.governorate_id', 'governorate_translations.name']),

                'profile.city.translation' => fn($q) => $q
                    ->join('languages', 'languages.id', '=', 'city_translations.language_id')
                    ->where('languages.abbr', $lang)
                    ->select(['city_translations.city_id', 'city_translations.name'])
            ])
            ->first();
    }


}
