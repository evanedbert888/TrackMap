<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Goal extends Model
{
    use HasFactory;
    protected $table = "goals";

    protected $fillable = [
        'user_id', 'employee_id', 'destination_id', 'latitude', 'longitude'
    ];

    public function updateById($id, $data = array())
    {
        return DB::table('goals')->where('id', '=', $id)->update($data);
    }

    public function destination() {
        return $this->belongsTo(Destination::class,'destination_id','id');
    }

    public function employee() {
        return $this->belongsTo(Employee::class,'employee_id','id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
