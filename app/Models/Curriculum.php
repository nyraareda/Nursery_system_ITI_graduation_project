<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'description'
    ];

    protected $table = 'curriculums';

    public function classes()
    {
        return $this->hasMany(Classes::class, 'curriculum_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'level_id');
    }

    public function activities()
    {
        return $this->hasManyThrough(Activity::class, Classes::class, 'curriculum_id', 'class_id');
    }
}
