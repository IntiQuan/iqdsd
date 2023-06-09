<?php
$prefix_folder = ".."; include("../includes/load_settings.inc"); // Load settings 
$prefix_folder = ".."; include("../includes/load_infotext.inc"); // Load infotext
include("../includes/getvars_adminpage.inc"); // Get variables 
include("../includes/log_adminpage.inc"); // Create logs (after get variables)
?>

<html>
<head>
    <title>IQdesktopServer Admin</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/favIQ.png">
</head>
<body>
    <h1><?php echo "Admin - ".$SERVER_NAME." (".$SERVER_ADDRESS.")" ?></h1>
    <h2>
        <a href="index.php">Home</a>
        |
        <a href="https://iqdesktop.intiquan.com" target="new">More information</a>
        |
        <a href="https://www.intiquan.com" target="new">IntiQuan</a>
        |
        <a href="/">User Interface</a>
    </h2>

    <?php
    if ($do == "updateSettings") {
        // Construct settings text
        $settingsText = "<?php\n";
        $settingsText .= "///////////////////////////\n";
        $settingsText .= "// Server Settings\n";
        $settingsText .= "///////////////////////////\n";
        $settingsText .= "$" . "SERVER_NAME = \"" . $set_SERVER_NAME . "\";\n";
        $settingsText .= "$" . "SERVER_ADDRESS = \"" . $set_SERVER_ADDRESS . "\";\n";
        $settingsText .= "$" . "SHOW_INFOTEXT = " . $set_SHOW_INFOTEXT . ";\n";
        $settingsText .= "$" . "SHOW_ADMINLINK = " . $set_SHOW_ADMINLINK . ";\n";
        $settingsText .= "$" . "START_PASSWORD_HIDDEN = " . $set_START_PASSWORD_HIDDEN . ";\n";
        $settingsText .= "$" . "IGNORE_DEMO_CSV = " . $set_IGNORE_DEMO_CSV . ";\n";
        $settingsText .= "\n";
        $settingsText .= "///////////////////////////\n";
        $settingsText .= "// Other settings\n";
        $settingsText .= "///////////////////////////\n";
        $settingsText .= "$" . "ORGANIZATION = \"" . $set_ORGANIZATION . "\";\n";
        $settingsText .= "$" . "LICENSEKEY = \"" . $set_LICENSEKEY . "\";\n";
        $settingsText .= "\n";
        $settingsText .= "///////////////////////////\n";
        $settingsText .= "// Container settings\n";
        $settingsText .= "// - logicals in on purpose\n";
        $settingsText .= "///////////////////////////\n";
        $settingsText .= "$" . "MAX_CORES = " . $set_MAX_CORES . ";\n";
        $settingsText .= "$" . "MAX_MEM = " . $set_MAX_MEM . ";\n";
        $settingsText .= "$" . "MAX_TIME_HOURS_DEMO = " . $set_MAX_TIME_HOURS_DEMO . ";\n";
        $settingsText .= "$" . "PRIVILEGED = \"" . $set_PRIVILEGED . "\";\n";
        $settingsText .= "$" . "MOUNT_BASENAME = \"" . $set_MOUNT_BASENAME . "\";\n";
        $settingsText .= "$" . "MAC_ADDRESS = \"" . $set_MAC_ADDRESS . "\";\n";
        $settingsText .= "$" . "TIMEZONE = \"" . $set_TIMEZONE . "\";\n";
        $settingsText .= "$" . "IQREPORT_TEMPLATE = \"" . $set_IQREPORT_TEMPLATE . "\";\n";
        $settingsText .= "$" . "IQRTOOLS_COMPLIANCE = \"" . $set_IQRTOOLS_COMPLIANCE . "\";\n";
        $settingsText .= "$" . "NONMEM_LICENSE_KEY = \"" . $set_NONMEM_LICENSE_KEY . "\";\n";
        $settingsText .= "$" . "MONOLIX_LICENSE_KEY = \"" . $set_MONOLIX_LICENSE_KEY . "\";\n";
        $settingsText .= "$" . "ALLOW_SUDO = \"" . $set_ALLOW_SUDO . "\";\n";
        $settingsText .= "$" . "SSH_SERVER = \"" . $set_SSH_SERVER . "\";\n";
        $settingsText .= "$" . "ALLOW_SHINY_SERVER = \"" . $set_ALLOW_SHINY_SERVER . "\";\n";
        $settingsText .= "$" . "THEME = \"" . $set_THEME . "\";\n";
        $settingsText .= "$" . "SHM_SIZE_GB = " . $set_SHM_SIZE_GB . ";\n";
        $settingsText .= "$" . "NR_CORES = " . $set_NR_CORES . ";\n";
        $settingsText .= "$" . "MEMORY_GB = " . $set_MEMORY_GB . ";\n";
        $settingsText .= "\n";
        $settingsText .= "///////////////////////////\n";
        $settingsText .= "// Table columns selection\n";
        $settingsText .= "///////////////////////////\n";
        $settingsText .= "$" . "NAME_SHOW = " . $set_NAME_SHOW . ";\n";
        $settingsText .= "$" . "USER_SHOW = " . $set_USER_SHOW . ";\n";
        $settingsText .= "$" . "SAFETY_CHECK_SHOW = " . $set_SAFETY_CHECK_SHOW . ";\n";
        $settingsText .= "$" . "PASSWORD_SHOW = " . $set_PASSWORD_SHOW . ";\n";
        $settingsText .= "$" . "IMAGE_SHOW = " . $set_IMAGE_SHOW . ";\n";
        $settingsText .= "$" . "VOLUME_MAP_SHOW = " . $set_VOLUME_MAP_SHOW . ";\n";
        $settingsText .= "$" . "VNCPORT_SHOW = " . $set_VNCPORT_SHOW . ";\n";
        $settingsText .= "$" . "SSHPORT_SHOW = " . $set_SSHPORT_SHOW . ";\n";
        $settingsText .= "$" . "SHINY_SERVER_PORT_SHOW = " . $set_SHINY_SERVER_PORT_SHOW . ";\n";
        $settingsText .= "$" . "ALLOW_SUDO_SHOW = " . $set_ALLOW_SUDO_SHOW . ";\n";
        $settingsText .= "$" . "SSH_SERVER_SHOW = " . $set_SSH_SERVER_SHOW . ";\n";
        $settingsText .= "$" . "ALLOW_SHINY_SERVER_SHOW = " . $set_ALLOW_SHINY_SERVER_SHOW . ";\n";
        $settingsText .= "$" . "USER_ID_SHOW = " . $set_USER_ID_SHOW . ";\n";
        $settingsText .= "$" . "THEME_SHOW = " . $set_THEME_SHOW . ";\n";
        $settingsText .= "$" . "MAC_SHOW = " . $set_MAC_SHOW . ";\n";
        $settingsText .= "$" . "SHM_SIZE_GB_SHOW = " . $set_SHM_SIZE_GB_SHOW . ";\n";
        $settingsText .= "$" . "NR_CORES_SHOW = " . $set_NR_CORES_SHOW . ";\n";
        $settingsText .= "$" . "MEMORY_GB_SHOW = " . $set_MEMORY_GB_SHOW . ";\n";
        $settingsText .= "$" . "TIMEZONE_SHOW = " . $set_TIMEZONE_SHOW . ";\n";
        $settingsText .= "$" . "IQRTOOLS_COMPLIANCE_SHOW = " . $set_IQRTOOLS_COMPLIANCE_SHOW . ";\n";
        $settingsText .= "$" . "IQREPORT_TEMPLATE_SHOW = " . $set_IQREPORT_TEMPLATE_SHOW . ";\n";
        $settingsText .= "$" . "MOUNT_SHOW = " . $set_MOUNT_SHOW . ";\n";
        $settingsText .= "?>\n";

        // Save settingsText to file
        file_put_contents("../settings/settings.inc", $settingsText);

        // Save set_INFOTEXT to file
        file_put_contents("../settings/infotext.inc", $set_INFOTEXT);

    ?>
        <h3>Settings saved!</h3>
        <a href="index.php">Click to Reload Page (showing new settings might not show immediately due to caching)</a>
    <?php
    }
    ?>

    <?php
    if ($do == "VNCcert") {
        if ($action == "rmVNCcert") {
            // Remove certificate files
            unlink("iqdesktop_VNC_key.pem");
            unlink("../iqdesktop_VNC_cert.pem");
        }
        if ($action == "genVNCcert") {
            // Generate certificate files
            // Key file:
            $command = "openssl genpkey -algorithm RSA -pkeyopt rsa_keygen_bits:$BIT_vnccert -out iqdesktop_VNC_key.pem";
            shell_exec($command);
            // Cert file:
            $command = "openssl req -key iqdesktop_VNC_key.pem -x509 -new -days $days_vnccert -out iqdesktop_VNC_cert.pem -subj \"/C=$C_vnccert/ST=$ST_vnccert/L=$L_vnccert/O=$O_vnccert/OU=$OU_vnccert/CN=$CN_vnccert\"";
            shell_exec($command);
            // Move cert file
            rename("iqdesktop_VNC_cert.pem", "../iqdesktop_VNC_cert.pem");
        }
    ?>
        <h3>Settings saved!</h3>
        <a href="index.php">Click to Reload Page (showing new settings might not show immediately due to caching)</a>
    <?php
    }
    ?>

    <?php
    if ($do == "Monitoring") {
        if ($action == "startMonitoring") {
            // Start the monitoring script ... 
            shell_exec("chmod +x ../stats/monitor_stats.sh");
	        $command = "../stats/monitor_stats.sh > ../stats/stats.log &";
            shell_exec($command);
        }
        if ($action == "stopMonitoring") {
            // Kill the sleep and monitor_stats thingy
            $command = 'PID=$(ps -A | grep monitor_stats | awk \'{print $1}\'); kill -9 $PID';
            echo $command;
            shell_exec($command);
            $command = "PID=$(ps -A | grep sleep | awk '{print $1}'); kill -9 $PID";
            shell_exec($command);
            // Remove log file
            unlink("../stats/stats.log");
        }
    ?>
        <h3>Settings saved!</h3>
        <a href="index.php">Click to Reload Page (showing new settings might not show immediately due to caching)</a>
    <?php
    }
    ?>

    <?php
    if ($do == "showsettings") {
        // Show the settings form
    ?>
        <h3>Security & Encryption</h3>
        <?php
        $pathVNCkey = "iqdesktop_VNC_key.pem";
        $pathVNCcert = "../iqdesktop_VNC_cert.pem";
        $buttonText = "Enable VNC Certificates";
        $buttonStyle = "buttonRed";
        $action = "genVNCcert";
        if (file_exists($pathVNCkey) & file_exists($pathVNCcert)) {
            $buttonText = "Disable VNC Certificates";
            $buttonStyle = "buttonGreen";
            $action = "rmVNCcert";
        }
        // Generate button to create or remove certificates
        $form = "form_VNCcert";
        echo '<form action="main.php" method="post" id="' . $form . '">';
        echo '<input type="hidden" name="do" value="VNCcert">';
        echo "<table>";
        echo "<tr>" . '<td class="control">';
        echo '<input type="hidden" name="action" value="' . $action . '">';
        echo '<button type="submit" form="' . $form . '" value="Submit" class="' . $buttonStyle . '"><span>' . $buttonText . '</span></button>' . "<br>";
        echo '</td>';
        echo "<td colspan=2>";
        echo "Control the presence and use of VNC certificates for encryption of transfer through VNC. ";
        echo "Enabling VNC encryption will generate VNC certificates. ";
        echo "On the user page the user will be able to download the certificate file to install it in the VNC client. ";
        if ($buttonStyle == "buttonGreen") {
        ?>
            <br>
            <ul>
                <li><a href="../iqdesktop_VNC_cert.pem" target="new">Certificate File (iqdesktop_VNC_cert.pem)</a></li>
                <li><a href="iqdesktop_VNC_key.pem" target="new">Key File (iqdesktop_VNC_key.pem)</a></li>
            </ul>
        <?php
        }
        echo "</td>";
        if ($buttonStyle == "buttonRed") {
            echo "</tr>";
        ?>
            <tr>
                <td>/C=CH</td>
                <td width=100><input type="text" name="C_vnccert" size="30" value="<?php echo $C_vnccert; ?>"></td>
                </td>
                <td>Country Name (2 letter code)</td>
            </tr>
            <tr>
                <td>/ST=BS</td>
                <td width=100><input type="text" name="ST_vnccert" size="30" value="<?php echo $ST_vnccert; ?>"></td>
                </td>
                <td>State or Province Name (full name)</td>
            </tr>
            <tr>
                <td>/L=Basel</td>
                <td width=100><input type="text" name="L_vnccert" size="30" value="<?php echo $L_vnccert; ?>"></td>
                </td>
                <td>Locality Name (eg, city)</td>
            </tr>
            <tr>
                <td>/O=IntiQuan GmbH</td>
                <td width=100><input type="text" name="O_vnccert" size="30" value="<?php echo $O_vnccert; ?>"></td>
                </td>
                <td>Organization Name (eg, company)</td>
            </tr>
            <tr>
                <td>/OU=IQdesktop</td>
                <td width=100><input type="text" name="OU_vnccert" size="30" value="<?php echo $OU_vnccert; ?>"></td>
                </td>
                <td>Organizational Unit Name (eg, section)</td>
            </tr>
            <tr>
                <td>/CN=iqdesktop.intiquan.com</td>
                <td width=100><input type="text" name="CN_vnccert" size="30" value="<?php echo $CN_vnccert; ?>"></td>
                </td>
                <td>Common Name (e.g. server FQDN or YOUR name)</td>
            </tr>
            <tr>
                <td>rsa_keygen_bits</td>
                <td width=100><input type="text" name="BIT_vnccert" size="30" value="<?php echo $BIT_vnccert; ?>"></td>
                </td>
                <td>Number of bits for the key (2048 or 4096 are good choices)</td>
            </tr>
            <tr>
                <td>days</td>
                <td width=100><input type="text" name="days_vnccert" size="30" value="<?php echo $days_vnccert; ?>"></td>
                </td>
                <td>Number of days until expiration</td>
            </tr>
        <?php
        }
        echo "</table>";
        echo "</form>";
        ?>

	<h3>Server Load Monitoring</h3>
        <?php
        $monitoringLog = "../stats/stats.log";
        $buttonText = "Start Monitoring";
        $buttonStyle = "buttonRed";
        $action = "startMonitoring";
        if (file_exists($monitoringLog)) {
            $buttonText = "Stop Monitoring";
            $buttonStyle = "buttonGreen";
            $action = "stopMonitoring";
        }
        // Generate button to create or remove certificates
        $form = "form_monitoring";
        echo '<form action="main.php" method="post" id="' . $form . '">';
        echo '<input type="hidden" name="do" value="Monitoring">';
        echo "<table>";
        echo "<tr>" . '<td class="control">';
        echo '<input type="hidden" name="action" value="' . $action . '">';
        echo '<button type="submit" form="' . $form . '" value="Submit" class="' . $buttonStyle . '"><span>' . $buttonText . '</span></button>' . "<br>";
        echo '</td>';
        echo "<td colspan=2>";
        echo "Enable logging of disk, memory and CPU load in a log file. The information is stored in CSV format and once started it can be downloaded. The interval for collection of information is 15 min.";
        if ($buttonStyle == "buttonGreen") {
        ?>
            <br>
            <ul>
                <li><a href="../stats/stats.log" target="new">Monitoring log file</a></li>
            </ul>
        <?php
        }
        echo "</td>";
        if ($buttonStyle == "buttonRed") {
            echo "</tr>";
        }
        echo "</table>";
        echo "</form>";
        ?>

        <h3>General Settings</h3>
        <form action="main.php" method="post" id="form1">
            <input type="hidden" name="do" value="updateSettings">
            <table>
                <tr>
                    <td colspan="3"><button type="submit" form="form1" value="Submit" class="buttonSelectCSV"><span>SAVE</span></button></td>
                </tr>
                <!------------------------------------------------------------------
                  Server Settings
                ------------------------------------------------------------------->
                <tr>
                    <th colspan="3">Server Settings</th>
                </tr>
                <tr>
                    <td>SERVER_NAME:</td>
                    <td><input type="text" name="set_SERVER_NAME" size="30" value="<?php echo $SERVER_NAME; ?>"></td>
                    <td>Set the server name (used as page title and for display)</td>
                </tr>
                <tr>
                    <td>SERVER_ADDRESS:</td>
                    <td><input type="text" name="set_SERVER_ADDRESS" size="30" value="<?php echo $SERVER_ADDRESS; ?>"></td>
                    <td>Set server address (used for display)</td>
                </tr>
                <tr>
                    <td>SHOW_INFOTEXT:</td>
                    <td><input type="checkbox" name="set_SHOW_INFOTEXT" value="TRUE" <?php if ($SHOW_INFOTEXT) echo "checked"; ?>></td>
                    <td>Show Info Text on user page (enter in the text area at the bottom of this page)</td>
                </tr>
                <tr>
                    <td>SHOW_ADMINLINK:</td>
                    <td><input type="checkbox" name="set_SHOW_ADMINLINK" value="TRUE" <?php if ($SHOW_ADMINLINK) echo "checked"; ?>></td>
                    <td>Show Admin link on user page</td>
                </tr>
                <tr>
                    <td>START_PASSWORD_HIDDEN:</td>
                    <td><input type="checkbox" name="set_START_PASSWORD_HIDDEN" value="TRUE" <?php if ($START_PASSWORD_HIDDEN) echo "checked"; ?>></td>
                    <td>Hide entry of Start Password</td>
                </tr>
                <tr>
                    <td>IGNORE_DEMO_CSV:</td>
                    <td><input type="checkbox" name="set_IGNORE_DEMO_CSV" value="TRUE" <?php if ($IGNORE_DEMO_CSV) echo "checked"; ?>></td>
                    <td>Allows to ignore the presence of a 01_demo.csv file. Works is alphanumerically 01_demo.csv is the first!</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                </tr>             
                <!------------------------------------------------------------------
                  Other Settings
                ------------------------------------------------------------------->
                <tr>
                    <th colspan="3">Other Settings</th>
                </tr>
                <tr>
                    <td>ORGANIZATION:</td>
                    <td><input type="text" name="set_ORGANIZATION" size="40" value="<?php echo $ORGANIZATION; ?>"></td>
                    <td>Define your organization name. Note: unused with PUBLIC IQdesktop version. Used for display and license key in controlled version.</td>
                </tr>
                <tr>
                    <td>LICENSEKEY:</td>
                    <td><input type="text" name="set_LICENSEKEY" size="40" value="<?php echo $LICENSEKEY; ?>"></td>
                    <td>Provide the IQdesktop license key for your organization. Note: THIS IS NOT NEEDED FOR THE PUBLIC VERSION!</td>
                </tr>
                <!------------------------------------------------------------------
                  Container Settings
                ------------------------------------------------------------------->
                <tr>
                    <th colspan="3">Container Settings</th>
                </tr>
                <tr>
                    <td>MAX_CORES:</td>
                    <td><input type="text" name="set_MAX_CORES" size="10" value="<?php echo $MAX_CORES; ?>"></td>
                    <td>[N] Set the maximum number of cores a user should be able to select</td>
                </tr>
                <tr>
                    <td>MAX_MEM:</td>
                    <td><input type="text" name="set_MAX_MEM" size="10" value="<?php echo $MAX_MEM; ?>"></td>
                    <td>[GB] Set the maximum amount of memory a user should be able to request (8GB minimum)</td>
                </tr>
                <tr>
                    <td>MAX_TIME_HOURS_DEMO:</td>
                    <td><input type="text" name="set_MAX_TIME_HOURS_DEMO" size="10" value="<?php echo $MAX_TIME_HOURS_DEMO; ?>"></td>
                    <td>[Hours] Set the maximum runtime of containers in demo mode (01_demo.csv). Containers will then stop automatically after that time. Cannot be disabled except by high values</td>
                </tr>
                <tr>
                    <td>PRIVILEGED:</td>
                    <td><input type="checkbox" name="set_PRIVILEGED" value="TRUE" <?php if ($PRIVILEGED=="TRUE") echo "checked"; ?>></td>
                    <td>If checked, containers are run in <a href="https://docs.docker.com/engine/reference/run/" target="new">privileged mode</a>. This allows mounting of external file systems (AWS S3, CIFS/SMB). If unchecked containers will run without privileged rights and external filesystems cannot be mounted (except: Docker volumes)</td>
                </tr>
                <tr>
                    <td>MOUNT_BASENAME:</td>
                    <td><input type="checkbox" name="set_MOUNT_BASENAME" value="TRUE" <?php if ($MOUNT_BASENAME=="TRUE") echo "checked"; ?>></td>
                    <td>If checked, external folders are mounted to /IQDESKTOP/MOUNT/"basename of file server folder". Otherwise, instead of the basename the full path on the file server is used</td>
                </tr>
                <tr>
                    <td>MAC_ADDRESS:</td>
                    <td><input type="text" name="set_MAC_ADDRESS" size="20" value="<?php echo $MAC_ADDRESS; ?>"></td>
                    <td>Definition of MAC address for all containers. Ensure you use a valid MAC address - otherwise the containers will not start! Default one is: "00:00:28:06:19:71"</td>
                </tr>
                <tr>
                    <td>TIMEZONE:</td>
                    <td><input type="text" name="set_TIMEZONE" size="20" value="<?php echo $TIMEZONE; ?>"></td>
                    <td>Define time zone (<a href="https://en.wikipedia.org/wiki/List_of_tz_database_time_zones" target="tz">see here</a>)</td>
                </tr>
                <tr>
                    <td>IQREPORT_TEMPLATE:</td>
                    <td><input type="text" name="set_IQREPORT_TEMPLATE" size="20" value="<?php echo $IQREPORT_TEMPLATE; ?>"></td>
                    <td>Define the IQReport templates to be installed (set to "default" in default case)</td>
                </tr>
                <tr>
                    <td>IQRTOOLS_COMPLIANCE:</td>
                    <td><input type="checkbox" name="set_IQRTOOLS_COMPLIANCE" value="TRUE" <?php if ($IQRTOOLS_COMPLIANCE=="TRUE") echo "checked"; ?>></td>
                    <td>If checked, all containers use compliance mode in IQR Tools, otherwise FALSE</td>
                </tr>
                <tr>
                    <td>NONMEM_LICENSE_KEY:</td>
                    <td><input type="text" name="set_NONMEM_LICENSE_KEY" size="30" value="<?php echo $NONMEM_LICENSE_KEY; ?>"></td>
                    <td>Sets the NONMEM license key for all containers</td>
                </tr>
                <tr>
                    <td>MONOLIX_LICENSE_KEY:</td>
                    <td><textarea form="form1" name="set_MONOLIX_LICENSE_KEY" rows="5" cols="30" wrap="soft"><?php echo $MONOLIX_LICENSE_KEY; ?></textarea></td>
                    <td>Sets the MONOLIX license key for all containers. Copy the true license file. \n will be exchanged to ::: and " to &&&</td>
                </tr>
                <tr>
                    <td>ALLOW_SUDO:</td>
                    <td><input type="checkbox" name="set_ALLOW_SUDO" value="TRUE" <?php if ($ALLOW_SUDO=="TRUE") echo "checked"; ?>></td>
                    <td>If checked then container users are allowed sudo rights</td>
                </tr>
                <tr>
                    <td>SSH_SERVER:</td>
                    <td><input type="checkbox" name="set_SSH_SERVER" value="TRUE" <?php if ($SSH_SERVER=="TRUE") echo "checked"; ?>></td>
                    <td>If checked then ssh access to container is allowed</td>
                </tr>
                <tr>
                    <td>ALLOW_SHINY_SERVER:</td>
                    <td><input type="checkbox" name="set_ALLOW_SHINY_SERVER" value="TRUE" <?php if ($ALLOW_SHINY_SERVER=="TRUE") echo "checked"; ?>></td>
                    <td>If checked then container users can start a shiny server</td>
                </tr>
                <tr>
                    <td>THEME:</td>
                    <td>
                        <select name="set_THEME">
                        <option value="dark" <?php if ($THEME == "dark") echo "selected"; ?>>dark</option>
                        <option value="light" <?php if ($THEME == "light") echo "selected"; ?>>light</option>
                        </select>
                    </td>
                    <td>Selects the default theme (user can choose on user page)</td>
                </tr>
                <tr>
                    <td>SHM_SIZE_GB:</td>
                    <td><input type="text" name="set_SHM_SIZE_GB" size="10" value="<?php echo $SHM_SIZE_GB; ?>"></td>
                    <td>Sets the shared memory size of a container (2 is good)</td>
                </tr>
                <tr>
                    <td>NR_CORES:</td>
                    <td><input type="text" name="set_NR_CORES" size="10" value="<?php echo $NR_CORES; ?>"></td>
                    <td>Sets the default number of cores for a container</td>
                </tr>
                <tr>
                    <td>MEMORY_GB:</td>
                    <td><input type="text" name="set_MEMORY_GB" size="10" value="<?php echo $MEMORY_GB; ?>"></td>
                    <td>Sets the default memory [GB] of a container</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                </tr>
                <!------------------------------------------------------------------
                  CONTROL TABLE 
                ------------------------------------------------------------------->
                <tr>
                    <th colspan="3">Control Table</th>
                </tr>
                <tr>
                    <td>NAME_SHOW:</td>
                    <td><input type="checkbox" name="set_NAME_SHOW" value="TRUE" <?php if ($NAME_SHOW) echo "checked"; ?>></td>
                    <td>Show Name column</td>
                </tr>
                <tr>
                    <td>SAFETY_CHECK_SHOW:</td>
                    <td><input type="checkbox" name="set_SAFETY_CHECK_SHOW" value="TRUE" <?php if ($SAFETY_CHECK_SHOW) echo "checked"; ?>></td>
                    <td>Show Start Password column</td>
                </tr>
                <tr>
                    <td>USER_SHOW:</td>
                    <td><input type="checkbox" name="set_USER_SHOW" value="TRUE" <?php if ($USER_SHOW) echo "checked"; ?>></td>
                    <td>Show User column</td>
                </tr>
                <tr>
                    <td>PASSWORD_SHOW:</td>
                    <td><input type="checkbox" name="set_PASSWORD_SHOW" value="TRUE" <?php if ($PASSWORD_SHOW) echo "checked"; ?>></td>
                    <td>Show Password column</td>
                </tr>
                <tr>
                    <td>IMAGE_SHOW:</td>
                    <td><input type="checkbox" name="set_IMAGE_SHOW" value="TRUE" <?php if ($IMAGE_SHOW) echo "checked"; ?>></td>
                    <td>Show IQdesktop Image version column</td>
                </tr>
                <tr>
                    <td>VOLUME_MAP_SHOW:</td>
                    <td><input type="checkbox" name="set_VOLUME_MAP_SHOW" value="TRUE" <?php if ($VOLUME_MAP_SHOW) echo "checked"; ?>></td>
                    <td>Show Mapped Volume column</td>
                </tr>
                <tr>
                    <td>VNCPORT_SHOW:</td>
                    <td><input type="checkbox" name="set_VNCPORT_SHOW" value="TRUE" <?php if ($VNCPORT_SHOW) echo "checked"; ?>></td>
                    <td>Show VNC Port column</td>
                </tr>
                <tr>
                    <td>SSHPORT_SHOW:</td>
                    <td><input type="checkbox" name="set_SSHPORT_SHOW" value="TRUE" <?php if ($SSHPORT_SHOW) echo "checked"; ?>></td>
                    <td>Show SSH Port column</td>
                </tr>
                <tr>
                    <td>SHINY_SERVER_PORT_SHOW:</td>
                    <td><input type="checkbox" name="set_SHINY_SERVER_PORT_SHOW" value="TRUE" <?php if ($SHINY_SERVER_PORT_SHOW) echo "checked"; ?>></td>
                    <td>Show Shiny Server Port column</td>
                </tr>
                <tr>
                    <td>ALLOW_SUDO_SHOW:</td>
                    <td><input type="checkbox" name="set_ALLOW_SUDO_SHOW" value="TRUE" <?php if ($ALLOW_SUDO_SHOW) echo "checked"; ?>></td>
                    <td>Show Sudo Rights column</td>
                </tr>
                <tr>
                    <td>SSH_SERVER_SHOW:</td>
                    <td><input type="checkbox" name="set_SSH_SERVER_SHOW" value="TRUE" <?php if ($SSH_SERVER_SHOW) echo "checked"; ?>></td>
                    <td>Show SSH Server avilability column</td>
                </tr>
                <tr>
                    <td>ALLOW_SHINY_SERVER_SHOW:</td>
                    <td><input type="checkbox" name="set_ALLOW_SHINY_SERVER_SHOW" value="TRUE" <?php if ($ALLOW_SHINY_SERVER_SHOW) echo "checked"; ?>></td>
                    <td>Show Shiny Server availability column</td>
                </tr>
                <tr>
                    <td>USER_ID_SHOW:</td>
                    <td><input type="checkbox" name="set_USER_ID_SHOW" value="TRUE" <?php if ($USER_ID_SHOW) echo "checked"; ?>></td>
                    <td>Show User ID column</td>
                </tr>
                <tr>
                    <td>THEME_SHOW:</td>
                    <td><input type="checkbox" name="set_THEME_SHOW" value="TRUE" <?php if ($THEME_SHOW) echo "checked"; ?>></td>
                    <td>Show Theme column</td>
                </tr>
                <tr>
                    <td>MAC_SHOW:</td>
                    <td><input type="checkbox" name="set_MAC_SHOW" value="TRUE" <?php if ($MAC_SHOW) echo "checked"; ?>></td>
                    <td>Show MAC Address column</td>
                </tr>
                <tr>
                    <td>SHM_SIZE_GB_SHOW:</td>
                    <td><input type="checkbox" name="set_SHM_SIZE_GB_SHOW" value="TRUE" <?php if ($SHM_SIZE_GB_SHOW) echo "checked"; ?>></td>
                    <td>Show Swap Space column</td>
                </tr>
                <tr>
                    <td>NR_CORES_SHOW:</td>
                    <td><input type="checkbox" name="set_NR_CORES_SHOW" value="TRUE" <?php if ($NR_CORES_SHOW) echo "checked"; ?>></td>
                    <td>Show Number of Cores column</td>
                </tr>
                <tr>
                    <td>MEMORY_GB_SHOW:</td>
                    <td><input type="checkbox" name="set_MEMORY_GB_SHOW" value="TRUE" <?php if ($MEMORY_GB_SHOW) echo "checked"; ?>></td>
                    <td>Show Memory column</td>
                </tr>
                <tr>
                    <td>TIMEZONE_SHOW:</td>
                    <td><input type="checkbox" name="set_TIMEZONE_SHOW" value="TRUE" <?php if ($TIMEZONE_SHOW) echo "checked"; ?>></td>
                    <td>Show Timezone column</td>
                </tr>
                <tr>
                    <td>IQRTOOLS_COMPLIANCE_SHOW:</td>
                    <td><input type="checkbox" name="set_IQRTOOLS_COMPLIANCE_SHOW" value="TRUE" <?php if ($IQRTOOLS_COMPLIANCE_SHOW) echo "checked"; ?>></td>
                    <td>Show IQR Tools Compliance column</td>
                </tr>
                <tr>
                    <td>IQREPORT_TEMPLATE_SHOW:</td>
                    <td><input type="checkbox" name="set_IQREPORT_TEMPLATE_SHOW" value="TRUE" <?php if ($IQREPORT_TEMPLATE_SHOW) echo "checked"; ?>></td>
                    <td>Show IQReport Template selection column</td>
                </tr>
                <tr>
                    <td>MOUNT_SHOW:</td>
                    <td><input type="checkbox" name="set_MOUNT_SHOW" value="TRUE" <?php if ($MOUNT_SHOW) echo "checked"; ?>></td>
                    <td>Show server mount information</td>
                </tr>
                <tr>
                    <td colspan="3"><button type="submit" form="form1" value="Submit" class="buttonSelectCSV">SAVE</button></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                </tr>
                <!------------------------------------------------------------------
                  INFOTEXT
                ------------------------------------------------------------------->
                <tr>
                    <th colspan="3">Infotext on User Page (empty will revert to default)</th>
                </tr>
                <tr>
                    <td colspan="3">
                        <textarea form="form1" name="set_INFOTEXT" rows="30" cols="150" wrap="soft"><?php echo $INFOTEXT; ?></textarea>
                </tr>
            </table>
        </form>
    <?php
    }
    ?>


</body>

</html>
