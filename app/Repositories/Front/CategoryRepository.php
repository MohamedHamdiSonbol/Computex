<?php

namespace App\Repositories\Front;

use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Language;
use Illuminate\Contracts\Database\Eloquent\Builder;


class CategoryRepository
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
    protected function checkExistance($query, $categoryId){
        return $query->where('id', $categoryId);
    }

    protected function WithTranslation($query, $lang) {
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query->where('active', 1)
                     ->whereHas('translation', fn($q) => $q->where('language_id', $languageId))
                     ->select('id', 'photo')
                     ->with(['translation'  => fn($q) => $q->where('language_id', $languageId)->select('category_id', 'name', 'slug')]);
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


    protected function WithLoadCategoryTranslationsRelations(CategoryTranslation $categoryTranslation)
    {
        return $categoryTranslation->load('category');
    }


/*
 |======================================================================================================================
 | 🔍 Main Queries
 |======================================================================================================================
*/
    public function getCheckCategoryExist($categoryId){
        $query = Category::query();
        $query = $this->checkExistance($query, $categoryId);
        return $query->exists();

    }


    public function getHomeCategories($lang){
        $query = Category::query();
        $query = $this->WithTranslation($query, $lang);
        return $query->get();

    }

    public function getLoadCategoryTranslationsRelations($categoryTranslation){
        return $this-> WithloadCategoryTranslationsRelations($categoryTranslation);
    }
}
