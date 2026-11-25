<?php

namespace App\Services\Front;

use App\Repositories\Front\CityRepository;



class CityService
{
    public function __construct(protected CityRepository $cityRepo) {}

    public function getAllCitiesWithTranslations($governorateId, $lang)
    {
        return $this->cityRepo->getCitiesWithTranslationsByGovernorate($governorateId, $lang);
    }


}
