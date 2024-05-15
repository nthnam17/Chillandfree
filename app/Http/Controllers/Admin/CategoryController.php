<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Admin\PermissionRequest;
use Illuminate\Support\Facades\Lang;
// use mysql_xdevapi\Exception;
use Exception;


class CategoryController extends Controller

{
    public function __construct()
    {
        $this->middleware(['isAdmin'])->except('editOne');
    }
    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {
        return view('admin.category.index');
    }

    public function getList(Request $request)
    {

        if ($request->ajax()) {
            $data = Category::getList($request);
            return response_json(200, "", "", $data);
        } else {
            return view('admin.category.index');
        }
    }

    // public function addPermission(PermissionRequest $request)
    // {
    //     try {
    //         //validator
    //         if (isset($request->validator) && $request->validator->fails()) {
    //             return response_json(0, "", Lang::get('global.notify_danger'), null, $request->validator->errors());
    //         }

    //         Permission::insertPermission($request);

    //         return response_json(200, Lang::get('global.msg_add_success'), Lang::get('global.notify_success'));
    //     } catch (Exception $ex) {
    //         dd($ex);
    //         return response_json(0,  Lang::get('global.msg_error'), Lang::get('global.notify_danger'));
    //     }
    // }

    // public function editOne(PermissionRequest $request)
    // {

    //     try {
    //         //validator
    //         if (isset($request->validator) && $request->validator->fails()) {
    //             return response_json(0, "", Lang::get('global.notify_danger'), null, $request->validator->errors());
    //         }

    //         Permission::updatePermission($request);

    //         return response_json(200, Lang::get('global.msg_edit_success'), Lang::get('global.notify_success'));
    //     } catch (Exception $ex) {
    //         return response_json(0, Lang::get('global.msg_error'), Lang::get('global.notify_danger'));
    //     }
    // }

    // public function delPermission(Request $request)
    // {
    //     try {
    //         Permission::deletePermission($request->id);

    //         return response_json(200,  Lang::get('global.msg_delete_success'), Lang::get('global.notify_success'));
    //     } catch (Exception $ex) {
    //         return response_json(0, Lang::get('global.msg_error'), Lang::get('global.notify_danger'));
    //     }
    // }

    // public function getOne(Request $request)
    // {
    //     try {
    //         $permission = Permission::findPermission($request->id);
    //         return response_json(200, "", "", $permission);
    //     } catch (Exception $ex) {
    //         return response_json(0, Lang::get('global.msg_error'), Lang::get('global.notify_danger'), null, $ex);
    //     }
    // }

    // public function parentPer()
    // {
    //     try {
    //         $permission = Permission::findParentId(0);
    //         return response_json(200, "", "", $permission);
    //     } catch (Exception $ex) {
    //         return response_json(0, Lang::get('global.msg_error'), Lang::get('global.notify_danger'), null, $ex);
    //     }
    // }
}
