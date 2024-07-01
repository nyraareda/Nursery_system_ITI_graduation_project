<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_id',
        'subject_name',
        'description',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id');
    }

    public function children()
    {
        return $this->belongsToMany(Child::class, 'child_subjects', 'subject_id', 'child_curriculum_id');
    }
}
