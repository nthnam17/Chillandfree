<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Package;


class MenusController extends Controller

{
       /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function index() {
        return view('admin.settings.menu');
    }

}
