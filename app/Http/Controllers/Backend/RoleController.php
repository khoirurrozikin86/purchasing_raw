<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermissionExport;
use App\Imports\PermissionImport;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    //////////// Permission ALL Method /////////////


    public function AllPermission()
    {
        $permissions = Permission::latest()->get();
        return view('backend.pages.permission.all_permission', compact('permissions'));
    }

    public function AddPermission()
    {
        return view('backend.pages.permission.add_permission');
    }

    public function StorePermission(Request $request)
    {

        $permission = Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name
        ]);

        $notification = array(
            'message' => 'Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);
    }

    public function EditPermission($id)
    {
        $permissions = Permission::findOrFail($id);
        return view('backend.pages.permission.edit_permission', compact('permissions'));
    }

    public function UpdatePermission(Request $request)
    {
        $pid = $request->id;

        Permission::findOrFail($pid)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,

        ]);

        $notification = array(
            'message' => 'Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);
    }

    public function DeletePermission($id)
    {

        Permission::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);
    }

    public function ImportPermission()
    {
        return view('backend.pages.permission.import_permission');
    }

    public function Export()
    {
        return Excel::download(new PermissionExport, 'permission.xlsx');
    }

    public function Import(Request $request)
    {
        $cek = Excel::import(new PermissionImport, $request->file('import_file'));

    
            $notification = array(
                'message' => 'Import Successfully',
                'alert-type' => 'success'
            );
   
    
        return redirect()->route('all.permission')->with($notification);
    } //end method


    ////////////////// Role ALL Method ///////////////////

    public function AllRoles()
    {
        $roles = Role::all();
        return view('backend.pages.roles.all_roles', compact('roles'));
    }

    public function AddRoles()
    {
        return view('backend.pages.roles.add_roles');
    }

    public function StoreRoles(Request $request)
    {

        Role::create([
            'name' => $request->name

        ]);

        $notification = array(
            'message' => 'Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles')->with($notification);
    }

    public function EditRoles($id)
    {
        $roles = Role::findOrFail($id);
        return view('backend.pages.roles.edit_roles', compact('roles'));
    }

    public function UpdateRoles(Request $request)
    {
        $pid = $request->id;

        Role::findOrFail($pid)->update([
            'name' => $request->name


        ]);

        $notification = array(
            'message' => 'Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles')->with($notification);
    }


    public function DeleteRoles($id)
    {

        Role::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles')->with($notification);
    }


    ////////////// Add Role Permission all Method ////////////////

    public function AddRolesPermission()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('backend.pages.rolesetup.add_roles_permission', compact('roles', 'permissions', 'permission_groups'));
    }

    public function RolesPermissionStore(Request $request)
    {
        $data = array();
        $permission = $request->permission;

        foreach ($permission as $key => $item) {
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;

            DB::table('role_has_permissions')->insert($data);
        } //end foreach


        $notification = array(
            'message' => 'Role Permission Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles.permission')->with($notification);
    }

    public function AllRolesPermission()
    {
        $roles = Role::all();
        return view('backend.pages.rolesetup.all_role_permission', compact('roles'));
    }

    public function AdminEditRoles($id)
    {

        $roles = Role::findOrFail($id);
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('backend.pages.rolesetup.edit_roles_permission', compact('roles', 'permissions', 'permission_groups'));
    }

    public function AdminRolesUpdate(Request $request, $id)
    {
        $roles = Role::findOrFail($id);

        $permissions = $request->permission;

        if (!empty($permissions)) {
            $roles->syncPermissions($permissions);
        }

        $notification = array(
            'message' => 'Role Permission Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles.permission')->with($notification);
    }

    public function AdminDeleteRoles($id)
    {

        $role = Role::findOrFail($id);

        if (!is_null($role)) {
            $role->delete();
        }

        $notification = array(
            'message' => 'Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
