<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    protected $table = 'main_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'trans_lang', 'trans_of', 'name', 'slug', 'photo', 'active'
    ];

    public function scopeActive($query)
    {
        return $query->where("active", 1);
    }

    public function getActive(){
        return $this->active == 1 ? "مفعل": "غير مفعل ";
    }

    public function languages(){
        return $this->hasMany(self::class, 'trans_of');
    }
}
