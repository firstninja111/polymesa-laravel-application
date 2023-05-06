<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Media;
use Auth;
use DB;

class Category extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table  = 'categories';
    
    protected $fillable = [
        'id', 'name', 'className', 'mediaType', 'width', 'height', 'description', 'delete_flag'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function getMyMediaAttribute($value)     // This is model function for user dashboard
    {
        $category_id = $this->attributes['id'];
        return Media::query()->where('userId', Auth::user()->id)->where('categoryId', $category_id)->orderBy('created_at', 'DESC')->get();
    }
    
    public function getAllMediaAttribute($value)        // This is model function for admin dashbaord
    {
        $category_id = $this->attributes['id'];
        return Media::query()->where('categoryId', $category_id)->where('approved', 1)->orderBy('created_at', 'DESC')->get();
    }

    
}
