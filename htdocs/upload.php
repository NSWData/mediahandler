<?php
require_once "../lib/lib.php";
require_once "../lib/common.php";

$token = getArgFromUrl('token', null);		// token must be passed to ensure authenticated user
$uri = getArgFromUrl('uri', null);		// token must be passed to ensure authenticated user
$status = 0;							// upload successful or not

if ($token == null) {
	echo json_encode(array('status' => 0, 'message' => 'ERROR: No token has been passed!'));
	exit();
}
if ($uri == null) {
	echo json_encode(array('status' => 0, 'message' => 'ERROR: No file ID has been passed!'));
	exit();
}



//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$fileParts = explode(',', base64_decode($uri));
$fileExt = $fileParts[4];

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

    if($check !== false) {
        $msg = "File is an image - " . $check["mime"] . ".";
		$status = 1;
    } else {
        $msg = "File is not an image.";
		$status = 0;
    }
}

// Check if file already exists
/* if (file_exists($target_file)) {
    $msg = "ERROR : file already exists.";
	$status = 0;
} */

// Check file size
if ($_FILES["fileToUpload"]["size"] > MEDIA_MAXFILESIZE_FNMPHOTOS) {
    $msg = "ERROR : file is too large.";
	$status = 0;
}

// Allow certain file formats
$fileTypesPermitted = explode(',', MEDIA_FILETYPES_FNMPHOTOS);

if (!in_array($fileExt, $fileTypesPermitted)) {
    $msg = "ERROR : " . join(',', $fileTypesPermitted) ." files are allowed.";
	$msg .= " $fileExt has been posted.";
	$status = 0;
}


// If checks OK save tmp file somewhere permanent
if ($status == 0) {
    $sum = "ERROR: file was not uploaded.";
} else {
	//$target_file = MEDIA_UPLOAD_DIR_FNMPHOTOS . basename($_FILES["fileToUpload"]["name"]);

	// AWS S3 locations
	$mediaURIs = array(
    	'FNM' => 'www-floodsnearme/media/photos/',
	);
	
	$filename = $fileParts[1] . '.' . $fileParts[2] . '.' . $fileParts[3] . '.' . $fileExt;

	$target_file = MEDIA_UPLOAD_DIR_FNMPHOTOS . '/' . $filename;
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $msg = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		$msg = "Upload Success";
		$status = 1;

		// Set some environment variables for AWS credentials used for an aws cli call
    	putenv(PUTENV_AWS_REGION);
    	putenv(PUTENV_AWS_ACCESS_KEY_ID);
    	putenv(PUTENV_AWS_SECRET_ACCESS_KEY);

		$uriS3path = 's3://' . $mediaURIs[$fileParts[0]];	

		// AWS CLI command to transfer to S3
		$cmd = "/usr/bin/aws s3 cp $target_file $uriS3path";
		system($cmd,$result);

		if ($result == 0) {
			$msg = 'UPLOAD SUCCESS!';
			$status = 1;
		} else {
			$msg = 'ERROR : S3 transfer failure!';
			$status = 0;
		}
    } else {
        $msg = "There was an error uploading your file.";
		$status = 0;
		
    }
}

// send a nice message back to the client
header("Content-type: text/json");

$response = array(
	'message' => $msg,
	'status' => $status
);


echo json_encode($response);
?>
