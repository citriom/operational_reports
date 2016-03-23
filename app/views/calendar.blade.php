<?php

    define('APPLICATION_NAME', 'Google Calendar API Quickstart');
    define('CREDENTIALS_PATH', '.credentials/calendar-api-quickstart.json');
    define('CLIENT_SECRET_PATH', 'client_secret.json');
    define('SCOPES', implode(' ', array(
  	Google_Service_Calendar::CALENDAR)
    ));

    /**
    * Returns an authorized API client.
    * @return Google_Client the authorized client object
    */

    function getClient() {
  	$client = new Google_Client();
  	$client->setApplicationName(APPLICATION_NAME);
  	$client->setScopes(SCOPES);
  	$client->setAuthConfigFile(CLIENT_SECRET_PATH);
  	$client->setAccessType('offline');

  	// Load previously authorized credentials from a file.
  	$credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);

  	if (file_exists($credentialsPath)) {
    	    $accessToken = file_get_contents($credentialsPath);
  	} 
	else {
	    //Request authorization from the user.
    	    //$authUrl = $client->createAuthUrl();
    	    //echo "Open the following link in your browser: ".$authUrl;
	    
	    //print 'Enter verification code: ';
	    $authCode = trim('4/7jaUjMFsv15-lcTX2PhYRuLIC9Mz__BHn_u8kL1xjwk');

    	    // Exchange authorization code for an access token.
	    $accessToken = $client->authenticate($authCode);

	    // Store the credentials to disk.
	    if(!file_exists(dirname($credentialsPath))) {
	    	mkdir(dirname($credentialsPath), 0700, true);
	    }
	    file_put_contents($credentialsPath, $accessToken);
	    echo "Credentials saved to ". $credentialsPath;
	    
	    //echo "Token Expired";
	}
  	
	$client->setAccessToken($accessToken);

	//Refresh the token if it's expired.
  	if ($client->isAccessTokenExpired()) {
    	    $client->refreshToken($client->getRefreshToken());
    	    file_put_contents($credentialsPath, $client->getAccessToken());
  	}

  	return $client;
    }

    /**
    * Expands the home directory alias '~' to the full path.
    * @param string $path the path to expand.
    * @return string the expanded path.
    */

    function expandHomeDirectory($path) {
	$homeDirectory = getenv('HOME');
  	if (empty($homeDirectory)) {
    	    $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
  	}
  	return str_replace('~', realpath($homeDirectory), $path);
    }


    // Get the API client and construct the service object.
    $client = getClient();
    $service = new Google_Service_Calendar($client);


    // Print the next 10 events on the user's calendar.
    $calendarId = 'primary';
    $optParams = array(
    	'maxResults' => 10,
    	'orderBy' => 'startTime',
  	'singleEvents' => TRUE,
  	'timeMin' => date('c'),
    );
    $results = $service->events->listEvents($calendarId, $optParams);

    if (count($results->getItems()) == 0) {
  	echo "No upcoming events found.";
    } 
    else {
	echo "<b>Upcoming events </b><br> <ul>";
  	foreach ($results->getItems() as $event) {
    	    $start = $event->start->dateTime;
    	    if (empty($start))
      	    	$start = $event->start->date;
    	    echo "<li>".$event->getSummary()." - ".$start."</li>";
	}
	echo "</ul>";
    }

    $event = new Google_Service_Calendar_Event(array(
  	'summary' => 'Google I/O 2015',
  	'location' => '800 Howard St., San Francisco, CA 94103',
  	'description' => 'A chance to hear more about Google developer products.',
  	'start' => array(
    	    'dateTime' => '2015-10-23T09:00:00-07:00',
    	    'timeZone' => 'America/Los_Angeles',
  	),
  	'end' => array(
    	    'dateTime' => '2015-10-23T17:00:00-07:00',
    	    'timeZone' => 'America/Los_Angeles',
  	),
  	'recurrence' => array(
    	    'RRULE:FREQ=DAILY;COUNT=2'
  	),
  	'attendees' => array(
    	    array('email' => 'lpage@example.com'),
    	    array('email' => 'sbrin@example.com'),
  	),
  	'reminders' => array(
    	    'useDefault' => FALSE,
    	    'overrides' => array(
      		array('method' => 'email', 'minutes' => 24 * 60),
      		array('method' => 'popup', 'minutes' => 10),
    	    ),
  	),
    ));

    $calendarId = 'primary';
    $event = $service->events->insert($calendarId, $event);
    echo 'Event created - '.$event->htmlLink;


