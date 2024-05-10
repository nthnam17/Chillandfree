<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RegisterRequest;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Lang;

//use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    private static $MSG_LOGIN_ERROR = 'Sai username hoặc password!';
    private static $MSG_LOGIN_SUCCESS = 'Đăng nhập thành công';

    use AuthenticatesUsers;



    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function postLogin(Request $request)
    {
        try {
            $login = array(
                'username'      => $request->username,
                'password'      => $request->password,
                'status'        => 1
            );
            $flag = $request->remember==1 ? true : false;
            if(Auth::guard('web')->attempt($login, $flag)){
                Log::info('User '.Auth::user()->username.' has logged in');
                return response_json(200, static::$MSG_LOGIN_SUCCESS, "success");
            }else{
                return  response_json(0, static::$MSG_LOGIN_ERROR, "danger");
            }
        } catch (\Exception $e) {
            return  response_json(0, $e->getMessage(), "danger");
        }
    }

    public function getLogin() {
        return view('admin.login');
    }

    public function logout(){
        Log::info('User '.Auth::user()->email.' has logged out');
        Auth::guard('web')->logout();
        Artisan::call('cache:clear');
        return redirect('login');
    }
}
