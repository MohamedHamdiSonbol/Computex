<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignTranslation extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'description', 'campaign_id', 'language_id'];

    public function campaign(): BelongsTo{
        return $this->belongsTo(Campaign::class);
    }
    public function language(): BelongsTo{
        return $this->belongsTo(Language::class);
    }
}
