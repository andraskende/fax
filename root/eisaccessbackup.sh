#!/bin/sh
DOW=$(date +"%a")
echo $DOW

mkdir -p /backups/$DOW
mkdir -p /backups/$DOW/AccessPointSites

rm -f /backups/$DOW/*
rm -f /backups/$DOW/AccessPointSites/*

rm -f /backups/eisaccess-$DOW.tar.gz
rm -f /backups/AccessPointSites-$DOW.tar.gz

rsync -r -v --progress /eisaccess/*.mdb /backups/$DOW
rsync -r -v --progress /eisaccess/AccessPointSites/*.mdb /backups/$DOW/AccessPointSites

tar cvzf /backups/eisaccess-$DOW.tar.gz /backups/$DOW/*.mdb
tar cvzf /backups/AccessPointSites-$DOW.tar.gz /backups/$DOW/AccessPointSites/*.mdb

s3cmd put /backups/eisaccess-$DOW.tar.gz s3://expressimagingservicesbackups/
s3cmd put /backups/AccessPointSites-$DOW.tar.gz s3://expressimagingservicesbackups/
