<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
class Attribute extends Model
{

    use Translatable;

    /**
     * @var array
     */
    protected $with=["translations"];
    /**
     * @var array
     */
    protected $hidden=["translations"];

    public $translatedAttributes=['name'];

    /**
     * @var array
     */
    protected $guarded=[];



 public  function options(){
        return $this->hasMany(Option::class,'attribute_id');
    }


}
