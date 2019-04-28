<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'art_id','user_id','comment','user_role',
    ];

    public function student() {
        return $this->belongsTo(Student::class, 'user_id');
    }
 public function admin() {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    public function coordinator() {
        return $this->belongsTo(Coordinator::class, 'user_id');
    }

    public function con() {
        return $this->belongsTo(Article::class, 'con_id');
    }

    public $timestamps = true;
}
