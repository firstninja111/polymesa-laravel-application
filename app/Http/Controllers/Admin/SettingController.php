<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Setting;

class SettingController extends Controller
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
    public function index(Request $request)
    {
        // $users_fetch = $this->user->query()->where('role', 'customer')->get();
        
        return view('settings', []);
    }

    public function update(Request $request)
    {
        $data = [
            'freshman'=> $request->freshman,
            'junior'=> $request->junior,            
            'senior'=> $request->senior,
            'minimumLikes'=> $request->minimumLikes,
          ];
        $this->updateSettings($data);

        return redirect()->back()->with('success', 'Settings saved successfully');
    }

    
    private function updateSettings($input)
    {
        foreach ($input as $key => $value) {
            setting([$key => $value])->save();
        }
    }
}
