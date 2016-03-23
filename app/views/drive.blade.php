<?php
    //require 'vendor/autoload.php';

    define('APPLICATION_NAME', 'Drive API Quickstart');
    define('CREDENTIALS_PATH', 'drive-api-quickstart.json');
    define('CLIENT_SECRET_PATH', 'client_secret.json');
    define('SCOPES', implode(' ', array(
   	Google_Service_Drive::DRIVE_METADATA_READONLY)
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
  	if ( file_exists($credentialsPath) ) {
   	    $accessToken = file_get_contents($credentialsPath);
        } 
	else {
	    echo "No File Configuration";
    	    /* Request authorization from the user.
    	    $authUrl = $client->createAuthUrl();
    	    echo "Open the following link in your browser: <br> ".$authUrl;
    	    /*print 'Enter verification code: ';*/
	    //$authCode = trim("4/CCZiqIT_ewNfYVxYFWw55ennCw_jHE2T26-jKASUgjQ");

	    // Exchange authorization code for an access token.*/
	    $accessToken = $client->authenticate($authCode);

	    // Store the credentials to disk.
	    if(!file_exists(dirname($credentialsPath))) {
	        mkdir(dirname($credentialsPath), 0700, true);
    	    }
    	    file_put_contents($credentialsPath, $accessToken);
    	    echo "Credentials saved to ".$credentialsPath."<br>";
	}
	$client->setAccessToken($accessToken);

  	// Refresh the token if it's expired.
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
    $service = new Google_Service_Drive($client);

    $results = $service->files->listFiles();

    if (count($results->getItems()) == 0) {
        echo "No files found.\n";
    } 
    else {
        echo "Files: ";
        $i=0;
        foreach ($results->getItems() as $file) {
    	    echo $file->getTitle().": ".$file->getId()."<br>";
	    $i++;
	    if($i>10) break;
       }
   }

//    $client = getClient();
//    $file = new Google_Service_Drive_DriveFile();
//    $file->setTitle("Hello World");
//    var_dump($file);

    $service = new Google_Service_Books($client);
    var_dump($service);
    $optParams = array('filter' => 'free-ebooks');
    $results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);
    foreach ($results as $item) {
     	echo $item['volumeInfo']['title'], "<br /> \n";
    }


/*
   $file->setTitle("Hello World!");
   $result = $service->files->insert($file, array(
      'data' => file_get_contents("Example.txt"),
      'mimeType' => 'application/octet-stream',
      'uploadType' => 'multipart'
   ));
   var_dump($result);
*/

/*$service = new Google_Service_Calendar($client);

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
  print "No upcoming events found.\n";
} else {
  print "Upcoming events:\n";
  foreach ($results->getItems() as $event) {
    $start = $event->start->dateTime;
    if (empty($start)) {
      $start = $event->start->date;
    }
    printf("%s (%s)\n", $event->getSummary(), $start);
  }
}*/
?>
