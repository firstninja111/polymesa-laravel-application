<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Crypto;
use Illuminate\Support\Facades\Hash;

use Mail;

class UserController extends Controller
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
        $users_fetch = $this->user->query()->where('role', 'customer')->get();
        return view('users-list', ['users_fetch' => $users_fetch]);
    }

    public function create(Request $request)
    {
        $cryptos = $this->crypto->query()->get();
        return view('user-add', ['cryptos' => $cryptos]);
    }

    public function edit($id)
    {
        $user = $this->user->find($id);
        $user->signinwiths = (array)(json_decode($user->signinwith));
        $user->cryptos = (array)(json_decode($user->cryptoSet));
        $user->communications = (array)(json_decode($user->communication));
        $user->emailNotifications = (array)(json_decode($user->emailNotification));

        $cryptos = $this->crypto->query()->get();
        return view('user-edit', ['cryptos' => $cryptos, 'user' => $user]);
    }
    
    public static function quickRandom($length = 60)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required | unique:users,deleted_at,NULL',
            'email' => 'required | unique:users,deleted_at,NULL',
            'password' => 'required',
            'confirmPassword' => 'required | same:password',
        ]);
        $file = $request->file('profile_pic');

        $data = array(
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
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
            'userType' => $request->userType,
            'status' => 'active',
            'token' => $this->quickRandom(),
        );
        
        if($file) {
            $fileName = time().'_'.$file->getClientOriginalName();
            $data['avatar'] = 'public/assets/images/users/'. $fileName;
            $file->move('public/assets/images/users/', $fileName);
        } else {
            $data['avatar'] = 'public/assets/images/users/default-avatar.png';
        }

        $this->user->create($data);

        return redirect()->route('user-list')->with('success', 'New User Added.');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            // 'username' => 'required | unique:users',
            // 'password' => 'required | min:8',
            // 'confirmPassword' => 'required | min:8 | same:password',
        ]);
        
        $file = $request->file('profile_pic');
        $data = array(
            'username' => $request->username,
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
            'userType' => $request->userType,
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

        $this->user->find($id)->update($data);
        return redirect()->route('user-list')->with('success', 'Account is updated.');
    }

    public function changeStatus(Request $request)
    {
        $this->user->find($request->id)->update([
            'status' => $request->status,
        ]);
        return json_encode("success");
    }

    public function destroy($id)
    {
        $this->user->find($id)->delete();
        return redirect()->back()->with('success', 'User is deleted.');
    }

    public function sendResetEmail(Request $request)
    {
        $validate = $this->validate($request, [
            'email' => 'required',
        ]);

        $user = $this->user->query()->where('email', $request->email)->first();
        if($user == NULL)
            return redirect()->back()->with("warning", "User Email doesn't exist");

        $mail_to = $user->email;
        $token = $user->token;

        $param = array(
            'reset_url' => url('resetPassword'). '?token='. $token,
            'full_name' => $user->firstname == "" ? $user->lastname : $user->firstname,
        );

        Mail::send('email.reset_email', $param, function ($message)  use ($mail_to) {
            $message->to($mail_to, 'Polymesa')->subject('Welcome to Polymesa');
            $message->from('no-reply@polymesa.com', 'Polymesa');
        });

        return redirect()->back()->with("success", "Please check your email inbox or spam folder to reset password.");
    }

    public function resetPassword(Request $request)
    {
        $token = $request->token;
        return view('auth.passwords.changePwd', ['token' => $token]);
    }

    public function changePasswordToken12(Request $request)
    {
        $validate = $this->validate($request, [
            'password' => 'required',
            'password_confirmation' => 'required | same:password',
        ]);
     
        $user = $this->user->where('token', $request->token)->first();
        if($user == NULL)
            return json_encode("Invalid token");
        
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login', ['email' => $user->email])->with('success', 'You have reset password successfully');
    }
}
