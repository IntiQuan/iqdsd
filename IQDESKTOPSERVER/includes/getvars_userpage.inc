<?php
// User page - Get passed GET variables
$do = $_GET["do"];
$csvfile = $_GET["csvfile"];

// User page - Get passed POST variables
$control = $_POST["control"];
$user = $_POST["user"];
$action = $_POST["action"];
$image = $_POST["image"];
$nrcores = $_POST["nrcores"];
$memgb = $_POST["memgb"];
$theme = $_POST["theme"];
$safety_check = $_POST["safety_check"];
$safety_check_required = $_POST["safety_check_required"];

// The mount labels ... 
$MOUNT1_LABEL = $_POST["MOUNT1_LABEL"];
$MOUNT2_LABEL = $_POST["MOUNT2_LABEL"];
$MOUNT3_LABEL = $_POST["MOUNT3_LABEL"];
$MOUNT4_LABEL = $_POST["MOUNT4_LABEL"];
$MOUNT5_LABEL = $_POST["MOUNT5_LABEL"];

// -----------------------------------------------------
// Checking the input
// -----------------------------------------------------

// Assume default "OK"
$OK = true;

// $do can only have few values
if (!($do=="" || $do=="control" || $do=="selectCSV")) $OK = false;

// $csvfile not allowed to contain path, space, etc. must contain .csv
if ($csvfile != "") {
	$csvfile_check = basename(str_replace(" ", "", $csvfile));
	$csvfile_check = str_replace(".csv", "", $csvfile_check).".csv";
	if (strcmp($csvfile_check,$csvfile)!=0) $OK = false;
}

// $control seems to be unused - ensure not path and no spaces!
$control_check = preg_replace('/[^A-Za-z0-9\-]/', '', $control);
if (strcmp($control_check,$control)!=0) $OK = false;

// user - only allow standard characters and numbers
$user_check = preg_replace('/[^A-Za-z0-9\-]/', '', $user);
if (strcmp($user_check,$user)!=0) $OK = false;

// $action can only have few values
if (!($action=="stop" || $action=="start" || $action=="")) $OK = false;

// $image - syntax: "intiquan/iqdesktop:number.number". No space etc.
// or: "intiquan/iqdesktop:number.number.number"
$image_check = str_replace("intiquan/iqdesktop:", "", $image);
$image_check = preg_replace('/[0-9]+/', '', $image_check);
if (!($image_check=="." || $image_check==".." || $image_check=="")) $OK = false;

// $nrcores - numeric!
$nrcores_check = preg_replace('/[^0-9]/', '', $nrcores);
if (strcmp($nrcores_check,$nrcores)!=0) $OK = false;

// $memgb - numeric!
$memgb_check = preg_replace('/[^0-9]/', '', $memgb);
if (strcmp($memgb_check,$memgb)!=0) $OK = false;

// $theme can only have few values
if (!($theme=="light" || $theme=="dark" || $theme=="")) $OK = false;

// $safety_check - enforce no spaces and only standard chars - no specal chars
$safety_check_check = preg_replace('/[^A-Za-z0-9]/', '', $safety_check);
if (strcmp($safety_check_check,$safety_check)!=0) $OK = false;

// $safety_check_required - enforce no spaces and only standard chars - no specal chars
$safety_check_required_check = preg_replace('/[^A-Za-z0-9]/', '', $safety_check_required);
if (strcmp($safety_check_required_check,$safety_check_required)!=0) $OK = false;

if (!$OK) {
	echo '<html><body>Some GETs or POSTs not within bounds - stopping here ...<br><img src="images/bomb.jpg"></body></html>';
	exit;
}
?>