<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Model;




class Image extends Model
{



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id','photo','created_at','updated_at'];

    public function _parent(){
        return $this->belongsTo(self::class, 'product_id');
    }


}
