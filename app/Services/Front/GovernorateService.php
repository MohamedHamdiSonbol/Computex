<?php

namespace App\Services\Front;

use App\Repositories\Front\GovernorateRepository;



class GovernorateService
{
    public function __construct(protected GovernorateRepository $governorateRepo) {}

    public function getAllGovernoratesWithTranslations($lang)
    {
        return $this->governorateRepo->getAllGovernoratesWithTranslations($lang);
    }



}
