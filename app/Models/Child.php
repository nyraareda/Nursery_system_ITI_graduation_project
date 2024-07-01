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
        return $this->belongsTo(Parents::class, 'parent_id');
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
        return $this->hasManyThrough(
            Subject::class,
            ChildCurriculum::class,
            'child_id', // Foreign key on ChildCurriculum table...
            'id', // Foreign key on Subject table...
            'id', // Local key on Child table...
            'curriculum_id' // Local key on ChildCurriculum table...
        );
    }

    public function curriculums()
    {
        return $this->belongsToMany(Curriculum::class, 'child_curriculums', 'child_id', 'curriculum_id')
                    ->withTimestamps();
    }


}
