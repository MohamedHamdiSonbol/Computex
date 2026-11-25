<?php

namespace App\Repositories\Front;

use App\Models\Brand;
use App\Models\BrandTranslation;
use App\Models\Language;
use Illuminate\Contracts\Database\Eloquent\Builder;


class BrandRepository
{
    // We create a property to hold the query as we build it
    protected $query;

/*
 |======================================================================================================================
 | 🔍 Hidden Queries
 |======================================================================================================================
*/

//    public function Active($query){
//        return $query->where('active', 1);
//    }
//
    protected function checkExistance($query, $brandId){
        return $query->where('id', $brandId);
    }

    protected function WithTranslation($query, $lang) {
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query->where('is_active', 1)
                     ->whereHas('translation', fn($q) => $q->where('language_id', $languageId))
                     ->select('id', 'logo')
                     ->with(['translation'  => fn($q) => $q->where('language_id', $languageId)->select('brand_id', 'name', 'slug')]);
    }

//    public function WithActiveLanguage(Builder $query, string $lang) {
//        $languageId = Language::where('abbr', $lang)->value('id');
//        return $query
//            ->whereHas('translation', fn($q) => $q->where('language_id', $languageId))->select('id', 'photo', 'active')
//            ->with([
//                'translation' => fn($q) => $q->where('language_id', $languageId)
//                    ->selection()
//                    ->with(['language:id,abbr'])
//            ]);
//    }
//    public function WithActiveLanguages(Builder $query): void {
//        $query->with('translations')->selection();
//    }


    protected function WithLoadBrandTranslationsRelations(BrandTranslation $brandTranslation)
    {
        return $brandTranslation->load('brand');
    }


/*
 |======================================================================================================================
 | 🔍 Main Queries
 |======================================================================================================================
*/
    public function getCheckBrandExist($brandId){
        $query = Brand::query();
        $query = $this->checkExistance($query, $brandId);
        return $query->exists();

    }

    public function getHomebrands($lang){
        $query = Brand::query();
        $query = $this->WithTranslation($query, $lang);
        return $query->get();

    }

    public function getLoadBrandTranslationsRelations($brandTranslation){
        return $this->WithLoadBrandTranslationsRelations($brandTranslation);
    }
}
