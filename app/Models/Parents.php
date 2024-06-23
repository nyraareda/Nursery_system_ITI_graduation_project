<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;

    protected $table = 'parents';
    
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'educational_qualification',
        'job_title',
        'workplace',
        'work_phone',
        'personal_phone',
        'address',
        'home_phone',
        'street_number',
        'apartment_number',
    ];

    public function children()
    {
        return $this->hasMany(Child::class, 'parent_id');
    }
}