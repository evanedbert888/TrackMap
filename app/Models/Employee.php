<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'role_id', 'motto'
    ];

    public function role() {
        return $this->hasOne(Role::class,'role_id','role_id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function temps() {
        return $this->hasMany(Temp::class, 'employee_id', 'id');
    }
}
