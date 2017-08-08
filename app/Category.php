<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CategoryType;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function categoryType()
    {
        return $this->hasOne('App\CategoryType', 'category_type_id');
    }
}
