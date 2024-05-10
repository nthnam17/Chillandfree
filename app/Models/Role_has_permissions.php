<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Role_has_permissions extends Model
{


    protected $table = 'role_has_permissions';

    public static function hasPermissionByRole($permission_id) {
        return Role_has_permissions::where('role_id', Auth::user()->role_id)->where('permission_id', $permission_id)->first();
    }

    public static function hasPermissionByName($permission_name) {
        $permission = Permission::where('name', $permission_name)->pluck('id')->first();
        return Role_has_permissions::where('role_id', Auth::user()->role_id)->where('permission_id', $permission)->first();
    }

}
