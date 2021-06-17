<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Destination extends Model
{
    use HasFactory;
    protected $fillable = [
        'destination_name', 'business_id', 'address', 'latitude', 'longitude', 'description'
    ];

    public function updateById($id, $data = array())
    {
        return DB::table('destinations')->where('id', '=', $id)->update($data);
    }

    public function businessCategories() {
        return $this->hasOne(BusinessCategory::class,'id','business_id');
    }

    public function goals() {
        return $this->hasMany(Goal::class,'destination_id','id');
    }

    public function temps() {
        return $this->hasMany(Temp::class,'destination_id','id');
    }
}
