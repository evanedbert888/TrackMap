<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temp extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id', 'employee_id', 'destination_id', 'created_at', 'updated_at'
    ];

    public function destination() {
        return $this->belongsTo(Destination::class,'destination_id','id');
    }

    public function employee() {
        return $this->belongsTo(Employee::class,'employee_id','id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
