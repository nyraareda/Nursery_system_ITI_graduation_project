<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'child_id',
        'class_id',
        'description',
        'date_enrolled',
        'status',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
