<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'child_id',
        'subject_id', // Assuming this is how you relate enrollment to subjects
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
    
}
