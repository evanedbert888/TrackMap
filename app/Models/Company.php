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
}
