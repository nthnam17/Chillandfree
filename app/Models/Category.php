<?php

namespace App\Models;

use App\Models\User;
use Astrotomic\Translatable\Translatable;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    static $PAGE_SIZE = 10;

    protected $table = 'category';

    protected $fillable = ['name', 'slug', 'description', 'position', 'status', 'parent_id', 'created_by', 'updated_by'];

    public static function getList($request)
    {
        $page_size = $request->page_size ?? self::$PAGE_SIZE;
        $data =  Category::select('category.*', DB::raw('COALESCE(parent.name, "root") as parent_name'))
        ->leftJoin('category as parent', 'parent.id', '=', 'category.parent_id');
      
        if ($request->title) $data->where('category.title', 'like', "%{$request->title}%");

        if ($request->status) $data->where('category.status', $request->status);

        $data = $data->orderBy('category.id', 'DESC')
                ->paginate($page_size);

        return $data;
    }

    public static function insertOne($request)
    {
        try {
            $data = [
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'position' => $request->position,
                'status' => $request->status,
                'parent_id' => $request->parent_id,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ];
            Category::create($data);
        } catch (Exception $ex) {
            dd($ex);
            throw $ex;
        }
    }

    public static function findCategory($id)
    {
        try {
            return Category::find($id);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public static function updateOne($request)
    {
        try {
            $cate = Category::find($request->id);
            $data = [
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'position' => $request->position,
                'status' => $request->status,
                'parent_id' => $request->parent_id,
                'updated_by' => auth()->user()->id,
            ];
            $cate->update($data);
        } catch (Exception $ex) {
            dd($ex);
            throw $ex;
        }
    }

    public static function findParentId($parent_id)
    {
        $data = Category::where('parent_id', $parent_id)->get();
        return $data;
    }

    public static function deleteOne($id) {
        try {
            $cate = Category::find($id);
            $cate->delete($cate->id);
        } catch (\Exception $ex) {
            dd($ex);
            throw $ex;
        }
    }
}
