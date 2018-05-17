#/bin/sh

###########################################
#
# @ Auth : Adriaan Woerlee 
# @ Date : 11 May 2017
#
# Create a direcotry structure for a new web client
# Add any default files
#
###########################################

if [ $# -eq 0 ]
  then 
	echo "\n !!! No user name provided. Usage : ./add_user.sh Tom\n"
  exit 
fi

USER=$1
USERDIR=/var/www/htdocs/users/
CONF=/var/www/config

echo "1) Create User directory ..."
mkdir $USERDIR$USER

echo "2) Add sub folders (img, conf, docs, etc) ..."
mkdir $USERDIR$USER/img
mkdir $USERDIR$USER/conf
mkdir $USERDIR$USER/docs

echo "3) Create empty conf file ..."
cp $USERDIR/conf/default-user.conf $USERDIR$USER/config.cfg

echo "4) Create empty include file ..."
cp $USERDIR/conf/default-user.php $USERDIR$USER/include.php

echo "5) Copy default display configs ..."
cp $CONF/display.* $USERDIR$USER/conf


echo ""
echo "*** DONE : $USERDIR$USER "
echo ""
