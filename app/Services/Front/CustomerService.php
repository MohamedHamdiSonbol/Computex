<?php

namespace App\Services\Front;

use App\Models\Customer;
use App\Repositories\Front\CustomerRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class CustomerService
{
    public function __construct(protected CustomerRepository $customerRepo) {}


    public function getCustomerData($customerId,  $lang)
    {
        $customer = $this->customerRepo->getCustomerData($customerId, $lang);
        return $customer;
    }

    public function truncateCart($customer)
    {
        $this->customerRepo->truncateCart($customer);
    }

    public function changePassword(Customer $customer, string $newPassword): void
    {
        // 1. Business Logic: Hash the raw text password
        $hashedPassword = Hash::make($newPassword);

        // 2. Data Access: Delegate the database update to the Repository
        $this->customerRepo->updatePassword($customer, $hashedPassword);

        // 3. Framework Logic: Invalidate other device sessions
        Auth::guard('customers')->logoutOtherDevices($newPassword);
    }


    public function createCustomer($customerData, $profileData)
    {
        return DB::transaction(function () use ($customerData, $profileData) {

            $customer = $this->customerRepo->creatingCustomer($customerData);

            $this->customerRepo->creatingCustomerProfile($customer, $profileData);

            return $customer;
        });
    }

}
