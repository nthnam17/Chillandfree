<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class HomesController extends Controller

{
       /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function index() {

        return view('admin.layout.index');
    }

}
