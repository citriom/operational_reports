
<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

define('APPLICATION_NAME', 'Google Docs Generator');
define('CREDENTIALS_PATH', '.credentials/google-api.json');
define('CLIENT_SECRET_PATH', 'client_secret.json');
define('SCOPES', implode(' ', array(
    Google_Service_Calendar::CALENDAR,
    Google_Service_Drive::DRIVE,
    Google_Service_Drive::DRIVE_METADATA,
    Google_Service_Drive::DRIVE_FILE,
    Google_Service_Gmail::MAIL_GOOGLE_COM)
));

function getClient() {
    $client = new Google_Client();
    $client->setApplicationName(APPLICATION_NAME);
    $client->setScopes(SCOPES);
    $client->setAuthConfigFile(CLIENT_SECRET_PATH);
    $client->setAccessType('offline');
    $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);

    if (file_exists($credentialsPath)) {
	$accessToken = file_get_contents($credentialsPath);
    }
    else {
	//$authUrl = $client->createAuthUrl();
	//echo "Open the following link in your browser: ".$authUrl;
	
	$authCode = trim('4/WomQ3LJDIoHQw2Bo0crYjhe5v3JwQufkyH2-2xwzRks');
	// Exchange authorization code for an access token.
	$accessToken = $client->authenticate($authCode);
	// Store the credentials to disk.
	if(!file_exists(dirname($credentialsPath))) {
	    mkdir(dirname($credentialsPath), 0700, true);
	}
	file_put_contents($credentialsPath, $accessToken);
	//echo "Credentials saved to ". $credentialsPath";
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

function expandHomeDirectory($path) {
    $homeDirectory = getenv('HOME');
    if (empty($homeDirectory)) {
	$homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
    }
    return str_replace('~', realpath($homeDirectory), $path);
}

function sendMessage($service, $userId, $message) {

};


/**********************************
Route::get('/login', function(){
	return View::make('login');
});
*********************************/

Route::get('gauth/{auth?}',array('as'=>'googleAuth','uses'=>'AuthController@getGoogleLogin'));


//Route::get('login', 'AuthController@showLogin'); 	// Show Login
//Route::get('logout', 'AuthController@logOut'); 		// Log Out

//Route::group(['before' => 'auth'], function()
//{

    /**
	index: Get Users and Projects data from API
    
    Route::get('/', function()
    {
    	$params   = [];
    	$response = \Httpful\Request::get("canopus.citriom.com/backend/public/index.php/api/users")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
    	$data1 = $response->body;
    	$params   = [];
    	$response = \Httpful\Request::get("canopus.citriom.com/backend/public/index.php/api/projects")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
    	$data2 = $response->body;
    	return View::make('index', ['users'=>$data1->users, 'projects'=>$data2->projects]);
    });
    **/

    /**
	users : List of Users
    **/
    Route::get('/users', function()
    {
    	$params   = [];
    	$response = \Httpful\Request::get("45.55.253.74/backend/public/index.php/api/users")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
    	$data = $response->body;
    	return View::make('users', ['users'=>$data->users]);
    });

    /**
	users/{id} : Data from selected user
    **/
    Route::get('/users/{id}', function($id)
    {
    	$params   = [];
    	$response = \Httpful\Request::get("45.55.253.74/backend/public/index.php/api/users/$id")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
    	$data = $response->body;
    	if( !isset( $data->user ))
    	    return View::make('user', ['user'=>$data]);

    });

    /**
	projects : List of Projects
    **/
    Route::get('/projects', function()
    {
    	$params   = [];
    	$response = \Httpful\Request::get("45.55.253.74/backend/public/index.php/api/projects")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
    	$data = $response->body;
    	return View::make('projects', ['projects'=>$data->projects]);
    });

    /**
	projects/{id} : Data from selected project
    **/
    Route::any('/projects/{id}', function($id)
    {
	$params   = [];
    	$response = \Httpful\Request::get("45.55.253.74/backend/public/index.php/api/projects/$id")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
    	$data = $response->body;
    	return View::make('project', ['project'=>$data]);
    });

    /**
	hoursreport : Makes a report using data from User and Projects with start and end date
    **/
    Route::any('/hoursreport', function()
    {	
	$project_id = $_POST['project_id'];
	$user_id    = $_POST['user_id'];
	$start	    = strtotime($_POST['start']);
	$end	    = strtotime($_POST['end']);

	$params   = [];
	$response = \Httpful\Request::get("45.55.253.74/backend/public/index.php/api/hoursreport/$project_id/$user_id/$start/$end")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
	$data = $response->body;
	return View::make('hoursreport', [
		'timeEntries' => $data->timeEntries, 
		'hours'=>$data->hours, 
		'user'=>$data->user,
		'project'=>$data->project
	]);
	
    });

    /**
	hoursproject: Shows the amount of hours spent in a specific project
    **/
    Route::any('/hoursproject', function()
    {
	$project_id = $_POST['project_id'];
	$start	    = strtotime($_POST['start']);
	$end	    = strtotime($_POST['end']);
	$params   = [];
	$response = \Httpful\Request::get("45.55.253.74/backend/public/index.php/api/hoursproject/$project_id/$start/$end")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
	$data = $response->body;
	return View::make('hoursproject', [
		'timeEntries' 	=> $data->timeEntries, 
		'hours'		=> $data->hours,
		'project'	=> $data->project,
		'resources'	=> $data->resources
	]);
    });

    /**
	hoursuser: Shows the amount of hours from a specific user
    **/
    Route::post('/hoursuser', function()
    {
	$users = $_POST['users'];
	if( isset($_POST['projects']) )
	    $projects = $_POST['projects'];
	else
	    $projects = 'null';
	$start	    = strtotime($_POST['start']);
	$end	    = strtotime($_POST['end']);

	$usersData=array();
	foreach( $users as $user ){
	    $data = array();
	    $data['id']=$user;
	    $data['projects']=$projects;
	    $data['hours']=0;
	    foreach( $projects as $project ){
		$params   = [];
		$string = "45.55.253.74/backend/public/index.php/api/hoursuser/$user/$project/$start/$end";
		$response = \Httpful\Request::get($string)
            	->addHeaders([])
            	->body(http_build_query($params))
            	->send();	
		$info = $response->body;
		$data['firstname']=$info->user->firstname;
		$data['lastname']=$info->user->lastname;
		$data['login']=$info->user->login;
		$data['timeEntries']=$info->timeEntries;
		$data['hours']+=$info->hours;
	    }	
	    array_push($usersData, $data);

	    //var_dump($data);
	    //echo "<h4>".$data['firstname']." ".$data['lastname']." ".$data['hours']."</h4>";
	}

	return View::make('usersdata', ['usersdata'=>$usersData]);
	
/*	
	$user_id = $_POST['user_id'];
	if( strlen($_POST['project_id']))
	    $project_id = $_POST['project_id'];
	else
	    $project_id = 'null';
	$start	    = strtotime($_POST['start']);
	$end	    = strtotime($_POST['end']);
	$params   = [];
	$string = "canopus.citriom.com/backend/public/index.php/api/hoursuser/$user_id/$project_id/$start/$end";
	$response = \Httpful\Request::get($string)
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();	
	$data = $response->body;
	return View::make('hoursreport', [
		'timeEntries' => $data->timeEntries, 
		'hours'       => $data->hours, 
		'user'        => $data->user,
		'projects'    => $data->projects,
		'start'	      => $data->start,
		'end'	      => $data->end
	]);
*/
    });

Route::get('/drive', function(){
	return View::make('simpleupload');
});

Route::get('/calendar', function(){
	return View::make('calendar');
});

Route::get('/google', function(){
	return View::make('google');
});


Route::get('/file', function()
{
	// GET DATA FROM API
	$project_id = $_GET['project_id'];
	$user_id    = $_GET['user_id'];
	$start	    = $_GET['start'];
	$end	    = $_GET['end'];
	$params   = [];
	$response = \Httpful\Request::get("45.55.253.74/backend/public/index.php/api/hoursuser/$user_id/$project_id/$start/$end")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
	$data = $response->body;
	//PHP WORD CREATION
	$phpWord = new \PhpOffice\PhpWord\PhpWord();
	$section = $phpWord->addSection();
	$phpWord->addFontStyle('rStyle', array('bold' => true, 'size' => 16, 'allCaps' => true));
	$phpWord->addFontStyle('pStyle', array('bold' => false, 'size' => 12, 'allCaps' => false));
	$section->addText(htmlspecialchars('Citriom Operational Reports', ENT_COMPAT, 'UTF-8'), 'rStyle');
	$section->addTextBreak(2);
	$section->addText(htmlspecialchars('Resource: '.$data->user->firstname.' '.$data->user->lastname, ENT_COMPAT, 'UTF-8'), 'pStyle');
	$section->addText(htmlspecialchars('Start Date: '.$data->start, ENT_COMPAT, 'UTF-8'), 'pStyle');
	$section->addText(htmlspecialchars('End Date:   '.$data->end, ENT_COMPAT, 'UTF-8'), 'pStyle');
	$section->addTextBreak(2);
	
	$hoursArray = Array();
	foreach( $data->timeEntries as $hours){
	    array_push($hoursArray, $hours->spent_on);
	    $hoursSpent = (int) $hours->hours;
	}
	usort($hoursArray, function($a1, $a2) {
	    $v1 = strtotime($a1);
	    $v2 = strtotime($a2);
	    return $v1 - $v2;
	});

	$table = $section->addTable();
	$table->addRow();
	    $table->addCell(1500)->addText( htmlspecialchars(" Project   ", ENT_COMPAT, 'UTF-8'));
	    $table->addCell(1500)->addText( htmlspecialchars(" Start Date ", ENT_COMPAT, 'UTF-8'));
	    $table->addCell(1500)->addText( htmlspecialchars(" End Date   ", ENT_COMPAT, 'UTF-8'));
	    $table->addCell(1500)->addText( htmlspecialchars(" Hours      ", ENT_COMPAT, 'UTF-8'));
    	$table->addRow();
            $table->addCell(1500)->addText( htmlspecialchars( $data->projects[0]->name, ENT_COMPAT, 'UTF-8'));
            $table->addCell(1500)->addText( htmlspecialchars( $hoursArray[0], ENT_COMPAT, 'UTF-8'));
            $table->addCell(1500)->addText( htmlspecialchars( $hoursArray[ count($hoursArray) - 1], ENT_COMPAT, 'UTF-8'));
            $table->addCell(1500)->addText( htmlspecialchars( $data->hours, ENT_COMPAT, 'UTF-8'));
	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
	$fileName = " ".$data->user->lastname.", ".$data->user->firstname.": ".$data->projects[0]->name." (".$data->start." - ".$data->end.").docx";
	$response = $objWriter->save($fileName);

	//GOOGLE DRIVE CONNECTION
	$client = getClient();	

	$service = new Google_Service_Drive($client);

    	$file = new Google_Service_Drive_DriveFile();
    	$file->setTitle($fileName);
    	$result = $service->files->insert(
            $file,
     	    array(
            	'data' => file_get_contents($fileName),
           	'mimeType' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            	'uploadType' => 'multipart'
            )
    	);

	return View::make('filelink', ['link'=>$result->alternateLink]);
    });

    Route::post('/addevent', function()
    {
	// GET DATA FROM FORM
	$project_id = $_POST['summary'];
	var_dump($project_id);
    });

    Route::get('/events', function()
    {
	// Get the API client and construct the service object.
	$client = getClient();
	$service = new Google_Service_Calendar($client);		
	$events = $service->events->listEvents('primary');
	return View::make('events', ['results' => $events]);
    });

    Route::post('/events', function()
    {
	$summary = $_POST['summary'];
	$description = $_POST['description'];
	$start = $_POST['start'];
	$end = $_POST['end'];

	// Get the API client and construct the service object.
        $client = getClient();
        $service = new Google_Service_Calendar($client);

	$event = new Google_Service_Calendar_Event(array(
	    'summary' => $summary,
  	    'description' => $description,
  	    'start' => array(
    		'date' => date("Y-m-d", strtotime($start)),
    		'timeZone' => 'America/Los_Angeles',
  	    ),
  	    'end' => array(
    		'date' => date("Y-m-d", strtotime($end)),
    		'timeZone' => 'America/Los_Angeles',
  	    ),
	));

	$events = $service->events->listEvents('primary');
	return View::make('events', ['results' => $events]);

    });

    Route::get('/mail', function()
    {
	/*
	// GET DATA FROM API
	$project_id = $_GET['project_id'];
	$user_id    = $_GET['user_id'];
	$start	    = $_GET['start'];
	$end	    = $_GET['end'];
	$params   = [];
	$response = \Httpful\Request::get("canopus.citriom.com/backend/public/index.php/api/hoursuser/$user_id/$project_id/$start/$end")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
	$data = $response->body;
	//PHP WORD CREATION
	$phpWord = new \PhpOffice\PhpWord\PhpWord();
	$section = $phpWord->addSection();
	$phpWord->addFontStyle('rStyle', array('bold' => true, 'size' => 16, 'allCaps' => true));
	$phpWord->addFontStyle('pStyle', array('bold' => false, 'size' => 12, 'allCaps' => false));
	$section->addText(htmlspecialchars('Citriom Operational Reports', ENT_COMPAT, 'UTF-8'), 'rStyle');
	$section->addTextBreak(2);
	$section->addText(htmlspecialchars('Resource: '.$data->user->firstname.' '.$data->user->lastname, ENT_COMPAT, 'UTF-8'), 'pStyle');
	$section->addText(htmlspecialchars('Start Date: '.$data->start, ENT_COMPAT, 'UTF-8'), 'pStyle');
	$section->addText(htmlspecialchars('End Date:   '.$data->end, ENT_COMPAT, 'UTF-8'), 'pStyle');
	$section->addTextBreak(2);
	
	$hoursArray = Array();
	foreach( $data->timeEntries as $hours){
	    array_push($hoursArray, $hours->spent_on);
	    $hoursSpent = (int) $hours->hours;
	}
	usort($hoursArray, function($a1, $a2) {
	    $v1 = strtotime($a1);
	    $v2 = strtotime($a2);
	    return $v1 - $v2;
	});

	$table = $section->addTable();
	$table->addRow();
	    $table->addCell(1500)->addText( htmlspecialchars(" Project   ", ENT_COMPAT, 'UTF-8'));
	    $table->addCell(1500)->addText( htmlspecialchars(" Start Date ", ENT_COMPAT, 'UTF-8'));
	    $table->addCell(1500)->addText( htmlspecialchars(" End Date   ", ENT_COMPAT, 'UTF-8'));
	    $table->addCell(1500)->addText( htmlspecialchars(" Hours      ", ENT_COMPAT, 'UTF-8'));
    	$table->addRow();
            $table->addCell(1500)->addText( htmlspecialchars( $data->projects[0]->name, ENT_COMPAT, 'UTF-8'));
            $table->addCell(1500)->addText( htmlspecialchars( $hoursArray[0], ENT_COMPAT, 'UTF-8'));
            $table->addCell(1500)->addText( htmlspecialchars( $hoursArray[ count($hoursArray) - 1], ENT_COMPAT, 'UTF-8'));
            $table->addCell(1500)->addText( htmlspecialchars( $data->hours, ENT_COMPAT, 'UTF-8'));
	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
	$fileName = " ".$data->user->lastname.", ".$data->user->firstname.": ".$data->projects[0]->name." (".$data->start." - ".$data->end.").docx";
	unlink($fileName);
	$response = $objWriter->save($fileName);*/

	//GMAIL CONNECTION
	$client = getClient();	
	$service = new Google_Service_Gmail($client);

	// Print the labels in the user's account.
	/*$user = 'me';
	$results = $service->users_labels->listUsersLabels($user);

	if (count($results->getLabels()) == 0) {
	    echo "No labels found";
	} else {
  	    echo  "Labels:<br>";
  	    foreach ($results->getLabels() as $label) {
    		echo $label->getName()."<br>";
  	    }
	}*/

	$optParams = [];
        $optParams['maxResults'] = 5; // Return Only 5 Messages
        $optParams['labelIds'] = 'INBOX'; // Only show messages in Inbox
        $messages = $service->users_messages->listUsersMessages('me',$optParams);
        $list = $messages->getMessages();
        $messageId = $list[0]->getId(); // Grab first Message


        $optParamsGet = [];
        $optParamsGet['format'] = 'full'; // Display message in payload
        $message = $service->users_messages->get('me',$messageId,$optParamsGet);
        $messagePayload = $message->getPayload();
        $headers = $message->getPayload()->getHeaders();
        $parts = $message->getPayload()->getParts();

        $body = $parts[0]['body'];
        $rawData = $body->data;
        $sanitizedData = strtr($rawData,'-_', '+/');
        $decodedMessage = base64_decode($sanitizedData);

        var_dump($decodedMessage);	

    });

    Route::get('/mailer', function(){

    	try {

	// GET DATA FROM API
	$project_id = $_GET['project_id'];
	$user_id    = $_GET['user_id'];
	$start	    = strtotime($_GET['start']);
	$end	    = strtotime($_GET['end']);
	$email	    = $_GET['email'];

	$params   = [];
	$response = \Httpful\Request::get("45.55.253.74/backend/public/index.php/api/hoursuser/$user_id/$project_id/$start/$end")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
	$data = $response->body;

	//PHP WORD CREATION
	$phpWord = new \PhpOffice\PhpWord\PhpWord();
	$section = $phpWord->addSection();
	$phpWord->addFontStyle('rStyle', array('bold' => true, 'size' => 16, 'allCaps' => true));
	$phpWord->addFontStyle('pStyle', array('bold' => false, 'size' => 12, 'allCaps' => false));
	$section->addText(htmlspecialchars('Citriom Operational Reports', ENT_COMPAT, 'UTF-8'), 'rStyle');
	$section->addTextBreak(2);

	$section->addText(htmlspecialchars('Resource: '.$data->user->firstname.' '.$data->user->lastname, ENT_COMPAT, 'UTF-8'), 'pStyle');
	$section->addText(htmlspecialchars('Start Date: '.$data->start, ENT_COMPAT, 'UTF-8'), 'pStyle');
	$section->addText(htmlspecialchars('End Date:   '.$data->end, ENT_COMPAT, 'UTF-8'), 'pStyle');
	$section->addTextBreak(2);
	
	$hoursArray = Array();
	foreach( $data->timeEntries as $hours){
	    array_push($hoursArray, $hours->spent_on);
	    $hoursSpent = (int) $hours->hours;
	}
	usort($hoursArray, function($a1, $a2) {
	    $v1 = strtotime($a1);
	    $v2 = strtotime($a2);
	    return $v1 - $v2;
	});

	$table = $section->addTable();
	$table->addRow();
	    $table->addCell(1500)->addText( htmlspecialchars(" Project   ", ENT_COMPAT, 'UTF-8'));
	    $table->addCell(1500)->addText( htmlspecialchars(" Start Date ", ENT_COMPAT, 'UTF-8'));
	    $table->addCell(1500)->addText( htmlspecialchars(" End Date   ", ENT_COMPAT, 'UTF-8'));
	    $table->addCell(1500)->addText( htmlspecialchars(" Hours      ", ENT_COMPAT, 'UTF-8'));
    	$table->addRow();
            $table->addCell(1500)->addText( htmlspecialchars( $data->projects[0]->name, ENT_COMPAT, 'UTF-8'));
            $table->addCell(1500)->addText( htmlspecialchars( $hoursArray[0], ENT_COMPAT, 'UTF-8'));
            $table->addCell(1500)->addText( htmlspecialchars( $hoursArray[ count($hoursArray) - 1], ENT_COMPAT, 'UTF-8'));
            $table->addCell(1500)->addText( htmlspecialchars( $data->hours, ENT_COMPAT, 'UTF-8'));
	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
	$fileName = " ".$data->user->lastname.", ".$data->user->firstname.": ".$data->projects[0]->name." (".$data->start." - ".$data->end.").docx";
	if( file_exists($fileName) )
	    unlink($fileName);
	$response = $objWriter->save($fileName);


	$client = getClient();	
	$service = new Google_Service_Gmail($client);
	
	/* WORKING WITHOUT ATTACHED FILES 
	$mail = new \PHPMailer(true);
	$mail->CharSet = "UTF-8";
	$subject = "my subject";
	$msg = "hey there!";
	$from = "pedro.escalante@citriom.com";
	$fname = "Pedro Escalante - Citriom";
	$mail->From = $from;
	$mail->FromName = $fname;
	$mail->AddAddress("escalante308@gmail.com");
	$mail->AddReplyTo($from,$fname);
	$mail->Subject = $subject;
	$mail->Body    = $msg;
	$mail->preSend();
	$mime = $mail->getSentMIMEMessage();
	$m = new Google_Service_Gmail_Message();
	$data = base64_encode($mime);
	$data = str_replace(array('+','/','='),array('-','_',''),$data); // url safe
	$m->setRaw($data);
	$service->users_messages->send('me', $m);*/

	$strMailContent = 'Citriom - ';
	$strMailTextVersion = strip_tags($strMailContent, '');

	$strRawMessage = "";
    	$boundary = uniqid(rand(), true);
    	$subjectCharset = $charset = 'utf-8';
   	$strToMailName = $email;
    	$strToMail = $email;
    	$strSesFromName = 'Billings - Citriom';
    	$strSesFromEmail = 'pedro.escalante@citriom.com';
    	$strSubject = 'Billing Report: '.$fileName;

	$strRawMessage .= 'To: ' .$strToMailName . " <" . $strToMail . ">" . "\r\n";
	$strRawMessage .= 'From: '. $strSesFromName . " <" . $strSesFromEmail . ">" . "\r\n";
	$strRawMessage .= 'Subject: =?' . $subjectCharset . '?B?' . base64_encode($strSubject) . "?=\r\n";
    	$strRawMessage .= 'MIME-Version: 1.0' . "\r\n";
	$strRawMessage .= 'Content-type: Multipart/Mixed; boundary="' . $boundary . '"' . "\r\n";

	$filePath = $fileName;
	$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
	$mimeType = finfo_file($finfo, $filePath);
	$fileData = base64_encode(file_get_contents($filePath));

	$strRawMessage .= "\r\n--{$boundary}\r\n";
	$strRawMessage .= 'Content-Type: '. $mimeType .'; name="'. $fileName .'";' . "\r\n";            
	$strRawMessage .= 'Content-ID: <' . $strSesFromEmail . '>' . "\r\n";            
	$strRawMessage .= 'Content-Description: ' . $fileName . ';' . "\r\n";
	$strRawMessage .= 'Content-Disposition: attachment; filename="' . $fileName . '"; size=' . filesize($filePath). ';' . "\r\n";
	$strRawMessage .= 'Content-Transfer-Encoding: base64' . "\r\n\r\n";
	$strRawMessage .= chunk_split(base64_encode(file_get_contents($filePath)), 76, "\n") . "\r\n";
	$strRawMessage .= '--' . $boundary . "\r\n";

	$strRawMessage .= "\r\n--{$boundary}\r\n";
	$strRawMessage .= 'Content-Type: text/plain; charset=' . $charset . "\r\n";
	$strRawMessage .= 'Content-Transfer-Encoding: 7bit' . "\r\n\r\n";
	$strRawMessage .= $strMailTextVersion . "\r\n";

	$strRawMessage .= "--{$boundary}\r\n";
	$strRawMessage .= 'Content-Type: text/html; charset=' . $charset . "\r\n";
 	$strRawMessage .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
 	$strRawMessage .= $strMailContent . "\r\n";

	
            // The message needs to be encoded in Base64URL
            $mime = rtrim(strtr(base64_encode($strRawMessage), '+/', '-_'), '=');
            $msg = new Google_Service_Gmail_Message();
            $msg->setRaw($mime);
            $objSentMsg = $service->users_messages->send("me", $msg);

	    echo json_encode("true");


    	} catch (Exception $e) {
	    echo json_encode("false");
            var_dump( $e->getMessage() );
    	}	

    });

//});







/*--------------------------------------------------------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------------------------------------------------------*/

    Route::get('/login', function(){
    	return View::make('xlogin');
    });

    Route::get('logout',array('as'=>'logout','uses'=>'AuthController@getLoggedOut'));

    Route::post('/login', 'AuthController@postLogin');

    Route::get('/', array('before'=>'auth', function(){
    	$params   = [];

	// Get Last Logged Hours From API
    	$response = \Httpful\Request::get("45.55.253.74/backend/public/index.php/api/lastloggedhours")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
    	$last = $response->body;

	//Get Users List from API
    	$response = \Httpful\Request::get("45.55.253.74/backend/public/index.php/api/users")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
    	$users = $response->body;
    	
	//Get Projects List from API
    	$response = \Httpful\Request::get("45.55.253.74/backend/public/index.php/api/projects")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
    	$projects = $response->body;

	//Make the View
	return View::make('xindex', ['users'=>$users->users, 'projects'=>$projects->projects, 'last'=>$last]);
    }));

    Route::get('/xusers', function(){
	$params   = [];
    	$response = \Httpful\Request::get("45.55.253.74/backend/public/index.php/api/users")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
    	$data = $response->body;
    	return View::make('xusers', ['users'=>$data->users]);
    });

    Route::get('/xprojects', function()
    {
        $params   = [];
        $response = \Httpful\Request::get("45.55.253.74/backend/public/index.php/api/projects")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
        $data = $response->body;
        return View::make('xprojects', ['projects'=>$data->projects]);
    });

    Route::get('/xusers/{id}', function($id)
    {
    	$params   = [];
    	$response = \Httpful\Request::get("45.55.253.74/backend/public/index.php/api/users/$id")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
    	$data = $response->body;

    	$response = \Httpful\Request::get("45.55.253.74/backend/public/index.php/api/projectsuser/$id")
            ->addHeaders([])
            ->body(http_build_query($params))
            ->send();
    	$data2 = $response->body;

    	if( !isset( $data->user ))
    	    return View::make('xuser', ['user'=>$data, 'projects'=>$data2 ]);

    });

    Route::post('/hoursuser', function()
    {
	$users = $_POST['users'];
	if( isset($_POST['projects']) )
	    $projects = $_POST['projects'];
	else
	    $projects = 'null';
	$start	    = strtotime($_POST['start']);
	$end	    = strtotime($_POST['end']);
	$usersData=array();
	foreach( $users as $user ){
	    $data = array();
	    $data['id']=$user;
	    $data['projects']=$projects;
	    $data['hours']=0;
	    $data['start']=$start;
	    $data['end']=$end;
		
	    if( $projects != "null") {
		foreach( $projects as $project ){
		    $params   = [];
		    $string = "45.55.253.74/backend/public/index.php/api/hoursuser/$user/$project/$start/$end";
		    $response = \Httpful\Request::get($string)
            		->addHeaders([])
            		->body(http_build_query($params))
            		->send();	
		    $info = $response->body;
		    $data['firstname']=$info->user->firstname;
		    $data['lastname']=$info->user->lastname;
		    $data['login']=$info->user->login;
		    $data['timeEntries']=$info->timeEntries;
		    $data['hours']+=$info->hours;
	   	}	
	    }
	    else {
		$params=[];
		$string = "45.55.253.74/backend/public/index.php/api/hoursuser/$user/null/$start/$end";
		$response = \Httpful\Request::get($string)
            	    ->addHeaders([])
            	    ->body(http_build_query($params))
            	    ->send();	
		$info = $response->body;
		$data['firstname']=$info->user->firstname;
		$data['lastname']=$info->user->lastname;
		$data['login']=$info->user->login;
		$data['timeEntries']=$info->timeEntries;
		$data['hours']+=$info->hours;
	    }
	    array_push($usersData, $data);
	}
	return View::make('xhoursuser', ['usersdata'=>$usersData]);
    });

    Route::get('/xcal', function(){
    	return View::make('googlecal');
    });
