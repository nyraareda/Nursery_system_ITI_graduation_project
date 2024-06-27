<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [

        'child_id',
        'activity_name',
        'description'
    ];

   

    public function child()
    {
        return $this->belongsTo(Child::class, 'child_id');
    }
}
