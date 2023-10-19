#!/bin/bash
# ------------------------------------------------------------------------------------------------
# Starts an IDesktop container for defined input arguments 
# ------------------------------------------------------------------------------------------------

MATLAB_LICENSE_FILE=

# ------------------------------------------------------------------------
# Get input arguments
# ------------------------------------------------------------------------

USER=$1
PASSWORD=$2
IMAGE=$3
VOLUME_MAP=$4
VNCPORT=$5
SSHPORT=$6
SHINY_SERVER_PORT=$7
ALLOW_SUDO=$8
SSH_SERVER=$9
ALLOW_SHINY_SERVER=${10}
USER_ID=${11}
THEME=${12}
MAC=${13}
SHM_SIZE_GB=${14}
NR_CORES=${15}
MEMORY_GB=${16}
TIMEZONE=${17}
IQRTOOLS_COMPLIANCE=${18}
IQREPORT_TEMPLATE=${19}
IQREPORT_LICENSE_KEY=${20}
NONMEM_LICENSE_KEY=${21}
MONOLIX_LICENSE_KEY=${22}
VNC_PRIVATE_KEY=${23}
VNC_CERTIFICATE=${24}
AWS_ACCESS_KEY_ID=${25}
AWS_SECRET_ACCESS_KEY=${26}
PRIVILEGED=${27}
MOUNTBASENAME=${28}

MOUNT_1_LABEL=${29}
MOUNT_1_SERVER_IP=${30}
MOUNT_1_SERVER_FOLDER=${31} 
MOUNT_1_OPTIONS=${32}

MOUNT_2_LABEL=${33} 
MOUNT_2_SERVER_IP=${34} 
MOUNT_2_SERVER_FOLDER=${35} 
MOUNT_2_OPTIONS=${36} 

MOUNT_3_LABEL=${37}  
MOUNT_3_SERVER_IP=${38}  
MOUNT_3_SERVER_FOLDER=${39}  
MOUNT_3_OPTIONS=${40} 

MOUNT_4_LABEL=${41} 
MOUNT_4_SERVER_IP=${42}  
MOUNT_4_SERVER_FOLDER=${43}  
MOUNT_4_OPTIONS=${44} 

MOUNT_5_LABEL=${45}  
MOUNT_5_SERVER_IP=${46}  
MOUNT_5_SERVER_FOLDER=${47}  
MOUNT_5_OPTIONS=${48} 

ORGANIZATION=${49} 
LICENSEKEY=${50} 

# ------------------------------------------------------------------------
# Fix MOUNT_n_OPTIONS Replace ::: by ,
# ------------------------------------------------------------------------

MOUNT_1_OPTIONS="$(sed s#:::#,#g <<<$MOUNT_1_OPTIONS)"
MOUNT_2_OPTIONS="$(sed s#:::#,#g <<<$MOUNT_2_OPTIONS)"
MOUNT_3_OPTIONS="$(sed s#:::#,#g <<<$MOUNT_3_OPTIONS)"
MOUNT_4_OPTIONS="$(sed s#:::#,#g <<<$MOUNT_4_OPTIONS)"
MOUNT_5_OPTIONS="$(sed s#:::#,#g <<<$MOUNT_5_OPTIONS)"

# ------------------------------------------------------------------------
# Fix MOUNT if undefined label
# ------------------------------------------------------------------------

if [[ $MOUNT_1_LABEL == "undefined" ]]; then 
  MOUNT_1_LABEL=
  MOUNT_1_SERVER_IP=
  MOUNT_1_SERVER_FOLDER=
  MOUNT_1_OPTIONS=
fi

if [[ $MOUNT_2_LABEL == "undefined" ]]; then 
  MOUNT_2_LABEL=
  MOUNT_2_SERVER_IP=
  MOUNT_2_SERVER_FOLDER=
  MOUNT_2_OPTIONS=
fi

if [[ $MOUNT_3_LABEL == "undefined" ]]; then 
  MOUNT_3_LABEL=
  MOUNT_3_SERVER_IP=
  MOUNT_3_SERVER_FOLDER=
  MOUNT_3_OPTIONS=
fi

if [[ $MOUNT_4_LABEL == "undefined" ]]; then 
  MOUNT_4_LABEL=
  MOUNT_4_SERVER_IP=
  MOUNT_4_SERVER_FOLDER=
  MOUNT_4_OPTIONS=
fi

if [[ $MOUNT_5_LABEL == "undefined" ]]; then 
  MOUNT_5_LABEL=
  MOUNT_5_SERVER_IP=
  MOUNT_5_SERVER_FOLDER=
  MOUNT_5_OPTIONS=
fi


# ------------------------------------------------------------------------
# Handle upper to lower case
# ------------------------------------------------------------------------

ALLOW_SUDO=${ALLOW_SUDO,,}
SSH_SERVER=${SSH_SERVER,,}
IQRTOOLS_COMPLIANCE=${IQRTOOLS_COMPLIANCE,,}
ALLOW_SHINY_SERVER=${ALLOW_SHINY_SERVER,,}
PRIVILEGED=${PRIVILEGED,,}
MOUNTBASENAME=${MOUNTBASENAME,,}

# ------------------------------------------------------------------------
# Copy template docker-compose.yml file 
# in user dependent folder
# ------------------------------------------------------------------------

mkdir -p yml_custom/$USER
CUSTOM_YML_FILE=yml_custom/$USER/docker-compose.yml 
cp docker-compose_template.yml $CUSTOM_YML_FILE

# ------------------------------------------------------------------------
# Customize docker-compose file
# Handle all with exception of VOLUME_MAP!
# ------------------------------------------------------------------------

sed -i "s#%ORGANIZATION%#$ORGANIZATION#g" $CUSTOM_YML_FILE
sed -i "s#%LICENSEKEY%#$LICENSEKEY#g" $CUSTOM_YML_FILE

sed -i "s#%PRIVILEGED%#$PRIVILEGED#g" $CUSTOM_YML_FILE
sed -i "s#%MOUNT_BASENAME%#$MOUNTBASENAME#g" $CUSTOM_YML_FILE

sed -i "s#%USER%#$USER#g" $CUSTOM_YML_FILE
sed -i "s#%IMAGE%#$IMAGE#g" $CUSTOM_YML_FILE
sed -i "s#%VNCPORT%#$VNCPORT#g" $CUSTOM_YML_FILE
sed -i "s#%SSHPORT%#$SSHPORT#g" $CUSTOM_YML_FILE
sed -i "s#%SHINY_SERVER_PORT%#$SHINY_SERVER_PORT#g" $CUSTOM_YML_FILE  

sed -i "s#%HOST_ID%#$HOSTNAME#g" $CUSTOM_YML_FILE  

sed -i "s#%PASSWORD%#$PASSWORD#g" $CUSTOM_YML_FILE
sed -i "s#%USER_ID%#$USER_ID#g" $CUSTOM_YML_FILE
sed -i "s#%THEME%#$THEME#g" $CUSTOM_YML_FILE
sed -i "s#%ALLOW_SUDO%#$ALLOW_SUDO#g" $CUSTOM_YML_FILE

sed -i "s#%SHM_SIZE_GB%#$SHM_SIZE_GB#g" $CUSTOM_YML_FILE
sed -i "s#%NR_CORES%#$NR_CORES#g" $CUSTOM_YML_FILE
sed -i "s#%MEMORY_GB%#$MEMORY_GB#g" $CUSTOM_YML_FILE

sed -i "s#%ALLOW_SHINY_SERVER%#$ALLOW_SHINY_SERVER#g" $CUSTOM_YML_FILE
sed -i "s#%SSH_SERVER%#$SSH_SERVER#g" $CUSTOM_YML_FILE
sed -i "s#%TIMEZONE%#$TIMEZONE#g" $CUSTOM_YML_FILE
sed -i "s#%VNC_RESOLUTION%#$VNC_RESOLUTION#g" $CUSTOM_YML_FILE

sed -i "s#%IQREPORT_LICENSE_KEY%#$IQREPORT_LICENSE_KEY#g" $CUSTOM_YML_FILE

sed -i "s#%IQRTOOLS_COMPLIANCE%#$IQRTOOLS_COMPLIANCE#g" $CUSTOM_YML_FILE
sed -i "s#%IQREPORT_TEMPLATE%#$IQREPORT_TEMPLATE#g" $CUSTOM_YML_FILE

sed -i "s#%NONMEM_LICENSE_KEY%#$NONMEM_LICENSE_KEY#g" $CUSTOM_YML_FILE
sed -i "s#%MONOLIX_LICENSE_KEY%#$MONOLIX_LICENSE_KEY#g" $CUSTOM_YML_FILE

sed -i "s#%VNC_PRIVATE_KEY%#$VNC_PRIVATE_KEY#g" $CUSTOM_YML_FILE
sed -i "s#%VNC_CERTIFICATE%#$VNC_CERTIFICATE#g" $CUSTOM_YML_FILE

sed -i "s#%AWS_ACCESS_KEY_ID%#$AWS_ACCESS_KEY_ID#g" $CUSTOM_YML_FILE
sed -i "s#%AWS_SECRET_ACCESS_KEY%#$AWS_SECRET_ACCESS_KEY#g" $CUSTOM_YML_FILE

sed -i "s#%MATLAB_LICENSE_FILE%#$MATLAB_LICENSE_FILE#g" $CUSTOM_YML_FILE

sed -i "s#%MOUNT_1_LABEL%#$MOUNT_1_LABEL#g" $CUSTOM_YML_FILE
sed -i "s#%MOUNT_1_SERVER_IP%#$MOUNT_1_SERVER_IP#g" $CUSTOM_YML_FILE
sed -i "s#%MOUNT_1_SERVER_FOLDER%#$MOUNT_1_SERVER_FOLDER#g" $CUSTOM_YML_FILE
sed -i "s#%MOUNT_1_OPTIONS%#$MOUNT_1_OPTIONS#g" $CUSTOM_YML_FILE

sed -i "s#%MOUNT_2_LABEL%#$MOUNT_2_LABEL#g" $CUSTOM_YML_FILE
sed -i "s#%MOUNT_2_SERVER_IP%#$MOUNT_2_SERVER_IP#g" $CUSTOM_YML_FILE
sed -i "s#%MOUNT_2_SERVER_FOLDER%#$MOUNT_2_SERVER_FOLDER#g" $CUSTOM_YML_FILE
sed -i "s#%MOUNT_2_OPTIONS%#$MOUNT_2_OPTIONS#g" $CUSTOM_YML_FILE

sed -i "s#%MOUNT_3_LABEL%#$MOUNT_3_LABEL#g" $CUSTOM_YML_FILE
sed -i "s#%MOUNT_3_SERVER_IP%#$MOUNT_3_SERVER_IP#g" $CUSTOM_YML_FILE
sed -i "s#%MOUNT_3_SERVER_FOLDER%#$MOUNT_3_SERVER_FOLDER#g" $CUSTOM_YML_FILE
sed -i "s#%MOUNT_3_OPTIONS%#$MOUNT_3_OPTIONS#g" $CUSTOM_YML_FILE

sed -i "s#%MOUNT_4_LABEL%#$MOUNT_4_LABEL#g" $CUSTOM_YML_FILE
sed -i "s#%MOUNT_4_SERVER_IP%#$MOUNT_4_SERVER_IP#g" $CUSTOM_YML_FILE
sed -i "s#%MOUNT_4_SERVER_FOLDER%#$MOUNT_4_SERVER_FOLDER#g" $CUSTOM_YML_FILE
sed -i "s#%MOUNT_4_OPTIONS%#$MOUNT_4_OPTIONS#g" $CUSTOM_YML_FILE

sed -i "s#%MOUNT_5_LABEL%#$MOUNT_5_LABEL#g" $CUSTOM_YML_FILE
sed -i "s#%MOUNT_5_SERVER_IP%#$MOUNT_5_SERVER_IP#g" $CUSTOM_YML_FILE
sed -i "s#%MOUNT_5_SERVER_FOLDER%#$MOUNT_5_SERVER_FOLDER#g" $CUSTOM_YML_FILE
sed -i "s#%MOUNT_5_OPTIONS%#$MOUNT_5_OPTIONS#g" $CUSTOM_YML_FILE


# ------------------------------------------------------------------------
# Add MAC address if desired
# ------------------------------------------------------------------------

if [ -z $MAC ]; then
  echo "Do nothing"
else
  echo -e "\n    mac_address: $MAC" >> $CUSTOM_YML_FILE
fi

# ------------------------------------------------------------------------
# Add single share if defined ($VOLUME_MAP empty => no share)
# ------------------------------------------------------------------------

if [ -z $VOLUME_MAP ]; then
  echo "Do nothing"
else
  # Add the sharing
  echo -e "\n    volumes:\n      - $VOLUME_MAP:/IQDESKTOP/SHARE/" >> $CUSTOM_YML_FILE
fi

# ------------------------------------------------------------------------
# Start container
# ------------------------------------------------------------------------

echo "==> Starting $IMAGE docker container for $USER ..."
docker-compose -f $CUSTOM_YML_FILE up &
echo "    Running ..."
