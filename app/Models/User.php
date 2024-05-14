<?php

namespace App\Models;

use App\Models\General;
use App\Models\Groups;
use App\Models\JobTitle;
use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
//use Spatie\Permission\Traits\HasRoles;
use Cache;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;
    static $PAGE_SIZE = 10;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','status', 'phone', 'image','username','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $cast = [
        'email_verified_at' => 'datetime',
    ];



    protected $casts = [
        'group_arr' => 'array'
    ];



    public static function DataUsers($request) {
        $page_size = $request->page_size ?? self::$PAGE_SIZE;

        $data = User::select("users.*", "roles.name as role_name")
            ->leftjoin('roles', 'roles.id', '=', 'users.role_id')
            ->where('users.username',"LIKE",'%'. $request->username. '%');

        if ($request->status != '') {
            $data->where('users.status', '=', $request->status);
        }


        $data = $data->orderBy('id', 'DESC')->paginate($page_size);

        $respon = array(
            'data'=> $data,
            'pagination'=> $data->links()->render()
        );
        return $respon;
    }

    public static function getUserById($id) {
        $user = User::findOrFail($id);
        return $user;
    }

    public static function updateUser($request) {
        try {
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->username = $request->username;
            $user->role_id = $request->role_id;
            $user->updated_by = auth()->user()->id;
            $user->updated_at = Carbon::now();
            $user->image = '/admin/image/boy.png';
            if(!is_null($request->password)) {
                $user->password = bcrypt($request->password);
            }
            $user->status = $request->status;
            $user->save();

            //assignRole to user
//            $roles = $request->role_id ? $request->role_id : [];
//            $user->syncRoles($roles);

            if(!is_null($request->password)) {
                Auth::logoutOtherDevices($request->password);
            }

        } catch (\Exception $ex) {
            dd($ex);
            throw $ex;
        }
    }

    public static function insertUser($request) {

        try {
            $user = User::create($request->all());
            $user->fill([
                'image' => '/admin/image/boy.png',
                'password' => bcrypt($request->password),
                'created_by' => auth()->user()->id
            ])->save();
            return $user;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public static function deleteUser($id) {
        try {
            $user = User::findOrFail($id);
            $user->delete();
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public static function userActive() {
        return User::where('status', 1)
            ->get();
    }

    public static function userLeader() {
        return User::where('status', 1)->where('leader', 1)->get();
    }



    // public static function Roletracking(){
    //     $setting = General::cache_general();
    //     $group_role = $setting->group_role;
    //     return  User::whereIn('role_id',[$group_role])->get();
    // }

    public static function resetPassword($id,$password){
        try {
            $user = User::where('id' , $id)->first();
            $user->update(['password' => bcrypt($password)]);
        } catch (\Exception $ex) {
            dd($ex);
            throw $ex;
        }
    }

    // public static function getAllUserEmploy()
    // {
    //     $data = User::select("users.*")
    //         ->leftJoin('pma_employment', 'pma_employment.acount_login_id', '=', 'users.id')
    //         ->where('users.type_account', '=', 2)
    //         ->where('pma_employment.acount_login_id', '=', null)
    //         ->where('users.status', '=', 1)
    //         ->get();

    //     return $data;
    // }






}
