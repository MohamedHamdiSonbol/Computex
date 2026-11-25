<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Models\Admin;
use App\Models\City;
use App\Models\Governorate;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
//        $start = microtime(true);
        $admins = Admin::GetAllAdmins()
                         ->WithRoles()
                         ->get();
//        $end = microtime(true);
//        dd($end - $start);
//        return $admins;
        return view('admin.admins.index', compact('lang', 'languages', 'admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $this->authorize('create', Admin::class);

        $lang = get_active_lang();
        $languages = get_active_languages();
        $governorates = Governorate::GetAllGovernoratesTranslations($lang);
        $roles = Role::GetAllRoles();
//return $governorates;
        return view('admin.admins.create', compact('lang', 'languages','governorates', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeAdminRequest $request)
    {
        $this->authorize('create', Admin::class);

//        return request()->all();
        [$adminData, $profileData] = $request->passedValidation();
        try {
//            return $adminData;
//            return $profileData;
            DB::beginTransaction();

            $admin = Admin::create($adminData);

            $admin->profile()->create($profileData);

            DB::commit();
            return redirect()->route('admin.admins.index')->with('success', 'تمت إضافة المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
//            return $ex->getMessage();
            return redirect()->route('admin.admins.index')->with('error', 'هناك خطأ ما' . $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $this->authorize('update', $admin);

        $lang = get_active_lang();
        $languages = get_active_languages();
        $admin =  $admin->loadWithProfileAndRole()->makeHidden(['email_verified_at', 'created_at', 'updated_at']);
        $governorates = Governorate::GetAllGovernoratesTranslations($lang);
        $cities = City::GetAllCitiesTranslation($lang);
        $roles = Role::GetAllRoles();
//        return $admin;
//        return $governorates;
//        return $cities;
//        return $roles;

        return view('admin.admins.edit', compact('lang', 'languages','admin', 'governorates', 'cities', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAdminRequest $request, Admin $admin)
    {
        $this->authorize('update', $admin);

//        return request()->all();
        [$adminData, $profileData]  = $request->passedValidation();
//        return $adminData;
//        return $profileData;
        try {
            DB::beginTransaction();

            $admin->update($adminData);
            $admin->profile()->update($profileData);

            DB::commit();
            return redirect()->route('admin.admins.index')->with('success', 'تمت تعديل المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
//                        return $ex->getMessage();
            return redirect()->route('admin.admins.index')->with('error', 'هناك خطأ ما'. $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $this->authorize('delete', $admin);

        try {
            DB::beginTransaction();
            $admin->delete();
            DB::commit();
            return redirect()->route('admin.admins.index')->with('success', 'تمت حذف المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.admins.index')->with('error', 'هناك خطأ ما');
        }
    }



//    public function toggleStatus(Product $product)
//    {
//        $this->toggleActive('delete', $product);
//
//        try {
//            $product->update([
//                'active' => !$product->active
//            ]);
//
//            return response()->json([
//                'success' => true,
//                'active'  => $product->active,
//                'message' => 'تم تحديث الحالة بنجاح'
//            ]);
//        } catch (\Exception $e) {
//            return response()->json(['success' => false], 500);
//        }
//    }

}
