<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'full_name',
        'birthdate',
        'place_of_birth',
        'gender',
        'current_residence',
        'photo',
    ];

    public function parent()
    {
        return $this->belongsTo(Parents::class, 'parent_id') ;
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function subjects()
    {
        return $this->hasManyThrough(Subject::class, Grade::class, 'child_id', 'id', 'id', 'subject_id');
    }
}
