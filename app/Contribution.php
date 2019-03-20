<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $fillable = [
        'file_name','std_id','file_status','year','title',
    ];


    public function ayear()
    {
    	return $this->belongsTo(AcademicYear::class, 'year', 'year');
    }

    public function student()
    {
    	return $this->belongsTo(Student::class, 'std_id');
    }


    

}
