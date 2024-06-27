<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'curriculum_id', 
        'subject_name',
        'description'
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id'); 
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'subject_id');
    }
}
