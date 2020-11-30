<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $user=Auth::User();
            if($user->is_active){
                if(in_array(Auth::User()->role,[1,3])){
                    $urusan=DB::table('public.master_urusan')->whereIn('id',[3,4,15,16,20,21,25])->get()->toArray();
                    session(['list_urusan'=>$urusan]);
                    session(['main_urusan'=>$urusan[0]]);
                }else{
                    $uid=$user->id;
                    $urusan=DB::table('public.user_urusan')->whereIn('id_urusan',$uid)->get()->toArray();
                    session(['list_urusan'=>$urusan]);
                    if(isset($urusan[0])){
                        session(['main_urusan'=>$urusan[0]]);

                    }else{
                        Auth::logout();
                    }

                }
            }else{
                Auth::logout();

            }

            $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
