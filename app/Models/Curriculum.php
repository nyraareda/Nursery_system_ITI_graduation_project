<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $fillable = ['level', 'description'];
    protected $table = 'curriculums'; 

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'curriculum_id');
    }

    public function children()
    {
        return $this->belongsToMany(Child::class, 'child_curriculums', 'curriculum_id', 'child_id')
                    ->withTimestamps();
    }
}
