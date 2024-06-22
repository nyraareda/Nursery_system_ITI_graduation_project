<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'activity_name',
        'description'
    ];

    public function classes()
    {
        return $this->belongsTo(Classes::class);
    }
}
