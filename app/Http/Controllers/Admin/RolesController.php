<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Http\Requests\Admin\RolesRequest;
use Illuminate\Support\Facades\Lang;

class RolesController extends Controller    
{
    public function __construct()
    {
        $this->middleware(['isAdmin'])->except('getRole', 'getList', 'updateRole');
    }

    /**
     * success response method.
     *
     * @return Response
     */

    public function getList(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::DataRoles($request);

            return response_json(200, "", "", $data);
        } else {
            return view('admin.roles.list');
        }
    }

    public function getRole(Request $request)
    {
        $role = Role::getRoleById($request->id);
        $role->permissions = $role->permissions()->pluck('id');
        return response_json(200, "", "", $role);
    }

    public function insertRole(RolesRequest $request)
    {
        try {
            if (isset($request->validator) && $request->validator->fails()) {
                return response_json(0, "", "danger", null, $request->validator->errors());
            }
            Role::insertRoles($request);

            return response_json(200, Lang::get('global.msg_add_success'), Lang::get('global.notify_success'));
        } catch (Exception $ex) {
            return response_json(0, Lang::get('global.msg_error'), Lang::get('global.notify_danger'));
        }
    }

    public function updateRole(Request $request)
    {
        try {
            if (isset($request->validator) && $request->validator->fails()) {
                return response_json(0, "", Lang::get('global.notify_danger'), null, $request->validator->errors());
            }

            Role::updateRoles($request);

            return response_json(200, Lang::get('global.msg_edit_success'), Lang::get('global.notify_success'));
        } catch (Exception $ex) {
            return response_json(0, Lang::get('global.msg_error'), Lang::get('global.notify_danger'));
        }
    }

    public function delRole(Request $request)
    {
        try {
            Role::deleteRoles($request->id);
            return response_json(200, Lang::get('global.msg_delete_success'), Lang::get('global.notify_success'));
        } catch (Exception $ex) {
            return response_json(0, Lang::get('global.msg_error'), Lang::get('global.notify_danger'), null, $ex);
        }

    }
}
