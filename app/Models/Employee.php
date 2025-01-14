<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'name'
    ];

    // Shiftとのリレーション
    public function shift()
    {
        return $this->hasMany(Shift::class, 'employee_id');
    }
}
