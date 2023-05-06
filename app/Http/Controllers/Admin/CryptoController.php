<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use App\Models\Crypto;

class CryptoController extends Controller
{
    protected $crypto;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Crypto $crypto)
    {
        $this->crypto = $crypto;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $cryptos_fetch = $this->crypto->query()->orderBy('created_at', 'DESC')->get();
        
        return view('cryptos', ['cryptos_fetch' => $cryptos_fetch]);
    }

    public function addCrypto(Request $request)
    {
        $name = str_replace(' ', '', $request->name);
        $cnt = $this->crypto->query()->where('name', $name)->get()->count();
        if($cnt != 0)
            return redirect()->back()->with('warning', 'Duplicate Crypto Name');

        $this->crypto->create([
            'name' => $name,
        ]);

        return redirect()->back()->with('success', 'New crypto is added.');
    }

    public function destroy($id)
    {
        $this->crypto->find($id)->delete();
        return redirect()->back()->with('success', 'Crypto is deleted.');
    }
}
