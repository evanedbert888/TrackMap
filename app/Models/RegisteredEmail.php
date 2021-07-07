<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegisteredEmail extends Model
{
    use HasFactory;

    protected $table = 'registered_emails';
    protected $fillable = [
        'user_id', 'email', 'status'
    ];
    /**
     * @var mixed
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
