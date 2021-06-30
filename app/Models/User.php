<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'age', 'sex', 'role', 'birth_date', 'address', 'image'
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

    public function isAdmin(): bool
    {
        return $this->role == 'admin';
    }

    public function isEmployee(): bool
    {
        return $this->role == 'employee';
    }

    public function updateById($id, $data = array())
    {
        return DB::table('users')->where('id', '=', $id)->update($data);
    }

    public function employee() {
        return $this->hasOne(Employee::class,'user_id','id');
    }

    public function temps() {
        return $this->hasMany(Temp::class, 'user_id', 'id');
    }

    public function registeredEmails() {
        return $this->hasMany(RegisteredEmail::class, 'user_id', 'id');
    }

    public function goals() {
        return $this->hasMany(Goal::class, 'user_id', 'id');
    }
}
