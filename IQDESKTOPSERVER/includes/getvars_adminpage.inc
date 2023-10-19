<?php
// Admin page - Get passed GET variables
$do = $_POST["do"]; if (empty($do)) $do = "showsettings";
$action = $_POST["action"];

$C_vnccert = $_POST["C_vnccert"]; if (empty($C_vnccert)) $C_vnccert = "CH";
$ST_vnccert = $_POST["ST_vnccert"]; if (empty($ST_vnccert)) $ST_vnccert = "BS";
$L_vnccert = $_POST["L_vnccert"]; if (empty($L_vnccert)) $L_vnccert = "Basel";
$O_vnccert = $_POST["O_vnccert"]; if (empty($O_vnccert)) $O_vnccert = "IntiQuan GmbH";
$OU_vnccert = $_POST["OU_vnccert"]; if (empty($OU_vnccert)) $OU_vnccert = "IQdesktop";
$CN_vnccert = $_POST["CN_vnccert"]; if (empty($CN_vnccert)) $CN_vnccert = "iqdesktop.intiquan.com";
$BIT_vnccert = $_POST["BIT_vnccert"]; if (empty($BIT_vnccert)) $BIT_vnccert = 2048;
$days_vnccert = $_POST["days_vnccert"]; if (empty($days_vnccert)) $days_vnccert = 3333;

$set_SERVER_NAME = $_POST["set_SERVER_NAME"];
$set_SERVER_ADDRESS = $_POST["set_SERVER_ADDRESS"];
$set_SHOW_INFOTEXT = $_POST["set_SHOW_INFOTEXT"]; if ($set_SHOW_INFOTEXT != "TRUE") $set_SHOW_INFOTEXT = "FALSE";
$set_SHOW_ADMINLINK = $_POST["set_SHOW_ADMINLINK"]; if ($set_SHOW_ADMINLINK != "TRUE") $set_SHOW_ADMINLINK = "FALSE";
$set_START_PASSWORD_HIDDEN = $_POST["set_START_PASSWORD_HIDDEN"]; if ($set_START_PASSWORD_HIDDEN != "TRUE") $set_START_PASSWORD_HIDDEN = "FALSE";
$set_IGNORE_DEMO_CSV = $_POST["set_IGNORE_DEMO_CSV"]; if ($set_IGNORE_DEMO_CSV != "TRUE") $set_IGNORE_DEMO_CSV = "FALSE";

$set_ORGANIZATION = $_POST["set_ORGANIZATION"];
$set_LICENSEKEY = $_POST["set_LICENSEKEY"];

$set_MAX_CORES = $_POST["set_MAX_CORES"];
$set_MAX_MEM = $_POST["set_MAX_MEM"];
$set_MAX_TIME_HOURS_DEMO = $_POST["set_MAX_TIME_HOURS_DEMO"];
$set_PRIVILEGED = $_POST["set_PRIVILEGED"]; if ($set_PRIVILEGED != "TRUE") $set_PRIVILEGED = "FALSE";
$set_MOUNT_BASENAME = $_POST["set_MOUNT_BASENAME"]; if ($set_MOUNT_BASENAME != "TRUE") $set_MOUNT_BASENAME = "FALSE";
$set_MAC_ADDRESS = $_POST["set_MAC_ADDRESS"];
$set_TIMEZONE = $_POST["set_TIMEZONE"];
$set_IQREPORT_TEMPLATE = $_POST["set_IQREPORT_TEMPLATE"];
$set_IQRTOOLS_COMPLIANCE = $_POST["set_IQRTOOLS_COMPLIANCE"]; if ($set_IQRTOOLS_COMPLIANCE != "TRUE") $set_IQRTOOLS_COMPLIANCE = "FALSE";
$set_NONMEM_LICENSE_KEY = $_POST["set_NONMEM_LICENSE_KEY"];
$set_MONOLIX_LICENSE_KEY = $_POST["set_MONOLIX_LICENSE_KEY"];

$set_ALLOW_SUDO = $_POST["set_ALLOW_SUDO"]; if ($set_ALLOW_SUDO != "TRUE") $set_ALLOW_SUDO = "FALSE";
$set_SSH_SERVER = $_POST["set_SSH_SERVER"]; if ($set_SSH_SERVER != "TRUE") $set_SSH_SERVER = "FALSE";
$set_ALLOW_SHINY_SERVER = $_POST["set_ALLOW_SHINY_SERVER"]; if ($set_ALLOW_SHINY_SERVER != "TRUE") $set_ALLOW_SHINY_SERVER = "FALSE";
$set_THEME = $_POST["set_THEME"];
$set_SHM_SIZE_GB = $_POST["set_SHM_SIZE_GB"];
$set_NR_CORES = $_POST["set_NR_CORES"];
$set_MEMORY_GB = $_POST["set_MEMORY_GB"];

// Process the license keys
$set_NONMEM_LICENSE_KEY = trim($set_NONMEM_LICENSE_KEY); if ($set_NONMEM_LICENSE_KEY=="") $set_NONMEM_LICENSE_KEY = "Undefined";
$set_MONOLIX_LICENSE_KEY = trim($set_MONOLIX_LICENSE_KEY); if ($set_MONOLIX_LICENSE_KEY=="") $set_MONOLIX_LICENSE_KEY = "Undefined";
$set_MONOLIX_LICENSE_KEY = str_replace("\r","",$set_MONOLIX_LICENSE_KEY);
$set_MONOLIX_LICENSE_KEY = str_replace("\n",":::",$set_MONOLIX_LICENSE_KEY);
$set_MONOLIX_LICENSE_KEY = str_replace("\"","&&&",$set_MONOLIX_LICENSE_KEY);

$set_NAME_SHOW = $_POST["set_NAME_SHOW"]; if ($set_NAME_SHOW != "TRUE") $set_NAME_SHOW = "FALSE";
$set_SAFETY_CHECK_SHOW = $_POST["set_SAFETY_CHECK_SHOW"]; if ($set_SAFETY_CHECK_SHOW != "TRUE") $set_SAFETY_CHECK_SHOW = "FALSE";
$set_USER_SHOW = $_POST["set_USER_SHOW"]; if ($set_USER_SHOW != "TRUE") $set_USER_SHOW = "FALSE";
$set_PASSWORD_SHOW = $_POST["set_PASSWORD_SHOW"]; if ($set_PASSWORD_SHOW != "TRUE") $set_PASSWORD_SHOW = "FALSE";
$set_IMAGE_SHOW = $_POST["set_IMAGE_SHOW"]; if ($set_IMAGE_SHOW != "TRUE") $set_IMAGE_SHOW = "FALSE";
$set_VOLUME_MAP_SHOW = $_POST["set_VOLUME_MAP_SHOW"]; if ($set_VOLUME_MAP_SHOW != "TRUE") $set_VOLUME_MAP_SHOW = "FALSE";
$set_VNCPORT_SHOW = $_POST["set_VNCPORT_SHOW"]; if ($set_VNCPORT_SHOW != "TRUE") $set_VNCPORT_SHOW = "FALSE";
$set_SSHPORT_SHOW = $_POST["set_SSHPORT_SHOW"]; if ($set_SSHPORT_SHOW != "TRUE") $set_SSHPORT_SHOW = "FALSE";
$set_SHINY_SERVER_PORT_SHOW = $_POST["set_SHINY_SERVER_PORT_SHOW"]; if ($set_SHINY_SERVER_PORT_SHOW != "TRUE") $set_SHINY_SERVER_PORT_SHOW = "FALSE";
$set_ALLOW_SUDO_SHOW = $_POST["set_ALLOW_SUDO_SHOW"]; if ($set_ALLOW_SUDO_SHOW != "TRUE") $set_ALLOW_SUDO_SHOW = "FALSE";
$set_SSH_SERVER_SHOW = $_POST["set_SSH_SERVER_SHOW"]; if ($set_SSH_SERVER_SHOW != "TRUE") $set_SSH_SERVER_SHOW = "FALSE";
$set_ALLOW_SHINY_SERVER_SHOW = $_POST["set_ALLOW_SHINY_SERVER_SHOW"]; if ($set_ALLOW_SHINY_SERVER_SHOW != "TRUE") $set_ALLOW_SHINY_SERVER_SHOW = "FALSE";
$set_USER_ID_SHOW = $_POST["set_USER_ID_SHOW"]; if ($set_USER_ID_SHOW != "TRUE") $set_USER_ID_SHOW = "FALSE";
$set_THEME_SHOW = $_POST["set_THEME_SHOW"]; if ($set_THEME_SHOW != "TRUE") $set_THEME_SHOW = "FALSE";
$set_MAC_SHOW = $_POST["set_MAC_SHOW"]; if ($set_MAC_SHOW != "TRUE") $set_MAC_SHOW = "FALSE";
$set_SHM_SIZE_GB_SHOW = $_POST["set_SHM_SIZE_GB_SHOW"]; if ($set_SHM_SIZE_GB_SHOW != "TRUE") $set_SHM_SIZE_GB_SHOW = "FALSE";
$set_NR_CORES_SHOW = $_POST["set_NR_CORES_SHOW"]; if ($set_NR_CORES_SHOW != "TRUE") $set_NR_CORES_SHOW = "FALSE";
$set_MEMORY_GB_SHOW = $_POST["set_MEMORY_GB_SHOW"]; if ($set_MEMORY_GB_SHOW != "TRUE") $set_MEMORY_GB_SHOW = "FALSE";
$set_TIMEZONE_SHOW = $_POST["set_TIMEZONE_SHOW"]; if ($set_TIMEZONE_SHOW != "TRUE") $set_TIMEZONE_SHOW = "FALSE";
$set_IQRTOOLS_COMPLIANCE_SHOW = $_POST["set_IQRTOOLS_COMPLIANCE_SHOW"]; if ($set_IQRTOOLS_COMPLIANCE_SHOW != "TRUE") $set_IQRTOOLS_COMPLIANCE_SHOW = "FALSE";
$set_IQREPORT_TEMPLATE_SHOW = $_POST["set_IQREPORT_TEMPLATE_SHOW"]; if ($set_IQREPORT_TEMPLATE_SHOW != "TRUE") $set_IQREPORT_TEMPLATE_SHOW = "FALSE";
$set_MOUNT_SHOW = $_POST["set_MOUNT_SHOW"]; if ($set_MOUNT_SHOW != "TRUE") $set_MOUNT_SHOW = "FALSE";

// Settings for server folder mounting
$set_LIST_SERVER_IP = $_POST["set_LIST_SERVER_IP"];
$set_LIST_SERVER_IP = str_replace(" ","",$set_LIST_SERVER_IP); if ($set_LIST_SERVER_IP=="") $set_LIST_SERVER_IP = "Undefined";
$set_LIST_SERVER_OPTIONS = $_POST["set_LIST_SERVER_OPTIONS"];
$set_LIST_SERVER_OPTIONS = str_replace(" ","",$set_LIST_SERVER_OPTIONS); if ($set_LIST_SERVER_OPTIONS=="") $set_LIST_SERVER_OPTIONS = "vers=2.0;username=%USER%;noauto;user";
$set_LIST_SERVER_FOLDERS = $_POST["set_LIST_SERVER_FOLDERS"];
$set_LIST_SERVER_FOLDERS = str_replace(" ","",$set_LIST_SERVER_FOLDERS); if ($set_LIST_SERVER_FOLDERS=="") $set_LIST_SERVER_FOLDERS = "undefined,undefined,undefined,undefined,undefined";

// Info text 
$set_INFOTEXT = trim($_POST["set_INFOTEXT"]); if (empty($set_INFOTEXT)) $set_INFOTEXT = $INFOTEXTDEFAULT;
?>