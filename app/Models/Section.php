<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model
{
    use HasFactory;
    protected $table = 'sections';

    protected $fillable = [
        'section_name'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'section_id','id');
    }
}
