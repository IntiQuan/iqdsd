library(IQRtools)
library(ggplot2)

d <- read.csv("stats.log")

d$Date <- as.POSIXct(d$Date,format = "%Y-%m-%dT%H:%M")
d$Memory <- as.numeric(gsub("%","",d$Memory)) # It is in percent!
d$Disk <- as.numeric(gsub("%","",d$Disk)) # It is in percent!
d$Load_1min <- as.numeric(gsub("%","",d$Load_1min)) # It is in percent!
d$Load_5min <- as.numeric(gsub("%","",d$Load_5min)) # It is in percent!
d$Load_15min <- as.numeric(gsub("%","",d$Load_15min)) # It is in percent!

# Memory
IQRggplot(data=d,aes(x=Date,y=Memory)) + 
  geom_line() + 
  coord_cartesian(ylim=c(0,100)) +
  ylab("Memory use (%)") + 
  xlab("Date and Time") + 
  ggtitle("Memory use")

# Disk
IQRggplot(data=d,aes(x=Date,y=Disk)) + 
  geom_line() +
  coord_cartesian(ylim=c(0,100)) +
  ylab("Disk use (%)") + 
  xlab("Date and Time") + 
  ggtitle("Disk use")

# CPU Load
dp <- tidyr::gather(d,NAME,VALUE,Load_1min,Load_5min,Load_15min)
dp$NAME <- factor(dp$NAME,levels=c("Load_1min","Load_5min","Load_15min"),labels=c("1 min", "5 min", "15 min"))
IQRggplot(data=dp,aes(x=Date,y=VALUE,color=NAME,group=NAME)) + 
  geom_line() + 
  scale_color_IQRtools("Avg CPU Load") + 
  theme(legend.position = "bottom") + 
  coord_cartesian(ylim=c(0,100)) +
  ylab("Average CPU Load (%)") + 
  xlab("Date and Time") + 
  ggtitle("Average CPU Loads",subtitle = "Load can be higher than 100%.\nValues adjusted for number of cores.")

