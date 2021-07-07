<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'name', 'email', 'password', 'age', 'sex', 'job', 'birth_date', 'address', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function findUserAge($date) {
        function formatDate($input,$date) {
            return date($input,strtotime($date));
        }

        $birth_year = formatDate("Y",$date);
        $curr_year = formatDate("Y","now");
        $age = $curr_year - $birth_year;

        $birth_month = formatDate("M",$date);
        $birth_day = formatDate("D",$date);

        $this_date = strtotime($birth_day.'-'.$birth_month.'-'.$curr_year);
        $now_date = strtotime("now");
        if ($now_date < $this_date) {
            $age = $age - 1;
        }

        return $age;
    }

    public function updateById($id, $data = array()): int
    {
        return DB::table('users')->where('id', '=', $id)->update($data);
    }

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class,'user_id','id');
    }

    public function temps(): HasMany
    {
        return $this->hasMany(Temp::class, 'user_id', 'id');
    }

    public function registeredEmails(): HasMany
    {
        return $this->hasMany(RegisteredEmail::class, 'user_id', 'id');
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class, 'user_id', 'id');
    }
}
