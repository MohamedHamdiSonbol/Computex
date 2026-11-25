<?php

namespace App\Repositories\Front;

use App\Models\Governorate;
use App\Models\Language;


class GovernorateRepository
{
    // We create a property to hold the query as we build it
    protected $query;

/*
 |======================================================================================================================
 | 🔍 Hidden Queries
 |======================================================================================================================
*/



    protected function AllGovernorates($query){
        return $query->select('id');
    }

    protected function withTranslation($query, $lang){
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query->whereHas('translation')
            ->with(['translation' => fn($q) => $q
                ->where('language_id', $languageId)
                ->addSelect('governorate_id', 'language_id', 'name')
            ]);
    }

/*
 |======================================================================================================================
 | 🔍 Main Queries
 |======================================================================================================================
*/
    public function getAllGovernoratesWithTranslations($lang){
        $query = Governorate::query();
        $query = $this->AllGovernorates($query);
        $query = $this->withTranslation($query, $lang);
        return $query->get();

    }


}
