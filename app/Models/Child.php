<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Parents;

class Child extends Model
{

    protected $fillable = [
        'parent_id',
        'full_name',
        'birthdate',
        'place_of_birth',
        'gender',
        'photo',
        'current_residence',
        
    ];
    public function parent(){
        return $this->belongsTo(Parents::class, 'parent_id');
    }


    public function applications()
    {
        return $this->hasMany(Application::class, 'child_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
