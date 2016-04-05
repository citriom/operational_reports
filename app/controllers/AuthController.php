<?php

class AuthController extends BaseController {


    public function showLogin()
    {
        // If there's an active session
        if (Auth::check())
        {
            // Show Index
            return Redirect::to('/');
        }
        // Show Login
        return View::make('login');
    }

    public function postLogin()
    {
        // Get data from Login
        $data = [
            'username' => Input::get('username'),
            'password' => Input::get('password')
        ];

        // Verify Data
        if (Auth::attempt($data, Input::get('remember'))) // Remember me?
        {
	    Session::put('user', $data);
            // User Data is correct
            return Redirect::intended('/');
        }
        // Error
        return Redirect::back()->with('error_message', 'Error: Username or password invalid')->withInput();
    }

    public function logOut()
    {
        // Logout
        Auth::logout();
        // Return to login form
        return Redirect::to('login')->with('error_message', 'Logged out correctly');
    }

    public function getGoogleLogin($auth=NULL)
    {
        if ($auth == 'auth')
        {
             Hybrid_Endpoint::process();

        }
        try {
            $oauth = new Hybrid_Auth(app_path() . '/config/google_auth.php');
            $provider = $oauth->authenticate('Google');
            $profile = $provider->getUserProfile();
        }
        catch(exception $e)
        {
            return $e->getMessage();
        }
        $user = User::where('email', $profile->email)->first();
        if( $user!=NULL ){
            $data = [
                'username' => $user->username,
                'password' => $user->password
            ];
            Session::put('user', $data);
            return Redirect::intended('/');
        }
    	else{
    	    $oauth->logoutAllProviders();
    	    Session::flash('error_message', 'Error: This user has no Privileges');
    	    return View::make('xlogin');
    	}
    }


    public function getLoggedOut()
    {
        // $hauth = new Hybrid_Auth(app_path() . '/config/twitterAuth.php');
        // $hauth = new Hybrid_Auth(app_path() . '/config/fb_auth.php');
        //You can use any of the one provider to get the variable, I am using google
        //this is important to do, as it clears out the cookie
        $hauth=new HybridAuth(app_path().'/config/google_auth.php');
        $hauth->logoutAllProviders();
        return View::make('xlogin');
    }
}
