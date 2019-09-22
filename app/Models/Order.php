<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Order extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'orders';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['status','abonent_id','total_price', 'delivermen'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function customer(){
        return $this->belongsTo(Abonent::class,'abonent_id');
    }
    public function lines(){
        return $this->hasMany(Order_line::class);
    }
    public function delivermen(){
        return $this->belongsTo(Delivermen::class,'delivermen');
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
}
