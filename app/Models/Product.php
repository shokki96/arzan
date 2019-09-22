<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Product extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'products';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'title',
        'title_ru',
        'title_en',
        'description',
        'description_ru',
        'description_en',
        'images',
        'price',
        'locationP',//'locationC',
        'phone',
        'categoryP',
        'categoryC',
        'colors',
        'size',
        'quantity',
        'quantity_attribute_en',
        'quantity_attribute_ru',
        'quantity_attribute'
    ];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'images' => 'array'
    ];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */


public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            if (count((array)$obj->images)) {
                foreach ($obj->images as $file_path) {
                    \Storage::disk('uploads')->delete($file_path);
                }
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
  // public function client(){
  //       return $this->belongsTo(Abonent::class,'abonent_id');
  //   }
    public function location(){
        return $this->belongsTo(Location::class,'locationP');
    }

//    public function location_child(){
//        return $this->belongsTo(Location::class,'locationC');
//    }

    public function category(){
        return $this->belongsTo(Category::class,'categoryP');
    }

    public function subCategory(){
        return $this->belongsTo(Category::class,'categoryC');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

  public function uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path)
    {
        $request = \Request::instance();
        $attribute_value = (array) $this->{$attribute_name};
        $files_to_clear = $request->get('clear_'.$attribute_name);
        // if a file has been marked for removal,
        // delete it from the disk and from the db
        if ($files_to_clear) {
            $attribute_value = (array) $this->{$attribute_name};
            foreach ($files_to_clear as $key => $filename) {
                \Storage::disk($disk)->delete($filename);
                $attribute_value = array_where($attribute_value, function ($value, $key) use ($filename) {
                    return $value != $filename;
                });
            }
        }
        // if a new file is uploaded, store it on disk and its filename in the database
        if ($request->hasFile($attribute_name)) {
            foreach ($request->file($attribute_name) as $file) {
                if ($file->isValid()) {
                    // 1. Generate a new file name
                    $new_file_name = $file->getClientOriginalName();
                    // 2. Move the new file to the correct path
                    $file_path = $file->storeAs($destination_path, $new_file_name, $disk);
                    // 3. Add the public path to the database
                    $attribute_value[] = $file_path;
                }
            }
        }
        $this->attributes[$attribute_name] = json_encode($attribute_value);
    }


public function setImagesAttribute($value)
    {
        $attribute_name = "images";
        $disk = "uploads";
        $destination_path = "/Images";

        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
    }




}
