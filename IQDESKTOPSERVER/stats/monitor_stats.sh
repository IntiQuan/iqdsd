#! /bin/bash
# Generation of a log file for monitoring the use of the computational server
# Define interval time in seconds - lets use 15 minutes 
INTERVAL=900 # 15*60 = 900 seconds
# Get number of cores to adjust the load to a healthy max of 100%
NRCORES=$(lscpu | grep "CPU(s):" | awk '{print $2}')
# Header for CSV information
printf "Date,Memory,Disk,Load_1min,Load_5min,Load_15min\n"
# Run for ever
while [ 1 ]; do
    # Get current date in default format
    DATE=$(date +"%Y-%m-%dT%H:%M")
    # Read memory and disk utilization
    MEMORY=$(free -m | grep Mem | awk 'NR==1{printf "%.2f%%", $3*100/$2 }')
    DISK=$(df -h | awk '$NF=="/"{printf "%s", $5}')
    # Read the CPU load as averages over 1, 5, and 15 minutes and convert to %
    LOAD_1MIN=$(top -bn1 | grep load | awk -v x="$NRCORES" '{printf "%.2f%%", $(NF-2)/x*100}')
    LOAD_5MIN=$(top -bn1 | grep load | awk -v x="$NRCORES" '{printf "%.2f%%", $(NF-1)/x*100}')
    LOAD_15MIN=$(top -bn1 | grep load | awk -v x="$NRCORES" '{printf "%.2f%%\n", $(NF)/x*100}')
    # Write out the information in CSV manner
    echo "$DATE,$MEMORY,$DISK,$LOAD_1MIN,$LOAD_5MIN,$LOAD_15MIN$CPU"
    # Sleep for defined period (seconds)
    sleep $INTERVAL
done

