<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Admin\PermissionRequest;
use App\Models\General;
use Illuminate\Support\Facades\Lang;
// use mysql_xdevapi\Exception;
use Exception;


class GeneralController extends Controller

{
    public function __construct()
    {
        $this->middleware(['isAdmin'])->except('getParent','getOne');
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

    public function editOne(CategoryRequest $request)
    {

        try {
            //validator
            if (isset($request->validator) && $request->validator->fails()) {
                return response_json(0, "", Lang::get('global.notify_danger'), null, $request->validator->errors());
            }

            Category::updateOne($request);

            return response_json(200, Lang::get('global.msg_edit_success'), Lang::get('global.notify_success'));
        } catch (Exception $ex) {
            dd($ex);
            return response_json(0, Lang::get('global.msg_error'), Lang::get('global.notify_danger'));
        }
    }

    public function getOne()
    {
        $data = General::GetGeneral();
        return view('admin.settings.general',['data' => $data]);
    }

    public function getParent()
    {
        try {
            $data = Category::findParentId(0);
            return response_json(200, "", "", $data);
        } catch (Exception $ex) {
            return response_json(0, Lang::get('global.msg_error'), Lang::get('global.notify_danger'), null, $ex);
        }
    }
}
