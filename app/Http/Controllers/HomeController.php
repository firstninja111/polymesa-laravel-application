<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use App\Models\Category;
use App\Models\Media;
use App\Models\User;
use App\Models\Crypto;


class HomeController extends Controller
{
    protected $category;
    protected $media;
    protected $user;
    protected $crypto;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Category $category, Media $media, User $user, Crypto $crypto)
    {
        // $this->middleware('auth');
        $this->category = $category;
        $this->media = $media;
        $this->user = $user;
        $this->crypto = $crypto;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {   
        if($request->path() == '/')
        {
            return view('landing-page');
        }
        if (Auth::check()) {
            

        } else {    // If I am a guest
            if($request->path() != 'media-detail' && $request->path() != 'donate')  // if the page that I want to go is not media detail page and need middleware..
            {
                return redirect()->route('login');
            }
        }

        if (view()->exists($request->path())) {
            return view($request->path());
        }
        return abort(404);
    }
    public function donate()
    {
        $categories = $this->category->query()->get();
        return view('donate', ['categories' => $categories]);
    }

    public function root()
    {
        $medias = $this->media->query()->orderBy('created_at', 'DESC')->get();

        $filteredMedias = array();
        $cnt = 0;
        foreach($medias as $media)
        {
            if($media->approved == 1 && $media->status == 'active' && $media->category->mediaType != "Audio")
            {
                if($cnt == 40){
                    break;
                }
                $cnt++;
                array_push($filteredMedias, $media);
            }
        }
        $categories = $this->category->query()->get();
        return view('landing-page', ['categories' => $categories, 'medias' => $filteredMedias]);
    }

    public function faqs()
    {
        $categories = $this->category->query()->get();
        return view('support/faqs', ['categories' => $categories]);
    }

    public function license()
    {
        $categories = $this->category->query()->get();
        return view('support/license', ['categories' => $categories]);
    }

    public function termsOfService()
    {
        $categories = $this->category->query()->get();
        return view('support/termsOfService', ['categories' => $categories]);
    }

    public function privacyPolicy()
    {
        $categories = $this->category->query()->get();
        return view('support/privacyPolicy', ['categories' => $categories]);
    }

    public function cookiesPolicy()
    {
        $categories = $this->category->query()->get();
        return view('support/cookiesPolicy', ['categories' => $categories]);
    }

    public function aboutUs()
    {
        $categories = $this->category->query()->get();
        return view('support/aboutUs', ['categories' => $categories]);
    }

    public function forum()
    {
        $categories = $this->category->query()->get();
        return view('support/forum', ['categories' => $categories]);
    }

    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function FormSubmit(Request $request)
    {
        return view('form-repeater');
    }

    public function donation(Request $request, $user_id)
    {
        $categories = $this->category->query()->get();
        $cryptos = $this->crypto->query()->get();

        $user = $this->user->query()->where('id', $user_id)->first();
        $user->cryptos = (array)(json_decode($user->cryptoSet));
        
        
        return view('coffee', ['categories' => $categories, 'user' => $user, 'cryptos' => $cryptos]);
    }
}
