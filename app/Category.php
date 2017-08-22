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
        return $this->hasOne('App\CategoryType', 'id', 'category_type_id');
    }

    public function scopeWithCategoryType($query, $name)
    {
        return $query->whereHas(['category_types' => function($q) use($name){
            $q->where('category_type', $name);
        }]);
    }
}
