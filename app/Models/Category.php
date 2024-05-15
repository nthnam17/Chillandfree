<?php

namespace App\Models;

use App\Models\User;
use Astrotomic\Translatable\Translatable;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    static $PAGE_SIZE = 10;
    
    protected $table = 'category';

    protected $fillable = ['name', 'slug', 'add_head', 'description', 'position', 'status', 'parent_id'];

    public static function getList($request)
    {
        $page_size = $request->page_size ?? self::$PAGE_SIZE;
        $data = Category::select('category.*');

        if ($request->title) $data->where('category.title', 'like', "%{$request->title}%");
        if ($request->status) $data->where('category.status', $request->status);

        $data = $data->orderBy('category.id', 'DESC')
            ->paginate($page_size);

        return $data;
    }

    public static function insertOne($request)
    {
        try {
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public static function editProfile($profile)
    {
        try {
            $user = User::find($profile->id);
            $user->name = $profile->name;
            $user->username = $profile->username;
            $user->email = $profile->email;
            if (!is_null($profile->password)) {
                $user->password = bcrypt($profile->password);
            }

            $user->save();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

}
