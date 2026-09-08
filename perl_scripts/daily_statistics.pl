#!/usr/bin/perl
use DBI;
$dbh = DBI->connect('dbi:mysql:cyclerestorer','redbug2','cyclerestorer');


$sql = "SELECT count FROM simplecount";
$sth = $dbh->prepare($sql);
$sth->execute ||
           die "Could not execute SQL statement ... maybe invalid?";
@row = $sth->fetchrow_array();
$daily_count =@row[0];


#print " dirname = $dirname "; 
#print " $file \n";


#$Query2 ="INSERT INTO daily_statistics(daily_count,count_date) VALUES ('$daily_count',now())";



$sql = "INSERT INTO daily_statistics(daily_count,count_date) VALUES ('$daily_count',now())";
$sth = $dbh->prepare($sql);
$sth->execute ||
           die "Could not execute SQL statement ... maybe invalid?";