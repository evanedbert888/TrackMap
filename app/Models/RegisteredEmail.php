<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
