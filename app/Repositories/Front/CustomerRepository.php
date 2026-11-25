<?php

namespace App\Repositories\Front;

use App\Models\Customer;
use App\Models\Language;


class CustomerRepository
{
    // We create a property to hold the query as we build it
    protected $query;

/*
 |======================================================================================================================
 | 🔍 Hidden Queries
 |======================================================================================================================
*/


    protected function getCustomer($query, $customerId) {
        return $query->where('customers.id', $customerId)
            ->select('customers.id', 'customers.first_name', 'customers.last_name', 'customers.email');
    }

    protected function withProfileData($query, $lang)
    {
        $languageId = Language::where('abbr', $lang)->value('id');

        return $query
            ->join('profiles', function ($join) {
            $join->on('customers.id', '=', 'profiles.profileable_id')
                ->where('profiles.profileable_type', 'customer');
        })
            ->join('governorate_translations', function ($join) use($languageId) {
                $join->on('profiles.governorate_id', '=', 'governorate_translations.governorate_id')
                    ->where('governorate_translations.language_id', $languageId);
            })
            ->join('city_translations', function ($join) use($languageId) {
                $join->on('profiles.city_id', '=', 'city_translations.city_id')
                    ->where('city_translations.language_id', $languageId);
            })
            ->addSelect('profiles.mobile', 'profiles.address',  'governorate_translations.name as governorate_name', 'city_translations.name as city_name');
    }


    protected function createCustomer($query, $customerData){
        return $query->create($customerData);
    }


/*
 |======================================================================================================================
 | 🔍 Main Queries
 |======================================================================================================================
*/

    public function getCustomerData($customerId, $lang){
        $query = Customer::query();
        $query = $this->getCustomer($query, $customerId);
        $query = $this->withProfileData($query, $lang);
        return  $query->first();
    }


    public function truncateCart(Customer $customer){
        return  $customer->cartItems()->delete();
    }

    public function updatePassword(Customer $customer, string $hashedPassword): bool{
        return $customer->update([
            'password' => $hashedPassword,
        ]);
    }

    public function creatingCustomer($customerData){
        $query = Customer::query();
        $query = $this->createCustomer($query, $customerData);
        return $query;
    }

    public function creatingCustomerProfile(Customer $customer, $profileData){
        return $customer->profile()->create($profileData);
    }




}
