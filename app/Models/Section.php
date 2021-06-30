<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_name'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class,'section_id','id');
    }
}
