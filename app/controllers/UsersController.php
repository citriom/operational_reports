<?php

    class UsersController extends BaseController {

	public function socialLogin($action){

	    if( $action == 'auth' ){
		try{
		    HybridEndpoint::process();
		}
		catch( Exception $e ){
		    return Redirect::route('hybridauth');
		}
	    }
	    try{
		$socialAuth = new HybridAuth(app_path().'/config/hybridauth.php');
		$provider = $socialAuth->authenticate($action);
		$userProfile = $provider->getUserProfile();
	    }
	    catch( Exception $e ){
		return $e->getMessage();
	    }
	    dd($provider);
	}

    }


