<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Package;


class DashboardController extends Controller

{
       /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function index() {

        return view('admin.layouts.index');
    }

    public function deadline(){
        return view('admin.Deadline.index');
    }

    public function phase(){
        return view('admin.phase.index');
    }

    public function birthday(){
        return view('admin.birthday.index');
    }
}
