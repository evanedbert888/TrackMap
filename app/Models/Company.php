<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name', 'business_id', 'address', 'latitude', 'longitude', 'description'
    ];

    public function updateById($id, $data = array())
    {
        return DB::table('companies')->where('id', '=', $id)->update($data);
    }

    public function business() {
        return $this->hasOne(Business::class,'id','business_id');
    }

    public function goals() {
        return $this->hasMany(Goal::class,'company_id','id');
    }

    public function temps() {
        return $this->hasMany(Temp::class,'company_id','id');
    }
}
