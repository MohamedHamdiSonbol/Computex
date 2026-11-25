<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id', 'type', 'value', 'min_quantity',
        'min_order_value', 'usage_limit_per_user', 'is_active'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_value' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function discountable(): MorphTo
    {
        return $this->morphTo();
    }

//    public function campaign(): BelongsTo
//    {
//        return $this->belongsTo(Campaign::class);
//    }

    /**
     * Helper to calculate the discounted amount based on a given price.
     */
    public function calculateDiscount($originalPrice)
    {
        if ($this->type === 'percentage') {
            return ($originalPrice * $this->value) / 100;
        }
        return $this->value; // Fixed amount
    }

    public function scopeGetActiveDiscounts($query){
        return $query->where('is_active', true)->select('id', 'campaign_id', 'type', 'value', 'min_quantity',
            'min_order_value', 'usage_limit_per_user', 'is_active');
    }

    public function scopeWithCampaigns($query, $lang){
        $languageId = Language::where('abbr', $lang)->value('id');

//        return $query->GetActiveDiscounts()
        return $query
            ->with(['discountable' => fn($q) => $q
                ->select('id')
                ->with(['translation' => fn($q) => $q->where('language_id', $languageId)->select('campaign_id', 'name')])]);
    }


    protected function isActiveText(): Attribute{
        return Attribute::make(
            get: fn() => $this->is_active ? __('Active') : __('Inactive'),
        );
    }
}
