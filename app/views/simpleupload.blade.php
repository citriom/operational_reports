<?php

	include_once "base.php";
	session_start();

	$client_id = '663940279934-g1sdcvh5hdmc8fh0g5selvn4vr1fktbn.apps.googleusercontent.com';
	$client_secret = '03DgqjJ45XE6Tibvo9w5KNww';
	$redirect_uri = 'http://canopus.citriom.com/frontend/public/drive';

	$client = new Google_Client();
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setRedirectUri($redirect_uri);
	
	$client->addScope("https://www.googleapis.com/auth/drive");
	$service = new Google_Service_Drive($client);
	if( isset($_REQUEST['logout']) ) {
  		unset($_SESSION['upload_token']);
	}
	if (isset($_GET['code'])) {
  		$client->authenticate($_GET['code']);
  		$_SESSION['upload_token'] = $client->getAccessToken();
  		$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  		header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
	}
	if (isset($_SESSION['upload_token']) && $_SESSION['upload_token']) {
  		$client->setAccessToken($_SESSION['upload_token']);
  		if ($client->isAccessTokenExpired()) {
    			unset($_SESSION['upload_token']);
		}
	} 
	else {
  		$authUrl = $client->createAuthUrl();
	}

	if ($client->getAccessToken()) {
  		$file = new Google_Service_Drive_DriveFile();
  		$file->setTitle("Google.pdf");
  		$result = $service->files->insert(
      			$file,
      			array(
        			'data' => file_get_contents("google.pdf"),
        			'mimeType' => 'application/octet-stream',
        			'uploadType' => 'multipart'
      			)
  		);
		var_dump($result);
	}
	
	if (strpos($client_id, "googleusercontent") == false) {
	echo "aja";
  		echo missingClientSecretsWarning();
 	 	exit;
	}
?>
<div class="box">
	<div class="request">
	<?php 
	if (isset($authUrl)) {
  		echo "<a class='login' href='" . $authUrl . "'>Connect Me!</a>";
	}
	?>
</div>
