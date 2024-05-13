<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;


class Role extends Model {
    static $PAGE_SIZE = 10;

    protected $table = 'roles';
    protected $fillable = [
        'name','status','created_at','updated_at'
    ];

    public static function DataRoles($request) {
        $page_size = $request->page_size ?? self::$PAGE_SIZE;

        $data = \Spatie\Permission\Models\Role::where('name','LIKE','%' . $request->name. '%')->orderBy('id', 'DESC')->paginate($page_size);

        $respon = array(
            'data'=> $data,
            'pagination'=> $data->links()->render()
        );
        return $respon;
    }

    public static function getRoleById($id) {
        return  \Spatie\Permission\Models\Role::find($id);
    }

    public static function updateRoles($request) {
         try {
             $role = \Spatie\Permission\Models\Role::findOrFail($request->id);
             $role->update($request->except('permission'));
             $permissions = $request->input('permission') ? $request->input('permission') : [];
             $role->syncPermissions($permissions);
             Artisan::call('cache:clear');
             Artisan::call('config:cache');
         } catch (\Exception $ex) {
             throw $ex;
         }
//        try {
//            $role = Role::find($request->id);
//            $role->update($request->all());
//
//        } catch (Exception $ex) {
//            throw $ex;
//        }
    }

    public static function insertRoles($request) {
         try {
             $role =  \Spatie\Permission\Models\Role::create($request->except('permission'));
             $permissions = $request->input('permission') ? $request->input('permission') : [];
             $role->givePermissionTo($permissions);
             Artisan::call('cache:clear');
             Artisan::call('config:cache');
         } catch (\Exception $ex) {
             throw $ex;
         }
//        try {
//            $data = [
//                'name' => $request->name,
//                'status' => $request->status,
//            ];
//            Role::create($data);
//        } catch (Exception $ex) {
//            throw $ex;
//        }
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
        $data = \Spatie\Permission\Models\Role::where('status', 1)->orderBy('id', 'DESC')->get();
        return $data;
    }

    public static function RolesActive() {
        return \Spatie\Permission\Models\Role::where('id', 15)->first();
    }

    public static function hasPerFromRole() {
        $flag = false;
        $data = Role::with('permissions')->get();
    }


}
