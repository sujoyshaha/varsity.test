<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'file_name','std_id','file_status','year','title','dep_id'
    ];


    public function ayear()
    {
    	return $this->belongsTo(AcademicYear::class, 'year', 'year');
    }

    public function student()
    {
    	return $this->belongsTo(Student::class, 'std_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dep_id');
    }
// public function artimg()
//     {
//         return $this->belongsTo(ArtImg::class, 'photo');
//     }


    

}
