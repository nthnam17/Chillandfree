<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Lang;
use mysql_xdevapi\Exception;


class UsersController extends Controller

{
    public function __construct() {
        $this->middleware(['isAdmin'])->except('getOne', 'resetPassword','getList');
    }

    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function getList(Request $request)
    {
        if($request->ajax()){
            $data = User::DataUsers($request);


            return response_json(200, "", "", $data);
        }else{
            return view('admin.users.list');
        }
    }

    public function getOne(Request $request){
        $user = User::getUserById($request->id);
        return response_json(200, "", "", $user);
    }

    public function updateUser(UserRequest $request) {
        try {
            //validator
            if (isset($request->validator) && $request->validator->fails()) {
                return response_json(0, "", "danger", null, $request->validator->errors());
            }

            User::updateUser($request);

            return response_json(200, Lang::get('global.msg_edit_success'), Lang::get('global.notify_success'));
        } catch (\Exception $ex) {
            return response_json(0, Lang::get('global.msg_error'), Lang::get('global.notify_danger'), null, $ex);
        }
    }

    public function delUser(Request $request) {
        try {
            User::deleteUser($request->id);

            return response_json(200,  Lang::get('global.msg_delete_success'), Lang::get('global.notify_success'));

        } catch (\Exception $ex) {
            return response_json(0, Lang::get('global.msg_error'), Lang::get('global.notify_danger'), null, $ex);
        }
    }

    public function addUser(UserRequest $request) {
        try {
            //validator
            if (isset($request->validator) && $request->validator->fails()) {
                return response_json(0, "", Lang::get('global.notify_danger'), null, $request->validator->errors());
            }

            User::insertUser($request);

            return response_json(200, Lang::get('global.msg_add_user_success'), Lang::get('global.notify_success'));
        } catch (\Exception $ex) {
            return response_json(0,  Lang::get('global.msg_error'), Lang::get('global.notify_danger'), null, $ex);
        }

    }

    public function resetPassword(Request $request)
    {
        $password = 123456;
        if ($request->all()['id']) {
            try {
                User::resetPassword($request->all()['id'], $password);
                return response_json(200, "Làm mới mật khẩu thành công!","",'');
            } catch (\Exception $ex) {
                return response_json(0, Lang::get('global.msg_error'), Lang::get('global.notify_danger'), null, $ex);
            }
        }
    }
}
