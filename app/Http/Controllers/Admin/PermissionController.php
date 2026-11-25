<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\StorePermissionRequest;
use App\Models\Admin;
use App\Models\City;
use App\Models\Governorate;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
//        $start = microtime(true);
        $permissions = Permission::GetAllPermissions();
//        $end = microtime(true);
//        dd($end - $start);
//        return $permissions;
        return view('admin.admins.roles_permissions.index', compact('lang', 'languages', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $this->authorize('create', Permission::class);

        $lang = get_active_lang();
        $languages = get_active_languages();
        return view('admin.admins.roles_permissions.create_permission', compact( 'lang', 'languages', ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        $this->authorize('create', Permission::class);

        $permissions = $request->passedValidation();
        try {
//            return $permissions;
            DB::beginTransaction();

            Permission::insert($permissions);

            DB::commit();
            return redirect()->route('admin.permissions.index')->with('success', 'تمت إضافة المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
//            return $ex->getMessage();
            return redirect()->route('admin.permissions.index')->with('error', 'هناك خطأ ما' . $ex->getMessage());
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
    public function edit(Permission $permission)
    {
        $this->authorize('update', $permission);

        $lang = get_active_lang();
        $languages = get_active_languages();
        $permission =  $permission->makeHidden(['name', 'created_at', 'updated_at']);
//        return $permission;
        return view('admin.admins.roles_permissions.edit_permission', compact('lang', 'languages', 'permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePermissionRequest $request, Permission $permission)
    {
        $this->authorize('update', $permission);

        $permissionsData  = $request->passedValidation();
//        return $permissionsData;
        try {
            DB::beginTransaction();

            $permission->update($permissionsData);

            DB::commit();
            return redirect()->route('admin.permissions.index')->with('success', 'تمت تعديل المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
//                        return $ex->getMessage();
            return redirect()->route('admin.permissions.index')->with('error', 'هناك خطأ ما'. $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $this->authorize('delete', $permission);
        try {
            if($permission->roles()->exists()){
                return redirect()->route('admin.permissions.index')->with('error', 'لا يمكن حذف هذه الصلاحية لأنها مستخدمة بالفعل');
            }else{
                $permission->delete();
            }
            return redirect()->route('admin.permissions.index')->with('success', 'تمت حذف المنتج بنجاح');
        } catch (\Exception $ex){
            return redirect()->route('admin.permissions.index')->with('error', 'هناك خطأ ما');
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
