<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $fillable = [
        'file_name','std_id','file_status','year','title',
    ];


    public function acyear()
    {
    	return $this->belongsTo(AcademicYear::class, 'year');
    }

}
