<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
      'role_name'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class,'role_id','id');
    }
}
