<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use DB;
// use App\Models\Category;

class DictionaryController extends Controller
{
    protected $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function english(Request $request)
    {
        $dictionary = DB::table('english_dictionary')->get();
        return view('dictionary', ['title' => 'English Dictionary', 'dictionary' => $dictionary]);
    }
    public function spanish(Request $request)
    {
        // $users_fetch = $this->user->query()->where('role', 'customer')->get();
        
        return view('dictionary', ['title' => 'Spanish Dictionary']);
    }
    public function french(Request $request)
    {
        // $users_fetch = $this->user->query()->where('role', 'customer')->get();
        
        return view('dictionary', ['title' => 'French Dictionary']);
    }
    public function serbian(Request $request)
    {
        // $users_fetch = $this->user->query()->where('role', 'customer')->get();
        
        return view('dictionary', ['title' => 'Serbian Dictionary']);
    }

}
