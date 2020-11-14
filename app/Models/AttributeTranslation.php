<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeTranslation extends Model
{
    /**
     * @var array
     */
    protected $fillable=['name'];
    public $timestamps=false;
}
