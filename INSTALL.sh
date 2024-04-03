#!/bin/bash
unameOut="$(uname -s)"
case "${unameOut}" in
    Linux*)     machine=Linux;;
    Darwin*)    machine=Mac;;
    CYGWIN*)    machine=Cygwin;;
    MINGW*)     machine=MinGw;;
    MSYS_NT*)   machine=Git;;
    *)          machine="UNKNOWN:${unameOut}"
esac

if [ ! $machine == "Linux" ] && [ ! $machine == "Mac" ]; then
	echo 'This script only runs on Mac or Linux.';
	exit
fi

if [ ! -f /usr/bin/perl ]; then
	echo "Please install 'perl' for use this script.";
	exit
fi
SCRIPTDIR=$(realpath $(dirname "$0"));
DIRFORREGEX=$(echo "$SCRIPTDIR" | perl -p -e 's/\//\\\//g');
git restore $SCRIPTDIR/src/NextCordovaExporter/App.php;
if [ $machine == "Linux" ]; then
	perl -pi -e 's/#!\/usr\/bin\/env php/#!\/usr\/bin\/env '$DIRFORREGEX'\/bin\/php\/linux\/x64\/php/g' $SCRIPTDIR/src/NextCordovaExporter/App.php
elif [ $machine == "Mac" ]; then
	perl -pi -e 's/#!\/usr\/bin\/env php/#!\/usr\/bin\/env '$DIRFORREGEX'\/bin\/php\/mac\/x86\/php/g' $SCRIPTDIR/src/NextCordovaExporter/App.php
fi
sudo cp -r $SCRIPTDIR/bin/next-cordova-exporter /usr/local/bin
echo "Installed."
