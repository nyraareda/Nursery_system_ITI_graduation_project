<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCurriculum extends Model
{
    use HasFactory;

    protected $table = 'child_curriculums';

    protected $fillable = [
        'child_id',
        'curriculum_id',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
