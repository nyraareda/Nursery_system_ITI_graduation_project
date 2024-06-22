<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'subject_id',
        'grade'
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
