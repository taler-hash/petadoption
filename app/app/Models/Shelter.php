<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Animal;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shelter extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'location'
    ];

    public function animals() {
        return $this->hasMany(Animal::class);
    }

    public function staffs() {
        return $this->hasMany(User::class);
    }

}
