<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessCategory extends Model
{
    use HasFactory;
    protected $table = 'business_categories';

    protected $fillable = [
        'name'
    ];
    /**
     * @var mixed
     */
    private $name;

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class,'id','business_id');
    }
}
