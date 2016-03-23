<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

	/**
	|--------------------------------------------------------------------------
	| Google
	|--------------------------------------------------------------------------
	*/

	'Google' => array(
	    'client_id'     => '663940279934-g1sdcvh5hdmc8fh0g5selvn4vr1fktbn.apps.googleusercontent.com',
	    'client_secret' => '03DgqjJ45XE6Tibvo9w5KNww',
	    'scope'         => array('userinfo_email', 'userinfo_profile'),
	), 

	)

);
