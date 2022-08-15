<?php
// Generation of simple log file for activity on user page
include("includes/getIPAddress.php");

// Collecting information 
$IP_ADDRESS = getIPAddress();

// Get date
$DATE = date('Y-m-d H:i:s');

// Combine in string
$LOG = "IP_ADDRESS=".$IP_ADDRESS;
$LOG .= ":::"."DATE=".$DATE;
$LOG .= ":::"."do=".$do;
$LOG .= ":::"."csvfile=".$csvfile;
$LOG .= ":::"."control=".$control;
$LOG .= ":::"."user=".$user;
$LOG .= ":::"."action=".$action;
$LOG .= ":::"."image=".$image;
$LOG .= ":::"."nrcores=".$nrcores;
$LOG .= ":::"."memgb=".$memgb;
$LOG .= ":::"."theme=".$theme;
$LOG .= ":::"."safety_check=".$safety_check;
$LOG .= ":::"."safety_check_required=".$safety_check_required;

if (!empty($user)) {
    $myfile = fopen("logs/logs_userpage.log", "a") or die("Unable to open file!");
    fwrite($myfile, "\n". $LOG);
    fclose($myfile);
}
?>