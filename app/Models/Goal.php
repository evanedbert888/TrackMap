<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id', 'employee_id', 'latitude', 'longitude'
    ];

    public function company() {
        return $this->belongsTo(Company::class,'company_id','id');
    }
}
