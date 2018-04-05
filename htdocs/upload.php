<?php
require_once "../lib/lib.php";
require_once "../lib/common.php";

$token = getArgFromUrl('token', null);		// token must be passed to ensure authenticated user
$status = 0;							// upload successful or not

if ($token == null) {
	print 'ERROR: No token has been passed!';
	exit();
}

$target_file = MEDIA_UPLOAD_DIR_FNMPHOTOS . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

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
if (file_exists($target_file)) {
    $msg = "ERROR : file already exists.";
	$status = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > MEDIA_MAXFILESIZE_FNMPHOTOS) {
    $msg = "ERROR : file is too large.";
	$status = 0;
}

// Allow certain file formats
$fileTypesPermitted = explode(',', MEDIA_FILETYPES_FNMPHOTOS);

if (!in_array($imageFileType, $fileTypesPermitted)) {
    $msg = "ERROR : " . join(',', $fileTypesPermitted) ." files are allowed.";
	$msg .= " $imageFileType has been posted ($targetFile).";
	$status = 0;
}


// If checks OK save tmp file somewhere permanent
if ($status == 0) {
    $sum = "ERROR: file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $msg = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		$msg = "Upload Success";
		$status = 1;
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
