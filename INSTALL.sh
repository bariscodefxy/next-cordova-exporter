#!/bin/bash
BASEDIR=$(dirname "$0")
sudo cp -r $BASEDIR/bin/next-cordova-exporter /usr/local/bin
echo "Installed."