<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'section_id', 'motto'
    ];

    public function updateById($id, $data = array())
    {
        return DB::table('employees')->where('id', '=', $id)->update($data);
    }

    public function section() {
        return $this->hasOne(Section::class,'id','section_id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function temps() {
        return $this->hasMany(Temp::class, 'employee_id', 'id');
    }

    public function goals() {
        return $this->hasMany(Goal::class, 'employee_id', 'id');
    }

    public function schedule() {
        return $this->hasMany(Goal::class, 'employee_id', 'id');
    }
}
