<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Parents; // Make sure to import the Parents model

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
        // Add any other attributes that you want to allow mass assignment for
    ];
    public function parent(){
        return $this->belongsTo(Parents::class, 'parent_id');
    }

    public function application()
    {
        return $this->hasOne(Application::class);
    }
}
