<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';

    protected $fillable = [
        'user_id', 'section_id', 'motto'
    ];

    public function updateById($id, $data = array()): int
    {
        return DB::table('employees')->where('id', '=', $id)->update($data);
    }

    public function section(): HasOne
    {
        return $this->hasOne(Section::class,'id','section_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function temps(): HasMany
    {
        return $this->hasMany(Temp::class, 'employee_id', 'id');
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class, 'employee_id', 'id');
    }

    public function schedule(): HasMany
    {
        return $this->hasMany(Goal::class, 'employee_id', 'id');
    }
}
