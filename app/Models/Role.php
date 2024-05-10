<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;


class Role extends Model {
    static $PAGE_SIZE = 10;

    protected $table = 'roles';

    public static function DataRoles($request) {
        $page_size = $request->page_size ?? self::$PAGE_SIZE;

        $query = \Spatie\Permission\Models\Role::whereLike(['name'], $request->anyField)
            ->orderBy('id', 'DESC');

        if ($request->status != '') {
            $query->where('roles.status', '=', $request->status);
        }

        $data = $query->paginate($page_size);

        $response = array(
            'data' => $data,
            'pagination' => $data->links()->render()
        );

        return $response;
    }


    public static function getRoleById($id) {
        return  \Spatie\Permission\Models\Role::find($id);
    }


    public static function updateRoles($RoleCurrent) {
        try {
            $role = \Spatie\Permission\Models\Role::findOrFail($RoleCurrent->id);
            $role->update($RoleCurrent->except('permission'));
            $permissions = $RoleCurrent->input('permission') ? $RoleCurrent->input('permission') : [];
            $role->syncPermissions($permissions);
            Artisan::call('cache:clear');
            Artisan::call('config:cache');
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public static function insertRoles($RoleCurrent) {
        try {
            $role =  \Spatie\Permission\Models\Role::create($RoleCurrent->except('permission'));
            $permissions = $RoleCurrent->input('permission') ? $RoleCurrent->input('permission') : [];
            $role->givePermissionTo($permissions);
            Artisan::call('cache:clear');
            Artisan::call('config:cache');
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public static function deleteRoles($id) {
        try {
            $role = \Spatie\Permission\Models\Role::find($id);
            $role->delete($role->id);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public static function allRolesActive() {
        return \Spatie\Permission\Models\Role::where('status', 1)->orderBy('id', 'DESC')->get();
    }

    public static function RolesActive() {
        return \Spatie\Permission\Models\Role::where('id', 15)->first();
    }

    public static function hasPerFromRole() {
        $flag = false;
        $data = Role::with('permissions')->get();
    }




}
