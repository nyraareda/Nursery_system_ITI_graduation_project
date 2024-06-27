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
        'description'
    ];

    
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'subject_id');
    }

    public function enrollments()
    {
        return $this->belongsToMany(Enrollment::class);
    }
}
