<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'subject_name',
        'description'
    ];

    public function classes()
    {
        return $this->belongsTo(Classes::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
