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
	echo "\n !!! No user name provided. Usage : ./creategenericWebUser.sh TomsCouncil\n"
  exit 
fi

USER=$1
USERDIR=/var/www/htdocs/users/
CONF=/var/www/config
DEFAULTS=$USERDIR/UserDefaults/

echo "1) Create User directory ..."
mkdir $USERDIR$USER

echo "2) Add sub folders (img, conf, docs, etc) ..."
mkdir $USERDIR$USER/img
mkdir $USERDIR$USER/conf
mkdir $USERDIR$USER/docs

echo "3) Create generic include file ..."
cp $DEFAULTS/include.php $USERDIR$USER/include.php
cp $DEFAULTS/display.conf.php $USERDIR$USER/conf/

echo "4) Create Home template $USER.tpl ..."
cp $DEFAULTS/Home.tpl $USERDIR/templates/$USER.tpl

echo "5) Commit to Git Source Control "
git add $USERDIR$USER
git add $USERDIR/templates/$USER.tpl
git commit -m "$USER : GENERIC AUTO INITIAL REVISION"
git push -u origin master

echo ""
echo "*** DONE : $USERDIR$USER "
echo ""

echo "Copy the following for a user config to AWS S3 : "
echo "://s3.console.aws.amazon.com/s3/object/www-data.manly.hydraulics.works/$USER/LakeMac/config/" 
cat $DEFAULTS/display.txt
