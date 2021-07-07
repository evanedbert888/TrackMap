<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Temp extends Model
{
    use HasFactory;
    protected $table = "temps";

    protected $fillable = [
      'user_id', 'employee_id', 'destination_id', 'created_at', 'updated_at'
    ];

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class,'destination_id','id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'employee_id','id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
