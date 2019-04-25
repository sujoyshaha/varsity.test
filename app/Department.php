<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
    ];

    public function article(){
        return $this->hasMany(Article::class,"dep_id","id");
    }
}
