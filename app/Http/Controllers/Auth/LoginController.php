<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Session;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function redirectToProvider($provider)
    {
              
        return Socialite::driver($provider)->redirect();
    }

    /**
     * 从Github获取用户信息.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {

        $getInfo = Socialite::driver($provider)->stateless()->user();
     
        $user = $this->createUser($getInfo,$provider);
    
        Session::put('loginName', $user['name']);
        Session::put('picture', $user['picture']);
        Session::put('OAuth',$user['provider']);
        Session::put('OAuth_Id',$user['provider_id']);
        Auth::login($user, true);
        return redirect()->to(url()->previous());
    }
    function createUser($getInfo,$provider){
 
        $user = User::where('provider_id', $getInfo->id)->first();
        if (!$user) {
            $user = User::create([
               'name'     => $getInfo->name,
               'first_Name'=>$getInfo->user['given_name'],
               'last_Name'=>$getInfo->user['family_name'],
               'email'    => $getInfo->email,
               'picture'  => $getInfo->avatar,
               'provider' => $provider,
               'provider_id' => $getInfo->id
           ]);
         }
         return $user;
    }
    public function logout(Request $request) {
        session()->flush();
        Auth::logout();
        return redirect()->to('/');
    }
}
