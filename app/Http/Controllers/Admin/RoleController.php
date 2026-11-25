<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
//        $start = microtime(true);
        $roles = Role::GetAllRoles();
//        $end = microtime(true);
//        dd($end - $start);
//        return $roles;
        return view('admin.admins.roles_permissions.index', compact('lang', 'languages', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        $lang = get_active_lang();
        $languages = get_active_languages();
        $permissions = Permission::GetAllPermissions();
        return view('admin.admins.roles_permissions.create_role', compact('lang', 'languages',  'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $this->authorize('create', Role::class);

        [$roleData, $permissionIds] = $request->passedValidation();
        try {
//            return $roleData;
//            return $permissionIds;
            DB::beginTransaction();

            $role = Role::create($roleData);

            $role->permissions()->sync($permissionIds);

            DB::commit();
            return redirect()->route('admin.roles.index')->with('success', 'تمت إضافة المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
//            return $ex->getMessage();
            return redirect()->route('admin.roles.index')->with('error', 'هناك خطأ ما' . $ex->getMessage());
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
    public function edit(Role $role)
    {
        $this->authorize('update', $role);

        $lang = get_active_lang();
        $languages = get_active_languages();
        $role = $role->loadRoleWithPermissions();
        $permissions = Permission::GetAllPermissions();
        $assignedPermissionsIds = $role->permissions->pluck('id')->toArray();
//        return $role;
//        return $permissions;
        return view('admin.admins.roles_permissions.edit_role', compact('lang', 'languages',  'role', 'permissions', 'assignedPermissionsIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);

        [$roleData, $permissionIds]  = $request->passedValidation();
//            return $roleData;
//            return $permissionIds;
        try {
            DB::beginTransaction();

            $role->update($roleData);

            $role->permissions()->sync($permissionIds);

            DB::commit();
            return redirect()->route('admin.roles.index')->with('success', 'تمت تعديل المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
//                        return $ex->getMessage();
            return redirect()->route('admin.roles.index')->with('error', 'هناك خطأ ما'. $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        try {
            if($role->admins()->exists()){
                return redirect()->route('admin.roles.index')->with('error', 'لا يمكن حذف هذا الدور الوظيفي لأنه مستخدم بالفعل');
            }else{
                $role->delete();
            }
            return redirect()->route('admin.roles.index')->with('success', 'تمت حذف المنتج بنجاح');
        } catch (\Exception $ex){
            return redirect()->route('admin.roles.index')->with('error', 'هناك خطأ ما');
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
