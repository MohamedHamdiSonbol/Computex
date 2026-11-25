<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Front\CustomerRegisterRequest;
use App\Http\Resources\Front\CityResource;
use App\Http\Resources\Front\GovernorateResource;
use App\Models\Governorate;
use App\Services\Front\CityService;
use App\Services\Front\CustomerService;
use App\Services\Front\GovernorateService;



class RegisterController extends Controller
{
    public function create(GovernorateService $governorateServ)
    {
        $lang = get_active_lang();
        $rawGovernorates = $governorateServ->getAllGovernoratesWithTranslations($lang);
        $governorates = GovernorateResource::collection($rawGovernorates)->resolve();
//        return $governorates;
        return view('front.register', compact('governorates'));
    }

    public function store(CustomerRegisterRequest $request, CustomerService $customerServ)
    {
        try{

            [$customerData, $profileData] = $request->passedValidation();

            $customer = $customerServ->createCustomer($customerData, $profileData);

            auth('customers')->login($customer);

            return redirect()->intended(route('front.home'));

        } catch(\Exception $e){
            return redirect()->route('admin.attributes.create')->with('error', 'هناك خطأ ما');
        }

    }




//    public function destroy(Request $request): RedirectResponse
//    {
////        CartItem::where('customer_id', auth()->guard('customers')->user()->id)->delete();
////        Auth::guard('customers')->logout();
////        $request->session()->invalidate();
////        $request->session()->regenerateToken();
//        return to_route('front.home');
//    }

    public function fetchCities(Governorate $governorate, CityService $cityServ){
        try{
            $lang = get_active_lang();
            $rawCities = $cityServ->getAllCitiesWithTranslations($governorate->id, $lang);
            $cities = CityResource::collection($rawCities)->resolve();

            return response()->json([
                'cities' => $cities,
            ]);
        } catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
