<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Traits\ActivityLogs;
use App\Services\Admindetail;

class AuthenticatedSessionController extends Controller
{
    use ActivityLogs;
    /**
     * Display the login view.
     */
    //login page
    public function create(Admindetail $admin,Request $request): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // logged in user
    public function store(Request $request)
    {
        $request->validate([
            'email'=>['required','email'],
            'password'=>['required']
        ]);
        $user = [
            'email' => $request->email,
            'password' => $request->password
        ];
        //check if user exist and password entered by user is same in our ```records
            //logged In user
            if(Auth::Attempt($user)){

            $request->session()->regenerate();

            if(Auth::user()->hasPermissionTo('admin-dashboard'))
            {            
                Session::flash('success','Welcome , '.ucfirst(Auth::user()->name));
                $this->activity(Auth::user()->name,Auth::user()->email,'Logged In','success');
                return redirect()->route('dashboard');
            }
            elseif(Auth::user()->hasPermissionTo('user-dashboard'))
            {
                return redirect()->route('home');
            }
            else{
                $request->session()->invalidate();
                Session::flash('error','You do not have any permission');
                return redirect()->back();
            }
        }
        else{
            Session::flash('error','Wrong Credentials');
            return redirect()->route('login');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    //logout user
    public function destroy(Request $request): RedirectResponse
    {
        $this->activity(Auth::user()->name,Auth::user()->email,'Logged Out','success');
        if( $request->session()->invalidate())
        {
        $request->session()->regenerateToken();

        return redirect('/');
        }
    }
}
