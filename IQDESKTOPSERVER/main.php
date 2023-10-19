<?php
include("includes/load_settings.inc"); // Load settings 
include("includes/load_infotext.inc"); // Load infotext
include("includes/getvars_userpage.inc");  // Get variables
include("includes/log_userpage.inc");  // Create logs (after get variables)
include("includes/defcolnames_userpage.inc");  // Create logs
$path = "run/";
$pathCSV = "settings/";
?>

<html>
<head>
    <title><?php echo $SERVER_NAME; ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/favIQ.png">
</head>
<body>
    <h1><?php echo $SERVER_NAME." (".$SERVER_ADDRESS.")" ?></h1>
    <h2>
        <a href="index.php">Home</a>
        |
        <a href="https://iqdesktop.intiquan.com" target="new">More information</a>
        |
        <a href="https://www.intiquan.com" target="new">IntiQuan</a>
        <?php
        if ($SHOW_ADMINLINK) {
        ?>
        |
        <a href="/admin/">Admin</a>
        <?php
        }
        ?>
    </h2>
    <br>
    <?php

    if ($do == "") {

        // -----------------------------------------------------------------------------
        // Get names of available CSV files and create selector 
        // Selector only if multiple CSV files ... otherwise directly control area
        // -----------------------------------------------------------------------------
        // Get all CSV files
        $filenamesCSV = glob($pathCSV . "*.csv");

        if ($IGNORE_DEMO_CSV) {
            # Important! 01_demo.csv is assumed to be the first entry!!!
            $filenamesCSV = array_splice($filenamesCSV, 1, count($filenamesCSV));
        }

        // If multiple ... then show form for selection
        if (count($filenamesCSV) > 1) {
            echo "<h3>Select User Group</h3>";
    ?>
            Select the user group that applies to you.<br>
            &nbsp;<br>
            <?php
            echo '<form action="/main.php" method="get" id="form1">';
            echo '<input type="hidden" name="do" value="selectCSV">';
            echo '<select name="csvfile">';
            foreach ($filenamesCSV as $filename) {
                $filename = str_replace($pathCSV, "", $filename);
                echo '  <option value="' . $filename . '"';
                if ($csvfile == $filename) echo "selected";
                echo '>' . $filename . '</option>';
            }
            echo '</select>';
            echo '&nbsp;<button type="submit" form="form1" value="Submit" class="buttonSelectCSV"><span>SELECT</span></button>';
            echo '</form>';
        } else {
            // If a single one then go to container start page
            if ($do == "") {
                header("Location: main.php?do=selectCSV&csvfile=" . str_replace($pathCSV, "", $filenamesCSV[0]));
            }
        }
    }

    // -----------------------------------------------------------------------------
    // Perform control action if selected
    // -----------------------------------------------------------------------------

    if ($do == "control") {

        # Handle stopping with and without safety check
        # Safety check entry is a component to ensure that only the person with the safety check password can stop a container
        if ($action == "stop") {
            if (trim($safety_check_required) == trim($safety_check) || empty($safety_check_required)) {
                $command = "./iqdesktop.sh stop " . $user;
                $command .= " 1>> ../logs/iqdesktop.log 2>>../logs/iqdesktop_error.log &";

            } else {
                header("Location: safetycheck.html");
            }
			?>
				<div id="floatingBarsG">
					<div class="blockG" id="rotateG_01"></div>
					<div class="blockG" id="rotateG_02"></div>
					<div class="blockG" id="rotateG_03"></div>
					<div class="blockG" id="rotateG_04"></div>
				</div>
			<?php
	        header( "Refresh:2; url=main.php?do=control&csvfile=$csvfile", true, 303);
        }

        # Handle starting with and without safety check
        # Safety check entry is a component to ensure that only the person with the safety check password can start a container
        if ($action == "start") {
            if (trim($safety_check_required) == trim($safety_check) || empty($safety_check_required)) {
                // Handle setting flags
                $privileged = "FALSE"; if ($PRIVILEGED) $privileged = "TRUE";
                $mountbasename = "FALSE"; if ($MOUNT_BASENAME) $mountbasename = "TRUE";
                $iqrtoolscompliance = "FALSE"; if ($IQRTOOLS_COMPLIANCE) $iqrtoolscompliance = "TRUE";
                $sshserver = "FALSE"; if ($SSH_SERVER) $sshserver = "TRUE";
                $csvfilepath = "../".$pathCSV.$csvfile;

                // Handle MOUNT label definitions to ensure no double definitions
                if ($MOUNT5_LABEL==$MOUNT4_LABEL | $MOUNT5_LABEL==$MOUNT4_LABEL | $MOUNT5_LABEL==$MOUNT2_LABEL | $MOUNT5_LABEL==$MOUNT1_LABEL) $MOUNT5_LABEL = "undefined";
                if ($MOUNT4_LABEL==$MOUNT3_LABEL | $MOUNT4_LABEL==$MOUNT2_LABEL | $MOUNT4_LABEL==$MOUNT1_LABEL) $MOUNT4_LABEL = "undefined";
                if ($MOUNT3_LABEL==$MOUNT2_LABEL | $MOUNT3_LABEL==$MOUNT1_LABEL) $MOUNT3_LABEL = "undefined";
                if ($MOUNT2_LABEL==$MOUNT1_LABEL) $MOUNT2_LABEL = "undefined";

                # Construct iqdesktop.sh call
                $command = "./iqdesktop.sh start " . $user . " " . $csvfilepath . " " . $image . " " . $nrcores . " " . $memgb . " " . $theme . " " . $SHM_SIZE_GB . " ";
                $command .= $ALLOW_SUDO . " " . $PRIVILEGED . " " . $MOUNT_BASENAME . " ";
                $command .= $IQRTOOLS_COMPLIANCE . " " . $SSH_SERVER . " " . $ALLOW_SHINY_SERVER . " " . $MAC_ADDRESS . " " . $TIMEZONE . " " . $IQREPORT_TEMPLATE . " ";
                $command .= $NONMEM_LICENSE_KEY . " \"" . $MONOLIX_LICENSE_KEY . "\" ";
                $command .= " \"" . $ORGANIZATION . "\" ";
                $command .= " \"" . $LICENSEKEY . "\" ";
                $command .= " \"" . $MOUNT1_LABEL . "\" ";
                $command .= " \"" . $MOUNT2_LABEL . "\" ";
                $command .= " \"" . $MOUNT3_LABEL . "\" ";
                $command .= " \"" . $MOUNT4_LABEL . "\" ";
                $command .= " \"" . $MOUNT5_LABEL . "\" ";
                $command .= " \"" . $LIST_SERVER_IP . "\" ";
                $command .= " \"" . $LIST_SERVER_OPTIONS . "\" ";

                # Check if demo mode and then add the stop time
                if ($csvfile=="01_demo.csv") $command .= $MAX_TIME_HOURS_DEMO . " ";

                $command .= "1>> ../logs/iqdesktop.log 2>>../logs/iqdesktop_error.log &";

				#echo $command."<br>"; exit;
            } else {
                header("Location: safetycheck.html");
            }
			// Spow spinner and then sleep
			?>
				<div id="floatingBarsG">
					<div class="blockG" id="rotateG_01"></div>
					<div class="blockG" id="rotateG_02"></div>
					<div class="blockG" id="rotateG_03"></div>
					<div class="blockG" id="rotateG_04"></div>
				</div>
			<?php
	        header( "Refresh:8; url=main.php?do=control&csvfile=$csvfile", true, 303);
        }

        echo '<pre>';
        $old_path = getcwd();
        chdir($path);
        shell_exec("chmod +x iqdesktop.sh");
        shell_exec($command);
        chdir($old_path);
        echo '</pre>';

        // sleep for 5 seconds to let the shell script run
        //sleep(5);
    }

    // -----------------------------------------------------------------------------
    // Find available iqdesktop versions
    // -----------------------------------------------------------------------------
    system('docker images --filter=reference=intiquan/iqdesktop:*.* > temp');
    $content = file_get_contents(temp);
    //print_r($content);
    preg_match_all('/intiquan\/iqdesktop[ ]+([0-9.]+)/', $content, $m);
    //print_r($m[0]);
    $IMAGE_VERSIONS = $m[0];
    // Define default image as the latest one
    $IMAGE = str_replace("   ", ":", $IMAGE_VERSIONS[0]);

    // -----------------------------------------------------------------------------
    // Read CSV if filename defined and build table
    // -----------------------------------------------------------------------------
    if (!empty($csvfile)) {
        if ($SHOW_INFOTEXT) {
            echo $INFOTEXT."<br>";
        }

        # Write out information in case of general VNC certificates active
        if (file_exists("iqdesktop_VNC_cert.pem")) {
            ?>
            <table class="shaded"><tr><td>
            <h3>VNC Certificate</h3>
            The VNC connection is set up to be encrypted. Do the following:
            <ul>
                <li>Download the certificate: <a href="iqdesktop_VNC_cert.pem" target="new">iqdesktop_VNC_cert.pem</a> and store it on your system.
                <li>Open the TigerVNC GUI and provide path to certificate in Options->Security->Path to X509 CA certificate.
                <li>Or call Tiger VNC from command line: "vncviewer -SecurityTypes X509Vnc -X509CA iqdesktop_VNC_cert.pem <?php echo $SERVER_ADDRESS; ?>:VNCPORT"
                <li>When working on multiple IQdesktop servers it is recommended to use different file names for the VNC certificates!
            </ul>
            </td></tr></table>
            <br>
            <?php 
        } 

        if ($csvfile=="01_demo.csv") {
            ?>
            <table class="shaded"><tr><td>
            <h3>Demo System Settings and Agreements</h3>
            <ul>
                <li><b>Time limit:</b> <span style="color:#f4A033; font-weight:bold;">The time limit is set to: <?php echo $MAX_TIME_HOURS_DEMO; ?> hours</span>. The demo system is set up with a time limit on how long IQdesktop can run. When the runtime exceeds this time limit IQdesktop
                    is stopped automatically <b>without prior warning</b>.
                    <li><b>VNC Encryption:</b> For the purpose of this demo server the VNC connection encryption is disabled. 
                    <li><b>Start Password:</b> For the purpose of this demo server the 'Start Password' is the same as the 'Username' in the table below. 
            </ul>
            <b>By starting IQdesktop through the use of this webpage you certify that you have read, understood, and aggree to the information on this webpage,
            specifically the "Disclaimer" section and the "Demo System Settings and Agreements" section.</b>
            </td></tr></table>
            <br>
            <?php 

        }
 
        // Add path to filename
        $fullfilename = $pathCSV . $csvfile;

        // Read the CSV file contents into an array
        $csvinfo = [];
        // Open the file for reading
        if (($h = fopen("{$fullfilename}", "r")) !== FALSE) {
            // Each line in the file is converted into an individual array that we call $data
            // The items of the array are comma separated
            while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
                // Each individual array is being pushed into the nested array
                $csvinfo[] = $data;
                //print_r($data);
            }
            // Close the file
            fclose($h);
        }
        //print_r($csvinfo);

        // Build a table with form
        echo '<table class="control">';
        $header = 1;
        foreach ($csvinfo as $value) {
            // print_r($value);
            // echo "<p>";
            $NAME = $value[0];
            $USER = $value[1];
            $SAFETY_CHECK = $value[2];
            $PASSWORD = $value[3];
            $VOLUME_MAP = $value[4];
            $VNCPORT = $value[5];
            $SSHPORT = $value[6];
            $SHINY_SERVER_PORT = $value[7];
            $USER_ID = $value[8];

            if (!empty($USER)) {

                if (empty($VOLUME_MAP)) $VOLUME_MAP = "Not mapped";
                if (empty($IQREPORT_TEMPLATE)) $IQREPORT_TEMPLATE = "Default";

                if ($header == 1) {
                    echo "<tr>";
                    echo "<th>Control</th>";
                    if ($SAFETY_CHECK_SHOW) echo "<th>" . $SAFETY_CHECK_TH_TEXT . "</th>";
                    if ($NAME_SHOW) echo "<th>" . $NAME_TH_TEXT . "</th>";
                    if ($USER_SHOW) echo "<th>" . $USER_TH_TEXT . "</th>";
                    if ($PASSWORD_SHOW) echo "<th>" . $PASSWORD_TH_TEXT . "</th>";
                    if ($VNCPORT_SHOW) echo "<th>" . $VNCPORT_TH_TEXT . "</th>";
                    if ($SSHPORT_SHOW) echo "<th>" . $SSHPORT_TH_TEXT . "</th>";
                    if ($SHINY_SERVER_PORT_SHOW) echo "<th>" . $SHINY_SERVER_PORT_TH_TEXT . "</th>";
                    if ($IMAGE_SHOW) echo "<th>" . $IMAGE_TH_TEXT . "</th>";
                    if ($THEME_SHOW) echo "<th>" . $THEME_TH_TEXT . "</th>";
                    if ($NR_CORES_SHOW) echo "<th>" . $NR_CORES_TH_TEXT . "</th>";
                    if ($MEMORY_GB_SHOW) echo "<th>" . $MEMORY_GB_TH_TEXT . "</th>";
                    if ($ALLOW_SUDO_SHOW) echo "<th>" . $ALLOW_SUDO_TH_TEXT . "</th>";
                    if ($SHM_SIZE_GB_SHOW) echo "<th>" . $SHM_SIZE_GB_TH_TEXT . "</th>";
                    if ($VOLUME_MAP_SHOW) echo "<th>" . $VOLUME_MAP_TH_TEXT . "</th>";
                    if ($SSH_SERVER_SHOW) echo "<th>" . $SSH_SERVER_TH_TEXT . "</th>";
                    if ($ALLOW_SHINY_SERVER_SHOW) echo "<th>" . $ALLOW_SHINY_SERVER_TH_TEXT . "</th>";
                    if ($USER_ID_SHOW) echo "<th>" . $USER_ID_TH_TEXT . "</th>";
                    if ($MAC_SHOW) echo "<th>" . $MAC_TH_TEXT . "</th>";
                    if ($TIMEZONE_SHOW) echo "<th>" . $TIMEZONE_TH_TEXT . "</th>";
                    if ($IQRTOOLS_COMPLIANCE_SHOW) echo "<th>" . $IQRTOOLS_COMPLIANCE_TH_TEXT . "</th>";
                    if ($IQREPORT_TEMPLATE_SHOW) echo "<th>" . $IQREPORT_TEMPLATE_TH_TEXT . "</th>";
                    
                    if ($MOUNT_SHOW) {
                        echo "<th>Mount 1</th>";
                        echo "<th>Mount 2</th>";
                        echo "<th>Mount 3</th>";
                        echo "<th>Mount 4</th>";
                        echo "<th>Mount 5</th>";
                    }

                    echo "</tr>";
                    $header = 0;
                } else {
                    // Check if container running
                    $container_running = FALSE;
                    if (file_exists($path . "yml_custom/" . $USER . "/docker-compose.yml")) {
                        $container_running = TRUE;
                        // Also load the yml file and parse image, ncores, and memory to replace CSV defaults
                        $content = file_get_contents($path . "yml_custom/" . $USER . "/docker-compose.yml");
                        // Parse the image information
                        preg_match_all('/intiquan\/iqdesktop:([0-9\.]+)/', $content, $m);
                        $IMAGEuser = $m[0][0];
                        // Parse the ncores information
                        preg_match_all('/cpus: ([0-9]+)/', $content, $m);
                        $NR_CORESuser = $m[1][0];
                        // Parse the memory information
                        preg_match_all('/mem_limit: (["0-9]+)/', $content, $m);
                        $MEMORY_GBuser = str_replace('"', '', $m[1][0]);
                        // Parse theme information
                        preg_match_all('/THEME=(["a-zA-z0-9]+)/', $content, $m);
                        if ($m[1][0] != "") {
                            $THEMEuser = $m[1][0];
                        } else {
                            $THEMEuser = $THEME;
                        }
                    } else {
                        $IMAGEuser = $IMAGE;
                        $NR_CORESuser = $NR_CORES;
                        $MEMORY_GBuser = $MEMORY_GB;
                        $THEMEuser = $THEME;
                    }
                    
                    echo "<tr>" . '<td class="control">';
                    // The buttons
                    $form = "form_" . $USER;
                    echo '<form action="/main.php?do=control&csvfile='.$csvfile.'" method="post" id="' . $form . '">';
                    echo '<input type="hidden" name="safety_check_required" value="' . $SAFETY_CHECK . '">';
                    echo '<input type="hidden" name="do" value="control">';
                    echo '<input type="hidden" name="csvfile" value="' . $csvfile . '">';
                    $buttonText = "START";
                    $buttonStyle = "buttonRed";
                    $action = "start";
                    if ($container_running) {
                        $buttonText = "STOP";
                        $buttonStyle = "buttonGreen";
                        $action = "stop";
                    }
                    echo '<input type="hidden" name="user" value="' . $USER . '">';
                    echo '<input type="hidden" name="action" value="' . $action . '">';
                    echo '<button type="submit" form="' . $form . '" value="Submit" class="' . $buttonStyle . '"><span>' . $buttonText . '</span></button></td>';

                    ///////////////////////////////////////////////////////////////////////////////////
                    // Start table cells
                    ///////////////////////////////////////////////////////////////////////////////////
                    
                    $inputTypeSafety = "text";
                    if ($START_PASSWORD_HIDDEN) $inputTypeSafety = "password";

                    if ($SAFETY_CHECK_SHOW) echo '<td><input type="'.$inputTypeSafety.'" name="safety_check" size="10"></td>';
                    if ($NAME_SHOW) echo "<td>" . $NAME . "</td>";
                    if ($USER_SHOW) echo "<td class='blue'>" . $USER . "</td>";
                    if ($PASSWORD_SHOW) echo "<td class='blue'>" . $PASSWORD . "</td>";
                    if ($VNCPORT_SHOW) echo "<td class='blue'>" . $VNCPORT . "</td>";
                    if ($SSHPORT_SHOW) echo "<td class='blue'>" . $SSHPORT . "</td>";
                    if ($SHINY_SERVER_PORT_SHOW) echo "<td class='blue'>" . $SHINY_SERVER_PORT . "</td>";

                    // Selection of image
                    if ($IMAGE_SHOW) {
                        echo '<td><select name="image">';
                        foreach ($IMAGE_VERSIONS as $version) {
                            $version = str_replace("   ", ":", $version);
                            echo '  <option value="' . $version . '" ';
                            if ($IMAGEuser == $version) echo "selected";
                            $version_show = $version;
                            if ($version_show=="intiquan/iqdesktop:0.0.0") $version_show = "PUBLIC Version";
                            echo '>' . $version_show . '</option>';
                        }
                        echo '</td></select>';
                    } else {
						# Important to have default - if not shown - take default 
						echo '<input type="hidden" name="image" value="' . $IMAGEuser . '">';
					}

                    if ($THEME_SHOW) {
                        // Selection of theme
                        echo '<td><select name="theme">';
                        echo '  <option value="light" ';
                        if ($THEMEuser == "light") echo "selected";
                        echo '>light</option>';
                        echo '  <option value="dark" ';
                        if ($THEMEuser == "dark") echo "selected";
                        echo '>dark</option>';
                        echo '</select></td>';
                    }  else {
						# Important to have default - if not shown - take default 
						echo '<input type="hidden" name="theme" value="' . $THEMEuser . '">';
					}
						

                    if ($NR_CORES_SHOW) { // Selection of nr cores
                        echo '<td><select name="nrcores">';
                        echo '  <option value="1" ';
                        if ($NR_CORESuser == 1) echo "selected";
                        echo '>1</option>';
                        if ($MAX_CORES >= 2) {
                            echo '  <option value="2" ';
                            if ($NR_CORESuser == 2) echo "selected";
                            echo '>2</option>';
                        }
                        if ($MAX_CORES >= 4) {
                            echo '  <option value="4" ';
                            if ($NR_CORESuser == 4) echo "selected";
                            echo '>4</option>';
                        }
                        if ($MAX_CORES >= 8) {
                            echo '  <option value="8" ';
                            if ($NR_CORESuser == 8) echo "selected";
                            echo '>8</option>';
                        }
                        if ($MAX_CORES >= 12) {
                            echo '  <option value="12" ';
                            if ($NR_CORESuser == 12) echo "selected";
                            echo '>12</option>';
                        }
                        if ($MAX_CORES >= 16) {
                            echo '  <option value="16" ';
                            if ($NR_CORESuser == 16) echo "selected";
                            echo '>16</option>';
                        }
                        if ($MAX_CORES >= 24) {
                            echo '  <option value="24" ';
                            if ($NR_CORESuser == 24) echo "selected";
                            echo '>24</option>';
                        }
                        if ($MAX_CORES >= 32) {
                            echo '  <option value="32" ';
                            if ($NR_CORESuser == 32) echo "selected";
                            echo '>32</option>';
                        }
                        if ($MAX_CORES >= 64) {
                            echo '  <option value="64" ';
                            if ($NR_CORESuser == 64) echo "selected";
                            echo '>64</option>';
                        }
                        if ($MAX_CORES >= 72) {
                            echo '  <option value="72" ';
                            if ($NR_CORESuser == 72) echo "selected";
                            echo '>72</option>';
                        }
                        if ($MAX_CORES >= 96) {
                            echo '  <option value="96" ';
                            if ($NR_CORESuser == 96) echo "selected";
                            echo '>96</option>';
                        }
                        echo '</select></td>';
                    } else {
						# Important to have default - if not shown 
						echo '<input type="hidden" name="nrcores" value="' . $NR_CORESuser . '">';
					}

                    // Selection of memory
                    if ($MEMORY_GB_SHOW) {
                        echo '<td><select name="memgb">';
                        echo '  <option value="8" ';
                        if ($MEMORY_GBuser == 8) echo "selected";
                        echo '>8</option>';

                        if ($MAX_MEM >= 12) {
                            echo '  <option value="12" ';
                            if ($MEMORY_GBuser == 12) echo "selected";
                            echo '>12</option>';
                        }

                        if ($MAX_MEM >= 16) {
                            echo '  <option value="16" ';
                            if ($MEMORY_GBuser == 16) echo "selected";
                            echo '>16</option>';
                        }

                        if ($MAX_MEM >= 24) {
                            echo '  <option value="24" ';
                            if ($MEMORY_GBuser == 24) echo "selected";
                            echo '>24</option>';
                        }

                        if ($MAX_MEM >= 32) {
                            echo '  <option value="32" ';
                            if ($MEMORY_GBuser == 32) echo "selected";
                            echo '>32</option>';
                        }

                        if ($MAX_MEM >= 48) {
                            echo '  <option value="48" ';
                            if ($MEMORY_GBuser == 48) echo "selected";
                            echo '>48</option>';
                        }

                        if ($MAX_MEM >= 64) {
                            echo '  <option value="64" ';
                            if ($MEMORY_GBuser == 64) echo "selected";
                            echo '>64</option>';
                        }

                        if ($MAX_MEM >= 128) {
                            echo '  <option value="128" ';
                            if ($MEMORY_GBuser == 128) echo "selected";
                            echo '>128</option>';
                        }

                        if ($MAX_MEM >= 196) {
                            echo '  <option value="196" ';
                            if ($MEMORY_GBuser == 196) echo "selected";
                            echo '>196</option>';
                        }

                        if ($MAX_MEM >= 256) {
                            echo '  <option value="256" ';
                            if ($MEMORY_GBuser == 256) echo "selected";
                            echo '>256</option>';
                        }

                        echo '</select></td>';
                    } else {
						# Important to have default - if not shown 
						echo '<input type="hidden" name="memgb" value="' . $MEMORY_GBuser . '">';
					}

                    if ($ALLOW_SUDO_SHOW) echo "<td class='blue'>" . $ALLOW_SUDO . "</td>";
                    if ($SHM_SIZE_GB_SHOW) echo "<td class='blue'>" . $SHM_SIZE_GB . "</td>";
                    if ($VOLUME_MAP_SHOW) echo "<td class='blue'>" . $VOLUME_MAP . "</td>";
                    
                    if ($SSH_SERVER_SHOW) echo "<td class='blue'>" . $SSH_SERVER . "</td>";
                    if ($ALLOW_SHINY_SERVER_SHOW) echo "<td class='blue'>" . $ALLOW_SHINY_SERVER . "</td>";
                    if ($USER_ID_SHOW) echo "<td class='blue'>" . $USER_ID . "</td>";

                    if ($MAC_SHOW) echo "<td class='blue'>" . $MAC_ADDRESS . "</td>";

                    if ($TIMEZONE_SHOW) echo "<td class='blue'>" . $TIMEZONE . "</td>";
                    if ($IQRTOOLS_COMPLIANCE_SHOW) echo "<td class='blue'>" . $IQRTOOLS_COMPLIANCE . "</td>";
                    if ($IQREPORT_TEMPLATE_SHOW) echo "<td class='blue'>" . $IQREPORT_TEMPLATE . "</td>";
                    
                    # Only show the folders for selection when the container is NOT running.
                    # We will NOT store the state of the running containers and display it here!
                    if ($MOUNT_SHOW & !$container_running) {
                        // Read and evaluate $LIST_SERVER_FOLDERS to prepare for display in select option in the table
                        $SERVER_FOLDERS_MOUNT = explode(",",$LIST_SERVER_FOLDERS);
                        #print_r($SERVER_FOLDERS_MOUNT);
                        
                        # MOUNT 1
                        echo '<td><select name="MOUNT1_LABEL">';
                        foreach ($SERVER_FOLDERS_MOUNT as $value) {
                            echo '  <option value="'.$value.'" ';
                            if ($value == $SERVER_FOLDERS_MOUNT[0]) echo "selected";
                            echo '>'.$value.'</option>';
                        }
                        echo '</select></td>';

                        # MOUNT 2
                        echo '<td><select name="MOUNT2_LABEL">';
                        foreach ($SERVER_FOLDERS_MOUNT as $value) {
                            echo '  <option value="'.$value.'" ';
                            if ($value == $SERVER_FOLDERS_MOUNT[1]) echo "selected";
                            echo '>'.$value.'</option>';
                        }                        
                        echo '</select></td>';

                        # MOUNT 3
                        echo '<td><select name="MOUNT3_LABEL">';
                        foreach ($SERVER_FOLDERS_MOUNT as $value) {
                            echo '  <option value="'.$value.'" ';
                            if ($value == $SERVER_FOLDERS_MOUNT[2]) echo "selected";
                            echo '>'.$value.'</option>';                        
                        }
                        echo '</select></td>';

                        # MOUNT 4
                        echo '<td><select name="MOUNT4_LABEL">';
                        foreach ($SERVER_FOLDERS_MOUNT as $value) {
                            echo '  <option value="'.$value.'" ';
                            if ($value == $SERVER_FOLDERS_MOUNT[3]) echo "selected";
                            echo '>'.$value.'</option>';                        
                        }
                        echo '</select></td>';

                        # MOUNT 5
                        echo '<td><select name="MOUNT5_LABEL">';
                        foreach ($SERVER_FOLDERS_MOUNT as $value) {
                            echo '  <option value="'.$value.'" ';
                            if ($value == $SERVER_FOLDERS_MOUNT[4]) echo "selected";
                            echo '>'.$value.'</option>';                        
                        }
                        echo '</select></td>';


                    
                    }

                    echo "</tr></form>";
                }
            }
        }
        echo "</table>";
    }
    ?>

</body>

</html>