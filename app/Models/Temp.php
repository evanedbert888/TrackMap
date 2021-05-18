<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temp extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id', 'employee_id', 'company_id', 'created_at', 'updated_at'
    ];

    public function company() {
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function employee() {
        return $this->belongsTo(Employee::class,'employee_id','id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
