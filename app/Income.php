<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\User;

class Income extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'income_date', 'description', 'amount', 'category_id', 'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function category()
    {
        return $this->hasOne('App\Category', 'category_id')->where("category", "ingreso");
    }

    public function user()
    {
        return $this->hasOne('App\User', 'user_id');
    }
}
