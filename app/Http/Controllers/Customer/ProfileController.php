<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Crypto;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    protected $user;
    protected $crypto;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user, Crypto $crypto)
    {
        $this->user = $user;
        $this->crypto = $crypto;
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request)
    {
        $user = $this->user->find(Auth::user()->id);
        $user->signinwith = (array)(json_decode($user->signinwith));
        $user->cryptos = (array)(json_decode($user->cryptoSet));
        $user->communication = (array)(json_decode($user->communication));
        $user->emailNotification = (array)(json_decode($user->emailNotification));

        $cryptos = $this->crypto->query()->get();

        return view('contacts-profile', ['user' => $user, 'cryptos' => $cryptos]);
    }

    public function edit(Request $request)
    {
        $user = $this->user->find(Auth::user()->id);
        $user->signinwiths = (array)(json_decode($user->signinwith));
        $user->cryptos = (array)(json_decode($user->cryptoSet));
        $user->communications = (array)(json_decode($user->communication));
        $user->emailNotifications = (array)(json_decode($user->emailNotification));

        $cryptos = $this->crypto->query()->get();

        return view('contacts-profile-edit', ['user' => $user, 'cryptos' => $cryptos]);
    }

    public function update(Request $request)
    {
        $file = $request->file('profile_pic');
        $data = array(
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'gender' => $request->gender,
            'city' => $request->city,
            'country' => $request->country,
            'birthdate' => $request->birthdate,
            'bio' => $request->bio,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'soundcloud' => $request->soundcloud,
            'youtube' => $request->youtube,
            'website' => $request->website,
            'patreon' => $request->patreon,
            'signinwith' => $request->signinwith,
            'communication' => $request->communication,
            'emailNotification' => $request->emailNotification,
            'cryptoSet' => $request->cryptoSet,
            'paypal' => $request->paypal,
            'stripe' => $request->stripe,
            'zelle' => $request->zelle,
            'venmo' => $request->venmo,
            'cashapp' => $request->cashapp,
        );
        
        if($file) {
            $fileName = time().'_'.$file->getClientOriginalName();
            $data['avatar'] = 'public/assets/images/users/'. $fileName;
            $file->move('public/assets/images/users/', $fileName);
        } else {
            
        }

        if($request->password != '')
        {
            $data['password'] = Hash::make($request->password);
        }

        $this->user->find(Auth::user()->id)->update($data);
        return redirect()->route('contacts-profile')->with('success', 'Profile is updated.');
    }

    public function changeStatus(Request $request)
    {
        $this->user->find(Auth::user()->id)->update([
            'status' => $request->status,
        ]);
        return json_encode("success");
    }
}
