<?php namespace App\Models;

use App\CustomClasses\ColectionPaginate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class Permission extends Model {

    static $PAGE_SIZE = 10;

    protected $table = 'permissions';

    protected $fillable = [
        'name', 'slug', 'description', 'parent_id', 'order', 'status', 'guard_name'
    ];

    public function parent()
    {
        return $this->hasOne(Permission::class, 'id', 'parent_id');
    }

    public function manyChildren()
    {
        return $this->hasMany(Permission::class, 'parent_id', 'id')->where('status', 1);
    }

    public static function DataPermission($request) {
        $page_size = $request->page_size ?? self::$PAGE_SIZE;

        $data = Permission::whereLike(['name'], $request->anyField)
                            ->orderBy('parent_id')->orderBy('order')->paginate($page_size);
        foreach ($data as $item) {
            $parent = $item->parent;
            $item->parent_name = is_null($parent) ? 'root' : $parent->name;
        }

        $response = array(
            'data'=> $data,
            'pagination'=> $data->links()->render()
        );
        return $response;
    }

    public static function updatePermission($request) {
        try {
            $permission = Permission::find($request->id);
            $permission->update($request->all());

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public static function insertPermission($request) {
        try {
            $data = [
                'name' => $request->name,
                'guard_name' => 'web',
                'slug' => $request->slug,
                'description' => $request->description,
                'parent_id' => $request->parent_id,
                'order' => $request->order,
                'status' => $request->status,
            ];
            Permission::create($data);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public static function deletePermission($id) {
        try {
            $permission = Permission::find($id);
            $permission->delete($permission->id);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public static function findPermission($id) {
        try {
            return Permission::find($id);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public static function findParentId($parent_id) {
        return Permission::where('parent_id', $parent_id)->where('status', 1)->orderBy('order')->get();
    }


}
