<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temp extends Model
{
    use HasFactory;
    protected $fillable = [
      'sales_id', 'company_id', 'created_at', 'updated_at'
    ];
}
