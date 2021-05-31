#!/bin/bash
# ------------------------------------------------------------------------------------------------
#  test start all|username config.csv
#  test start all|username config.csv image ncores memorygb theme
#  test stop all|username 
#
# VNC certificates can be controlled by:
# 1) Setting in CSV files => control based on individual container
# 2) Presence of files iqdesktop_VNC_key.pem and iqdesktop_VNC_cert.pem in run folder.
#    In this case settings in CSV file are ignored.
# ------------------------------------------------------------------------------------------------

# ------------------------------------------------------------------------
# Input argument checks
# ------------------------------------------------------------------------

# Number input arguments
NARGS=$#

# Require correct number of input arguments
if [[ $NARGS -lt 2 ]] || [[ $NARGS -gt 7 ]] || [[ $NARGS == 4 ]] || [[ $NARGS == 5 ]] || [[ $NARGS == 6 ]]; then 
    echo "Usage:"
    echo "        iqdesktop start all|username config.csv"
    echo "        iqdesktop start all|username config.csv image ncores memorygb theme"
    echo "        iqdesktop stop all|username"
    exit 0
fi

# Get first ones
COMMAND=$1
USERS=$2

# Check right syntax
if [[ $COMMAND == "stop" ]];  then
    if [[ $NARGS != 2 ]]; then 
        echo "stop command requires 2 input arguments"
        exit 0
    fi
fi

if [[ $COMMAND == "start" ]]; then
    if [[ $NARGS < 3 ]] || [[ $NARGS -gt 7 ]] || [[ $NARGS == 4 ]] || [[ $NARGS == 5 ]] || [[ $NARGS == 6 ]]; then 
        echo "start command requires 3 or 7 input arguments"
        exit 0
    fi
fi

if [[ $COMMAND != "start" ]] && [[ $COMMAND != "stop" ]]; then 
    echo "wrong action command"
    exit 0
fi

if [[ $COMMAND == "start" ]]; then 
    if [[ ! -f $3 ]]; then 
        echo "$3 file not found"; 
        exit 99;
    fi
fi 

# ------------------------------------------------------------------------
# Assign input values
# ------------------------------------------------------------------------

COMMAND=$COMMAND
USERS=$USERS
CSVFILE=$3
ARGIMAGE=$4
ARGNCORES=$5
ARGMEM=$6
ARGTHEME=$7

# ------------------------------------------------------------------------
# Ensure gen_runs.sh is executable
# ------------------------------------------------------------------------

chmod +x gen_runs.sh

# ------------------------------------------------------------------------
# Handle "start" of iqdesktop
# ------------------------------------------------------------------------

# Basically, read the CSV file and either start all users or just the one 
# that is defined as $USERS
if [[ $COMMAND == "start" ]]; then 
    OLDIFS=$IFS
    IFS=','
    while read NAME USER SAFETY_CHECK PASSWORD IMAGE VOLUME_MAP VNCPORT SSHPORT SHINY_SERVER_PORT JENKINSPORT ALLOW_SUDO SSH_SERVER ALLOW_SHINY_SERVER USER_ID THEME MAC SHM_SIZE_GB NR_CORES MEMORY_GB TIMEZONE IQRTOOLS_COMPLIANCE IQREPORT_TEMPLATE IQREPORT_LICENSE_KEY NONMEM_LICENSE_KEY MONOLIX_LICENSE_KEY VNC_PRIVATE_KEY VNC_CERTIFICATE AWS_ACCESS_KEY_ID AWS_SECRET_ACCESS_KEY
    do
        # Do not handle header row ("USER" in "USER" column)
        if [[ $USER == "USER" ]]; then 
            continue
        else

            # Handle optional IMAGE, NCORE, MEMORY arguments by replacing what is in the CSV file
            if [[ -n $ARGIMAGE ]]; then
                IMAGE=$ARGIMAGE
                NR_CORES=$ARGNCORES
                MEMORY_GB=$ARGMEM
                THEME=$ARGTHEME
            fi

            # -----------------------------------------------------
            # Modify Monolix Server License key file content 
            # Excel duplicates " and adds " around
            # \n replaced by ::: in CSV file
            MONOLIX_LICENSE_KEY="$(sed s#\"\"#\"#g <<<$MONOLIX_LICENSE_KEY)"
            MONOLIX_LICENSE_KEY="$(sed s#\"LICENSE#LICENSE#g <<<$MONOLIX_LICENSE_KEY)"
            MONOLIX_LICENSE_KEY="$(sed s#\"\"##g <<<$MONOLIX_LICENSE_KEY)"
            MONOLIX_LICENSE_KEY="$(sed s#:::#\\\\\\\\n#g <<<$MONOLIX_LICENSE_KEY)"
            # -----------------------------------------------------

            # -----------------------------------------------------
            # Handle VNC Option 2 => based on PEM files 
            if [ -f "../admin/iqdesktop_VNC_key.pem" ]; then
                if [ -f "../iqdesktop_VNC_cert.pem" ]; then
                    # Read files into variables
                    # Replace "\n" with ":"
                    VNCKEY=$(tr '\n' ':' < ../admin/iqdesktop_VNC_key.pem)
                    VNCCERT=$(tr '\n' ':' < ../iqdesktop_VNC_cert.pem)
                    # Replace "&" with ":::"
                    VNC_PRIVATE_KEY=$(sed s#:#:::#g <<<$VNCKEY)
                    VNC_CERTIFICATE=$(sed s#:#:::#g <<<$VNCCERT)
                fi
            fi
            # -----------------------------------------------------
            
            # -----------------------------------------------------
            # Modify VNC_PRIVATE_KEY and VNC_CERTIFICATE file content 
            # \n replaced by ::: in CSV file
            VNC_PRIVATE_KEY="$(sed s#:::#\\\\\\\\n#g <<<$VNC_PRIVATE_KEY)"
            VNC_CERTIFICATE="$(sed s#:::#\\\\\\\\n#g <<<$VNC_CERTIFICATE)"
            # -----------------------------------------------------

            # -----------------------------------------------------
            # Modify IQRTOOLS_LICENSE_KEY file content 
            # \n replaced by ::: in CSV file
            IQRTOOLS_LICENSE_KEY="$(sed s#:::#\\\\\\\\n#g <<<$IQRTOOLS_LICENSE_KEY)"
            # -----------------------------------------------------

            if [[ $USERS == "all" ]]; then 
                # Start for everyone
                echo "Handling setup for: $NAME"
                ./gen_runs.sh "$USER" "$PASSWORD" "$IMAGE" "$VOLUME_MAP" "$VNCPORT" "$SSHPORT" "$SHINY_SERVER_PORT" "$JENKINSPORT" "$ALLOW_SUDO" "$SSH_SERVER" "$ALLOW_SHINY_SERVER" "$USER_ID" "$THEME" "$MAC" "$SHM_SIZE_GB" "$NR_CORES" "$MEMORY_GB" "$TIMEZONE" "$IQRTOOLS_COMPLIANCE" "$IQREPORT_TEMPLATE" "$IQREPORT_LICENSE_KEY" "$NONMEM_LICENSE_KEY" "$MONOLIX_LICENSE_KEY" "$VNC_PRIVATE_KEY" "$VNC_CERTIFICATE" "$AWS_ACCESS_KEY_ID" "$AWS_SECRET_ACCESS_KEY"
            else
                if [[ $USERS == $USER ]]; then 
                    # Start only for selected user
                    echo "Handling setup for: $NAME"
                    ./gen_runs.sh "$USER" "$PASSWORD" "$IMAGE" "$VOLUME_MAP" "$VNCPORT" "$SSHPORT" "$SHINY_SERVER_PORT" "$JENKINSPORT" "$ALLOW_SUDO" "$SSH_SERVER" "$ALLOW_SHINY_SERVER" "$USER_ID" "$THEME" "$MAC" "$SHM_SIZE_GB" "$NR_CORES" "$MEMORY_GB" "$TIMEZONE" "$IQRTOOLS_COMPLIANCE" "$IQREPORT_TEMPLATE" "$IQREPORT_LICENSE_KEY" "$NONMEM_LICENSE_KEY" "$MONOLIX_LICENSE_KEY" "$VNC_PRIVATE_KEY" "$VNC_CERTIFICATE" "$AWS_ACCESS_KEY_ID" "$AWS_SECRET_ACCESS_KEY"
                fi
            fi
        fi 
    done < $CSVFILE
    IFS=$OLDIFS
    exit 0
fi

# ------------------------------------------------------------------------
# Handle "stop" of iqdesktop
# ------------------------------------------------------------------------

if [[ $COMMAND = "stop" ]]; then 

    if [[ $USERS = "all" ]]; then 
        # Stop and clean all containers etc
        echo "==> Stopping all running docker containers"
        docker container stop $(docker container ls -aq)

        # Remove all containers
        echo -e "\n==> Removing all running docker containers"
        docker container rm $(docker container ls -aq)

        # Remove all custom networks
        echo -e "\n==> Removing all custom networks"
        docker network prune -f

        # Remove the custom yml folder
        echo -e "\n==> Removing custom yml files"
        rm -r -f yml_custom
    else 
        # Get running containers for provided user
        X=$(docker container ls -q -f name="\\_$USERS\\_")
        if [[ -z $X ]]; then 
            echo "IQdesktop for $USERS not running"
            exit 0
        fi
        
        # Stop and clean all containers etc
        echo "==> Stopping $USERS's IQdesktop"
        docker container stop $X

        # Remove all running containers
        echo "==> Removing $USERS's IQdesktop"
        docker container rm $X

        # Remove all custom networks
        echo -e "\n==> Removing $USERS's custom networks"
        docker network prune -f

        # Remove the custom yml folder
        echo -e "\n==> Removing $USERS's custom yml files"
        rm -r -f yml_custom/$USERS
     fi
fi