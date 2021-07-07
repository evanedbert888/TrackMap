<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    use HasFactory;
    protected $table = 'destinations';
    protected $fillable = [
        'destination_name', 'business_id', 'address', 'latitude', 'longitude', 'description'
    ];

    public function updateById($id, $data = array()): int
    {
        return DB::table('destinations')->where('id', '=', $id)->update($data);
    }

    public function businessCategories(): HasOne
    {
        return $this->hasOne(BusinessCategory::class,'id','business_id');
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class,'destination_id','id');
    }

    public function schedule(): HasMany
    {
        return $this->hasMany(Goal::class,'destination_id','id');
    }

    public function temps(): HasMany
    {
        return $this->hasMany(Temp::class,'destination_id','id');
    }
}
