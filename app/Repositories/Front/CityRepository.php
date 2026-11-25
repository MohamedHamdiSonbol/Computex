<?php

namespace App\Repositories\Front;

use App\Models\City;
use App\Models\Language;


class CityRepository
{
    // We create a property to hold the query as we build it
    protected $query;

/*
 |======================================================================================================================
 | 🔍 Hidden Queries
 |======================================================================================================================
*/



    protected function getCitiesByGovernorate($query, $governorateId){
        return $query->where('governorate_id', $governorateId)->select('id');
    }

    protected function withTranslation($query, $lang){
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query->whereHas('translation')
            ->with(['translation' => fn($q) => $q
                ->where('language_id', $languageId)
                ->addSelect('city_id', 'language_id', 'name')
            ]);
    }

/*
 |======================================================================================================================
 | 🔍 Main Queries
 |======================================================================================================================
*/
    public function getCitiesWithTranslationsByGovernorate($governorateId, $lang){
        $query = City::query();
        $query = $this->getCitiesByGovernorate($query, $governorateId);
        $query = $this->withTranslation($query, $lang);
        return $query->get();

    }


}
