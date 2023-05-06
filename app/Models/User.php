<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;
use Carbon\Carbon;


class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'firstname', 'lastname', 'email', 'password', 'role', 'gender', 'avatar', 'city', 'country', 'birthdate', 'bio',
        'facebook', 'twitter', 'instagram', 'soundcloud', 'youtube', 'website', 'patereon', 'signinwith', 'communication', 'emailNotification',
        'cryptoSet', 'paypal', 'stripe', 'zelle', 'venmo', 'cashapp', 'userType', 
        'status',
        'token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getUploadedAttribute($value) {
        $user_id = $this->attributes['id'];
        return DB::table('medias')->where('userId', $user_id)->count();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function getLimitAttribute($value)
    {
        $userType = $this->attributes['userType'];
        return Setting($userType);
    }
}
