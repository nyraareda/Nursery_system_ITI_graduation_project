<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'child_id',
        'subject_id',
        'description',
        'date_enrolled',
        'status',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function subjects()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function activities()
    {
        return $this->hasManyThrough(Activity::class, Child::class, 'id', 'child_id', 'child_id', 'id');
    }
    
}
