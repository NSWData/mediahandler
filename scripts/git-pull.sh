#!/bin/sh

#######################################################
#
# @auth : Adriaan Woerlee
# @date : 01 June 2017
#
# automatically pull from GIT
#
#######################################################


# Set where we want to pull from master to working
WORK_DIR=/var/www
ORIGIN=origin
BRANCH=master
DATE="`date +%Y-%m-%d %H:%M`"


cd $WORK_DIR

echo "********************************************"
echo " ** Run Git pull @ $DATE "
pwd

# Run status for debug
echo " Status of  $WORK_DIR ..."
echo " "

/usr/bin/git status

echo " "

/usr/bin/git pull $ORIGIN $BRANCH

echo ""
echo " ***** Done ***** "
