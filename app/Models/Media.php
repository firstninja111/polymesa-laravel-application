<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;
use Auth;
use App\Models\category;


class Media extends Authenticatable
{
    use HasFactory, Notifiable;
    // use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table  = 'medias';

    protected $fillable = [
        'userId', 'title', 'categoryId', 'subcategoryId', 'path', 
        'video_640', 'video_1280', 'video_1920', 
        'height_640', 'height_1280', 'height_1920', 'width_org', 'height_org',
        'bytes_640', 'bytes_1280', 'bytes_1920', 'bytes_org',
        'taglist', 'views', 'downloads', 'shares', 'duration', 'approved', 'status'
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
    
    public function user()
    {
      return $this->belongsTo('App\Models\User', 'userId');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'categoryId');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\Models\Subcategory', 'subcategoryId');
    }

    public function getLikedAttribute($value) {
        $media_id = $this->attributes['id'];
        return DB::table('media_rates')->where('mediaId', $media_id)->sum('liked');
    }

    public function getCommentedAttribute($value) {
        $media_id = $this->attributes['id'];
        return DB::table('media_comments')->where('mediaId', $media_id)->get()->count();
    }

    public function getVotedByMeAttribute($value) {
        $media_id = $this->attributes['id'];
        $result = DB::table('media_rates')->where('mediaId', $media_id)->where('userId', Auth::user()->id)->first();

        if($result == NULL)
            return false;
        if($result->voted == 0)
            return false;
        return true;
    }

    public function getAcceptedAttribute($value) {
        $media_id = $this->attributes['id'];
        return DB::table('media_rates')->where('mediaId', $media_id)->where('voted', 1)->get()->count();
    }

    public function getDeclinedAttribute($value) {
        $media_id = $this->attributes['id'];
        return DB::table('media_rates')->where('mediaId', $media_id)->where('voted', -1)->get()->count();
    }

    public function getDayDifferenceAttribute($value) { // Count the days passed from published for the first time.
        $created_at = $this->attributes['created_at'];
        return (strtotime(date('Y-m-d H:i:s')) - strtotime($created_at)) / 24 / 60 / 60;
    }
}
