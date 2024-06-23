<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_id',
        'class_name',
        'description'
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
