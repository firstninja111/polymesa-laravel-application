<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Media;
use App\Models\Mediarate;
use App\Models\Mediacomment;

use Image;

use File;
use VideoThumbnail;

class MediaController extends Controller
{
    protected $user;
    protected $category;
    protected $media;
    protected $subcategory;
    protected $media_rate;
    protected $media_comment;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user, Category $category, Media $media, Subcategory $subcategory, Mediarate $media_rate, Mediacomment $media_comment)
    {
        $this->user = $user;
        $this->category = $category;
        $this->media = $media;
        $this->subcategory = $subcategory;
        $this->media_rate = $media_rate;
        $this->media_comment = $media_comment;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
    }

    public function upload(Request $request)
    {
        $now = date('Y-m-d');

        if(date('w', strtotime($now)) == '1')
            $start_date = $now;
        else
            $start_date = date('Y-m-d', strtotime("previous monday", strtotime($now)));

        $end_date = date('Y-m-d', strtotime($start_date. ' +6 day'));

        $uploaded_week = $this->media->query()->where('userId', Auth::user()->id)->whereBetween('created_at', [$start_date. ' 00:00:00', $end_date. ' 23:59:59'])->get()->count();

        $remaining_week = Auth::user()->limit - $uploaded_week;

        $categories = $this->category->query()->get();
        $subcategories = [];
        if(count($categories) > 0)
        {
            $subcategories = $this->subcategory->query()->where('parentID', $categories[0]->id)->get();
        }
        return view('upload', ['categories' => $categories, 'subcategories' => $subcategories, 'remaining_week' => $remaining_week]);
    }

    public function curation(Request $request)
    {
        $accepted_me =  $this->media_rate->query()->where('userId', Auth::user()->id)->where('voted', 1)->get()->count();
        $accepted = $this->media_rate->query()->where('voted', 1)->get()->count();

        $declined_me =  $this->media_rate->query()->where('userId', Auth::user()->id)->where('voted', -1)->get()->count();
        $declined = $this->media_rate->query()->where('voted', -1)->get()->count();

        $vote_medias = $this->media->query()->get();
        $media = NULL;
        foreach($vote_medias as $vote_media)
        {
            if($vote_media->voted_by_me == false && $vote_media->approved == 0)
            {
                $media = $vote_media;
                break;
            }
        }
        
        return view('community-voting', ['media' => $media, 'media_cnt' => count($vote_medias), 'accepted' => $accepted, 'declined' => $declined,  'accepted_me' => $accepted_me, 'declined_me' => $declined_me]);
    }

    public function vote(Request $request)
    {
        $mode = $request->action;
        $mediaId = $request->mediaId;

        $media_rate = $this->media_rate->query()->where('userId', Auth::user()->id)->where('mediaId', $mediaId)->first();        
        if($media_rate == NULL)
        {
            $data = array(
                'userId' => Auth::user()->id,
                'mediaId' => $mediaId,
                'voted' => $mode == 'accept' ? 1 : -1,
            );
            $this->media_rate->create($data);
        } else {
            $data = array(
                'voted' => $mode == 'accept' ? 1 : -1,
            );
            $this->media_rate->where('userId', Auth::user()->id)->where('mediaId', $mediaId)->update($data);
        }

        $media = $this->media->query()->where('id', $mediaId)->first();

        if($media->accepted >= Setting('minimumLikes'))
        {
            $media->approved = 1;
            $media->save();
        }

        if($mode == 'accept')
            return redirect()->back()->with('success','You have approved the media');
        else
            return redirect()->back()->with('success', 'You have declined the media');
    }

    public function mediaSetLike(Request $request)
    {
        $mediaId = $request->mediaId;
        $media_rate = $this->media_rate->query()->where('userId', Auth::user()->id)->where('mediaId', $mediaId)->first();
        
        if($media_rate == NULL)
        {
            $data = array(
                'mediaId' => $mediaId,
                'userId' => Auth::user()->id,
                'liked' => 1,
            );
            $this->media_rate->create($data);
        } else {
            $data = array(
                'liked' => ($media_rate->liked == 0 ? 1 : 0),
            );
            $this->media_rate->where('userId', Auth::user()->id)->where('mediaId', $mediaId)->update($data);
        }
        
        return redirect()->back();
    }

    public function mediaAddComment(Request $request)
    {
        $mediaId = $request->mediaId;
        $comment = $request->comment;
        $data = array(
            'userId' => Auth::user()->id,
            'mediaId' => $mediaId,
            'comment' => $comment,
        );

        $this->media_comment->create($data);
        return redirect()->back()->with('Your comment successfully submitted');
    }

    public function mediaDownload(Request $request)
    {
        $mediaID = $request->id;
     
        $media = $this->media->query()->where('id', $mediaID)->first();
        $media->downloads = $media->downloads + 1;
        $media->save();
    }

    public function mediaShare(Request $request)
    {
        $mediaId = $request->id;
        $media = $this->media->query()->where('id', $mediaId)->first();
        $media->shares = $media->shares + 1;
        $media->save();
        
        return json_encode("success");
    }

    public function mediaDetail(Request $request, $id)
    {
        // Add View Count when click this link.

        $media = $this->media->query()->where('id', $id)->first();
        $media->views = $media->views + 1;
        $media->save();

        $categories = $this->category->query()->get();
        
        // Media Detail Info
        $height_640 = 0;
        $height_1280 = 0;
        $height_1920 = 0;
        $size_640 = 0;
        $size_1280 = 0;
        $size_1920 = 0;
        $size_original = 0;
        $final_img_info['width'] = 0;
        $final_img_info['height'] = 0;
        $final_img_info['make'] = 0;
        $final_img_info['model'] = 0;
        $final_img_info['FocalLength'] = 0;
        $final_img_info['ApertureFNumber'] = 0;
        $final_img_info['ShutterSpeedValue'] = 0;
        $final_img_info['ISO'] = 0;
        
        if($media->category->mediaType == "Image")
        {
            $image = 'public/assets/medias/'. $media->path;
            $fileExtension = substr($media->path, strripos($media->path, '.') + 1);
            
            $width = getimagesize($image)[0];
            $height = getimagesize($image)[1];
            
            $exif = @exif_read_data($image, 0, true); 
            $final_img_info['make'] = @$exif['IFD0']['Make'];         
            $final_img_info['model'] = @$exif['IFD0']['Model'];         
            $final_img_info['ApertureFNumber'] = @$exif['COMPUTED']['ApertureFNumber']; 
            $final_img_info['ISO'] = @$exif['EXIF']['ISOSpeedRatings'];  
            $shutterSpeedValue = explode('/', @$exif['EXIF']['ShutterSpeedValue']);
            if(count($shutterSpeedValue) == 2)
                $final_img_info['ShutterSpeedValue'] = intval($shutterSpeedValue[0]) / intval($shutterSpeedValue[1]);
            else
                $final_img_info['ShutterSpeedValue'] = null;

            $focalLength = explode('/', @$exif['EXIF']['FocalLength']);
            if(count($focalLength) == 2)
                $final_img_info['FocalLength'] = intval($focalLength[0]) / intval($focalLength[1]);
            else
                $final_img_info['FocalLength'] = null;

            $final_img_info['width'] = $width;
            $final_img_info['height'] = $height;
            $final_img_info['fileExtension'] = $fileExtension;

            // Get Thumbnail Images Size
            $image_640 = 'public/assets/medias/640_'. $media->path;
            $image_1280 = 'public/assets/medias/1280_'. $media->path;
            $image_1920 = 'public/assets/medias/1920_'. $media->path;
            $image_original = 'public/assets/medias/'. $media->path;


            $height_640 = getimagesize($image_640)[1];
            $height_1280 = getimagesize($image_1280)[1];
            $height_1920 = getimagesize($image_1920)[1];

            // Get Thumbnail File Size
            $fileSize = \File::size($image_640);
            $size_640 = $fileSize / 1024 / 1024 < 1 ? number_format($fileSize / 1024, 0). " KB" : number_format($fileSize / 1024 / 1024, 1). "MB";
            
            $fileSize = \File::size($image_1280);
            $size_1280 = $fileSize / 1024 / 1024 < 1 ? number_format($fileSize / 1024, 0). " KB" : number_format($fileSize / 1024 / 1024, 1). "MB";

            $fileSize = \File::size($image_1920);
            $size_1920 = $fileSize / 1024 / 1024 < 1 ? number_format($fileSize / 1024, 0). " KB" : number_format($fileSize / 1024 / 1024, 1). "MB";

            $fileSize = \File::size($image_original);
            $size_original = $fileSize / 1024 / 1024 < 1 ? number_format($fileSize / 1024, 0). " KB" : number_format($fileSize / 1024 / 1024, 1). "MB";
        } else if($media->category->mediaType == "Video") {
            // $video = 'public/assets/medias/'. $media->path;
            $fileExtension = substr($media->path, strripos($media->path, '.') + 1);
            $final_img_info['fileExtension'] = $fileExtension;

            // Get Video File Sizes
            // $fileSize = \File::size($media->video_640);
            // $size_640 = $fileSize / 1024 / 1024 < 1 ? number_format($fileSize / 1024, 0). " KB" : number_format($fileSize / 1024 / 1024, 1). "MB";
            
            // $fileSize = \File::size($media->video_1280);
            // $size_1280 = $fileSize / 1024 / 1024 < 1 ? number_format($fileSize / 1024, 0). " KB" : number_format($fileSize / 1024 / 1024, 1). "MB";

            // $fileSize = \File::size($media->video_1920);
            // $size_1920 = $fileSize / 1024 / 1024 < 1 ? number_format($fileSize / 1024, 0). " KB" : number_format($fileSize / 1024 / 1024, 1). "MB";

            $fileSize = \File::size('public/assets/medias/'. $media->path);
            $size_original = $fileSize / 1024 / 1024 < 1 ? number_format($fileSize / 1024, 0). " KB" : number_format($fileSize / 1024 / 1024, 1). "MB";

        } else if($media->category->mediaType == "Audio") {
            $fileExtension = substr($media->path, strripos($media->path, '.') + 1);
            $final_img_info['fileExtension'] = $fileExtension;
        }

        // Media Comments
        $comments = $this->media_comment->query()->where('mediaId', $id)->orderBy('created_at', 'DESC')->get();
        
        return view('media-detail', ['id' => $id, 'media' => $media, 'categories' => $categories, 'final_img_info' => $final_img_info, 'comments' => $comments, 
                                    'height_640' => $height_640, 'height_1280' => $height_1280, 'height_1920' => $height_1920, 
                                    'size_640' => $size_640, 'size_1280' => $size_1280, 'size_1920' => $size_1920, 'size_original' => $size_original]);
    }

    public function store(Request $request)
    {
        // Check Uploaded file type
        $media = $request->file('file');
        $extension = $media->extension();

        ini_set('max_execution_time', 600); //600 seconds = 10 minutes

        $final_img_info['video_640'] = '';
        $final_img_info['video_1280'] = '';
        $final_img_info['video_1920'] = '';
        
        switch(strtolower($extension)) {
            case 'jpg': case 'png': case 'jpeg':       // When uploaded file is image
                $image = $request->file('file');
                $width = getimagesize($image)[0];
                $height = getimagesize($image)[1];
                
                $exif = @exif_read_data($image, 0, true); 

                $orientation = @$exif['IFD0']['Orientation'];

                $final_img_info['make'] = @$exif['IFD0']['Make'];         
                $final_img_info['model'] = @$exif['IFD0']['Model'];         
                $final_img_info['ApertureFNumber'] = @$exif['COMPUTED']['ApertureFNumber']; 
                $final_img_info['ISO'] = @$exif['EXIF']['ISOSpeedRatings'];  
                $shutterSpeedValue = explode('/', @$exif['EXIF']['ShutterSpeedValue']);
                if(count($shutterSpeedValue) == 2)
                    $final_img_info['ShutterSpeedValue'] = intval($shutterSpeedValue[0]) / intval($shutterSpeedValue[1]);
                $focalLength = explode('/', @$exif['EXIF']['FocalLength']);
                if(count($focalLength) == 2)
                    $final_img_info['FocalLength'] = intval($focalLength[0]) / intval($focalLength[1]);
                    
                $final_img_info['width'] = $width;
                $final_img_info['height'] = $height;
                $final_img_info['mega_size'] = number_format($image->getSize() / 1024 / 1024, 2);
                $final_img_info['size'] = $image->getSize() / 1024 / 1024;

                if(!empty($orientation))
                {
                    $imageResource = imagecreatefromjpeg($image->getRealpath());
                    switch($orientation) {
                        case 3:
                            $image1 = imagerotate($imageResource, 180, 0);
                            break;
                        case 6:
                            $image1 = imagerotate($imageResource, -90, 0);
                            break;
                        case 8:
                            $image1 = imagerotate($imageResource, 90, 0);
                            break;
                        default:
                            $image1 = $imageResource;
                            break;
                    }
                    imagejpeg($image1, "abc", 90);

                }


                $final_img_info['resolution_error'] = false;
                $final_img_info['size_error'] = false;

                // if($width <= 3000 || $height <= 3000)
                //     $final_img_info['resolution_error'] = true;

                if($final_img_info['size'] > 20)
                    $final_img_info['size_error'] = true;

                $final_img_info['extension'] = $extension;
                $final_img_info['fileType'] = "image";

                if($image && $final_img_info['resolution_error'] == false && $final_img_info['size_error'] == false)
                {
                    $fileName = time().'_'.$image->getClientOriginalName();

                    $image_640 = Image::make($image->getRealPath());
                    $image_640->orientate()
                        ->resize(640, 640, function ($const) {
                        $const->aspectRatio();
                    })->save('public/assets/medias'. '/640_'. $fileName);

                    $image_1280 = Image::make($image->getRealPath());
                    $image_1280->orientate()
                        ->resize(1280, 1280, function ($const) {
                        $const->aspectRatio();
                    })->save('public/assets/medias'. '/1280_'. $fileName);

                    $image_1920 = Image::make($image->getRealPath());
                    $image_1920->orientate()
                        ->resize(1920, 1920, function ($const) {
                        $const->aspectRatio();
                    })->save('public/assets/medias'. '/1920_'. $fileName);

                    $final_img_info['fileName'] = $fileName;
                    $image->move('public/assets/medias/', $fileName);
                }
                break;
            case 'mp3': case 'flac': case 'wav': case 'wma': case 'aac': case 'ogg': case 'oga': case 'm4a':      // When uploaded file is audio
            case 'mp4': case 'avi': case 'mk':
                $final_img_info['length_error'] = false;
                $final_img_info['size_error'] = false;

                $audio = $request->file('file');
                $fileSize = $audio->getSize();

                $final_img_info['size'] = ($fileSize / 1024 / 1024) < 1 ? number_format($fileSize / 1024, 0). " KB" : number_format($fileSize / 1024 / 1024, 1). "MB";
                
                if(strtolower($extension) == "mp3")
                {
                    $audio_obj = new \wapmorgan\Mp3Info\Mp3Info($audio->getRealpath(), true);
                    $duration = $audio_obj->duration;
    
                    $final_img_info['duration_time_format'] = floor($audio_obj->duration / 60). ':'. floor($audio_obj->duration % 60);
                    $final_img_info['duration'] = (floor($audio_obj->duration / 60) != 0 ? floor($audio_obj->duration / 60).' min ' : '') .floor($audio_obj->duration % 60).' sec';
                    if(($duration / 60) > 15)
                        $final_img_info['length_error'] = true;
                } else {
                    $final_img_info['duration_time_format'] = "";
                    $final_img_info['duration'] = "";
                    $final_img_info['length_error'] = false;
                }
                
                if(($fileSize / 1024 / 1024) > 200)
                    $final_img_info['size_error'] = true;

                $final_img_info['extension'] = $extension;
                $final_img_info['fileType'] = "audio";

                if(strtolower($extension) == "mp4" || strtolower($extension) == "avi" || strtolower($extension) == "mk")   //Doesn't need but..
                    $final_img_info['fileType'] = "video";


                if($audio && $final_img_info['length_error'] == false && $final_img_info['size_error'] == false)
                {   

                    $fileName = time().'_'.$audio->getClientOriginalName();
                    
                    $resizedVideo = cloudinary()->uploadVideo($request->file('file')->getRealPath(), [
                        'folder' => 'uploads',
                        'transformation' => [
                                  'width' => 640,
                                  'height' => 640,
                                  'quality' => 'auto', 
                                  'crop' => 'limit',
                         ]
                    ]);
                    $response = $resizedVideo->getResponse();
                    $response_array = (array) $response;
                    $height_640 = $response_array["height"];
                    $bytes_640 = $response_array["bytes"] / 1024 / 1024 < 1 ? number_format($response_array["bytes"] / 1024, 0). " KB" : number_format($response_array["bytes"] / 1024 / 1024, 1). "MB";
                    $video_duration = $response_array["duration"];
                    $resizedVideo_640 = $resizedVideo->getSecurePath();


                    $resizedVideo = cloudinary()->uploadVideo($request->file('file')->getRealPath(), [
                        'folder' => 'uploads',
                        'transformation' => [
                                  'width' => 1280,
                                  'height' => 1280,
                                  'quality' => 'auto', 
                                  'crop' => 'limit',
                         ]
                    ]);
                    $response = $resizedVideo->getResponse();
                    $response_array = (array) $response;
                    $height_1280 = $response_array["height"];
                    $bytes_1280 = $response_array["bytes"] / 1024 / 1024 < 1 ? number_format($response_array["bytes"] / 1024, 0). " KB" : number_format($response_array["bytes"] / 1024 / 1024, 1). "MB";;
                    $resizedVideo_1280 = $resizedVideo->getSecurePath();
                    

                    $resizedVideo = cloudinary()->uploadVideo($request->file('file')->getRealPath(), [
                        'folder' => 'uploads',
                        'transformation' => [
                                  'width' => 1920,
                                  'height' => 1920,
                                  'quality' => 'auto', 
                                  'crop' => 'limit',
                         ]
                    ]);
                    $response = $resizedVideo->getResponse();
                    $response_array = (array) $response;
                    $height_1920 = $response_array["height"];
                    $bytes_1920 = $response_array["bytes"] / 1024 / 1024 < 1 ? number_format($response_array["bytes"] / 1024, 0). " KB" : number_format($response_array["bytes"] / 1024 / 1024, 1). "MB";;
                    $resizedVideo_1920 = $resizedVideo->getSecurePath();


                    $originalVideo = cloudinary()->uploadVideo($request->file('file')->getRealPath(), [
                        'folder' => 'uploads',
                    ]);
                    $response = $originalVideo->getResponse();
                    $response_array = (array) $response;
                    $height_org = $response_array["height"];
                    $width_org = $response_array["width"];
                    $bytes_org = $response_array["bytes"] / 1024 / 1024 < 1 ? number_format($response_array["bytes"] / 1024, 0). " KB" : number_format($response_array["bytes"] / 1024 / 1024, 1). "MB";;
                    $resizedVideo_org = $originalVideo->getSecurePath();
                    
                    if($final_img_info['fileType'] == "video")
                    {
                        $video_duration = (int)$video_duration;
                        $final_img_info['duration_time_format'] = floor($video_duration / 60). ':'. floor($video_duration % 60);
                        $final_img_info['duration'] = (floor($video_duration / 60) != 0 ? floor($video_duration / 60).' min ' : '') .floor($video_duration % 60).' sec';
                        if(($video_duration / 60) > 15)
                            $final_img_info['length_error'] = true;
                    }

                    $final_img_info['video_640'] = $resizedVideo_640;
                    $final_img_info['video_height_640'] = $height_640;
                    $final_img_info['video_bytes_640'] = $bytes_640;

                    $final_img_info['video_1280'] = $resizedVideo_1280;
                    $final_img_info['video_height_1280'] = $height_1280;
                    $final_img_info['video_bytes_1280'] = $bytes_1280;

                    $final_img_info['video_1920'] = $resizedVideo_1920;
                    $final_img_info['video_height_1920'] = $height_1920;
                    $final_img_info['video_bytes_1920'] = $bytes_1920;

                    $final_img_info['video_org'] = $resizedVideo_org;
                    $final_img_info['video_height_org'] = $height_org;
                    $final_img_info['video_width_org'] = $width_org;
                    $final_img_info['video_bytes_org'] = $bytes_org;


                    $final_img_info['fileName'] = $fileName;
                    $audio->move('public/assets/medias/', $fileName);                    
                }
                break;
        }
        return json_encode($final_img_info);
    }

    public function get_property(object $object, string $property) {
        $array = (array) $object;
        $propertyLength = strlen($property);
        foreach ($array as $key => $value) {
            if (substr($key, -$propertyLength) === $property) {
                return $value;
            }
        }
    }

    public function fileDestroy(Request $request)
    {
        $fileName = $request->fileName;
        $path = 'public/assets/medias/'. $fileName;
        $path_640 = 'public/assets/medias/640_'. $fileName;
        $path_1280 = 'public/assets/medias/1280_'. $fileName;
        $path_1920 = 'public/assets/medias/1920_'. $fileName;

        if (file_exists($path)) {
            unlink($path);
        }

        if (file_exists($path_640)) {
            unlink($path_640);
        }
        if (file_exists($path_1280)) {
            unlink($path_1280);
        }
        if (file_exists($path_1920)) {
            unlink($path_1920);
        }
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $media = $this->media->query()->where('id', $id)->first();
        if($media->day_difference > 7 && Auth::user()->role != "admin")
            return json_encode("Media is published more than one week ago.");
        if($media->userId != Auth::user()->id && Auth::user()->role != "admin")
            return json_encode("It is not your media and unable to remove it");
        
        $path = 'public/assets/medias/'. $media->path;
        $path_640 = 'public/assets/medias/640_'. $media->path;
        $path_1280 = 'public/assets/medias/1280_'. $media->path;
        $path_1920 = 'public/assets/medias/1920_'. $media->path;

        if (file_exists($path)) {
            unlink($path);
        }
        if (file_exists($path_640)) {
            unlink($path_640);
        }
        if (file_exists($path_1280)) {
            unlink($path_1280);
        }
        if (file_exists($path_1920)) {
            unlink($path_1920);
        }

        $media->delete();
        $this->media_comment->query()->where('mediaId', $id)->delete();
        $this->media_rate->query()->where('mediaId', $id)->delete();
        
        return json_encode("success");
    }

    public function addMedia(Request $request)
    {
        $userId = Auth::user()->id;
        $categoryId = $request->categoryId;
        $subcategoryId = $request->subcategoryId;
        $path = $request->path;
        $video_640 = $request->video_640;
        $video_1280 = $request->video_1280;
        $video_1920 = $request->video_1920;
        $taglist = $request->taglist; 
        $title = $request->title;
        $mediaType = $request->mediaType; 
        $duration = $request->duration;

        $data = array(
            'userId' => $userId,
            'categoryId' => $categoryId,
            'subcategoryId' => $subcategoryId,
            'path' => $path,
            'video_640' => $video_640,
            'video_1280' => $video_1280,
            'video_1920' => $video_1920,
            'taglist' => $taglist,

            'height_640' => $request->video_height_640,
            'height_1280' => $request->video_height_1280,
            'height_1920' => $request->video_height_1920,
            'width_org' => $request->video_width_org,
            'height_org' => $request->video_height_org,

            'bytes_640' => $request->video_bytes_640,
            'bytes_1280' => $request->video_bytes_1280,
            'bytes_1920' => $request->video_bytes_1920,
            'bytes_org' => $request->video_bytes_org,
        );
        if($mediaType == "Audio"){
            $data['title'] = $title;
            $data['duration'] = $duration;
        }

        $this->media->create($data);
        return json_encode("success");
    }

    public function mediaSearch(Request $request, $id)
    {
        $tagKey = $request->key == NULL ? '%%' : ('%"'. $request->key. '"%');
        $searchKey = $request->key == NULL ? '%%' : ('%'. $request->key. '%');

        
        $medias = $this->media->query()->where('categoryId', $id)->where(function($query) use($searchKey, $tagKey){
            $query->where('taglist', 'LIKE', $tagKey)
                  ->orWhere('title', 'LIKE', $searchKey);
        })->orderBy('created_at', 'DESC')->get();
        
        $filteredMedias = array();
        foreach($medias as $media){
            if($media->approved == 1 && $media->status == 'active'){
                array_push($filteredMedias, $media);
            }
        }

        $mediaType = $this->category->query()->where('id', $id)->first()->mediaType;
        $categories = $this->category->query()->get();

        return view('media-search', ['mediaType' => $mediaType, 'medias' => $filteredMedias, 'categories' => $categories, 'search' => true, 'key' => $request->key, 'id'=> $id]);
    }

    public function mediasByCategory(Request $request)
    {
        $categoryId = $request->category_id;

        $tagKey = $request->key == NULL ? '%%' : ('%"'. $request->key. '"%');
        $searchKey = $request->key == NULL ? '%%' : ('%'. $request->key. '%');
        
        $medias = $this->media->query()->where('categoryId', $categoryId)->where(function($query) use($searchKey, $tagKey){
            $query->where('taglist', 'LIKE', $tagKey)
                  ->orWhere('title', 'LIKE', $searchKey);
        })->orderBy('created_at', 'DESC')->get();

        $filteredMedias = array();
        foreach($medias as $media){
            if($media->approved == 1 && $media->status == 'active'){
                array_push($filteredMedias, $media);
            }
        }

        return json_encode($filteredMedias);
    }

    // ==================  Admin Role Media Page ================== //
    public function adminList(Request $request)
    {
        if($request->start_date == NULL) 
            $request->start_date = date('Y-m-d', strtotime("-6 days"));

        if($request->end_date == NULL)
            $request->end_date = date('Y-m-d');

        $categories = $this->category->query()->get();
        foreach($categories as $category)
        {
            $categoryId = $category->id;
            $medias = $this->media->query()->where('categoryId', $categoryId)->where('approved', 1)->whereBetween('created_at', [$request->start_date. ' 00:00:00', $request->end_date. ' 23:59:59'])->orderBy('created_at', 'DESC')->get();
            $category->filtered_medias = $medias;
        }

        return view('admin-medias', ['categories' => $categories, 'start_date' => $request->start_date, 'end_date' => $request->end_date]);
    }

    public function unapprovedAdminList(Request $request)
    {
        if($request->start_date == NULL) 
            $request->start_date = date('Y-m-d', strtotime("-6 days"));

        if($request->end_date == NULL)
            $request->end_date = date('Y-m-d');

        $categories = $this->category->query()->get();
        foreach($categories as $category)
        {
            $categoryId = $category->id;
            $medias = $this->media->query()->where('categoryId', $categoryId)->where('approved', 0)->whereBetween('created_at', [$request->start_date. ' 00:00:00', $request->end_date. ' 23:59:59'])->orderBy('created_at', 'DESC')->get();
            $category->filtered_medias = $medias;
        }

        return view('admin-medias', ['categories' => $categories, 'start_date' => $request->start_date, 'end_date' => $request->end_date]);
    }

    public function changeStatus(Request $request)
    {
        $media = $this->media->query()->where('id', $request->id)->first();
        $media->status = $request->status;
        $media->save();
    }

    public function staticLink(Request $request, $username)
    {
        $user = $this->user->where('username', $username)->first();
        if($user == NULL)
        {
            $exist = 0;
            return;
        }
        else {
            $user_id = $user->id;
            $exist = 1;
        }

        $categories = $this->category->query()->get();
        foreach($categories as $category)
        {
            $categoryId = $category->id;
            $medias = $this->media->query()->where('userId', $user->id)->where('categoryId', $categoryId)->where('approved', 1)->orderBy('created_at', 'DESC')->get();
            $category->user_medias = $medias;
        }

        $count_all = $this->media->query()->where('userId', $user->id)->get()->count();
        $downloads = $this->media->query()->where('userId', $user->id)->sum('downloads');
        $medias = $this->media->query()->where('userId', $user->id)->get();
        $likes = 0;
        $comments = 0;
        foreach($medias as $media){
            $likes += $media->liked;
            $comments += $media->commented;
        }
        $shares = $this->media->query()->where('userId', $user->id)->sum('shares');

        $popular = $this->media->query()->where('userId', $user->id)
                                        ->where('approved', 1)
                                        ->orderBy('views', 'DESC')->limit(50)->get();

        $latest =  $this->media->query()->where('userId', $user->id)
                                        ->where('approved', 1)
                                        ->orderBy('created_at', 'DESC')
                                        ->limit(50)->get();
        return view('staticlink', ['user' => $user, 'exist' => $exist, 'categories' => $categories, 
                                   'count_all' => $count_all, 'downloads' => $downloads, 'likes' => $likes, 'comments' => $comments, 'shares' => $shares,
                                   'popular' => $popular, 'latest' => $latest,
                                   ]);
    }
}
