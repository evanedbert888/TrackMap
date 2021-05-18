<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_name'
    ];

    public function company() {
        return $this->belongsTo(Company::class,'id','business_id');
    }
}
