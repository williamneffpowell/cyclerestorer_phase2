#!/usr/bin/perl
use DBI;
$dbh = DBI->connect('dbi:mysql:mps','redbug2','redbug26953');

$dirname = "/usr/local/apache2/htdocs/redbug2/tempdir";

opendir(DIR, $dirname) or die "can't opendir tempdir: $!";
while (defined($file = readdir(DIR))) {
 
$dirname = "/usr/local/apache2/htdocs/redbug2/cyclerestorer/image_upload";
$dir2name = "/usr/local/apache2/htdocs/redbug2/cyclerestorer/image_upload/thumbs";
$d = -2;

opendir(DIR, $dirname) or die "can't opendir tempdir: $!";
while (defined($file = readdir(DIR))) {
$delete = 1;

$sql = "select p.filename FROM tb_pictures AS p, tb_user_pics AS u WHERE u.picID=p.picID AND p.filename='$file'";
$sth = $dbh->prepare($sql);
$sth->execute ||
           die "Could not execute SQL statement ... maybe invalid?";
@row = $sth->fetchrow_array();
if (@row[0] eq $file) {
$delete = 0;
}
else {
$sql = "select p.filename FROM tb_pictures AS p, tb_user AS u WHERE u.picID=p.picID AND p.filename='$file'";
$sth = $dbh->prepare($sql);
$sth->execute ||
           die "Could not execute SQL statement ... maybe invalid?";
@row = $sth->fetchrow_array();
if (@row[0] eq $file) {$delete = 0;}
else {
$sql = "select p.filename FROM tb_pictures AS p, tb_product_pics AS u WHERE u.picID=p.picID AND p.filename='$file'";
$sth = $dbh->prepare($sql);
$sth->execute ||
           die "Could not execute SQL statement ... maybe invalid?";
@row = $sth->fetchrow_array();
if (@row[0] eq $file) {$delete = 0;}
else {
$sql = "select p.filename FROM tb_pictures AS p, tb_user AS u WHERE u.picID=p.picID AND p.filename='$file'";
$sth = $dbh->prepare($sql);
$sth->execute ||
           die "Could not execute SQL statement ... maybe invalid?";
@row = $sth->fetchrow_array();
if (@row[0] eq $file) {$delete = 0;}
else {
$sql = "select p.filename FROM tb_pictures AS p, tb_blog AS u WHERE u.picID=p.picID AND p.filename='$file'";
$sth = $dbh->prepare($sql);
$sth->execute ||
           die "Could not execute SQL statement ... maybe invalid?";
@row = $sth->fetchrow_array();
if (@row[0] eq $file) {$delete = 0;}
else {
$sql = "select p.filename FROM tb_pictures AS p, tb_comment AS u WHERE u.picID=p.picID AND p.filename='$file'";
$sth = $dbh->prepare($sql);
$sth->execute ||
           die "Could not execute SQL statement ... maybe invalid?";
@row = $sth->fetchrow_array();
if (@row[0] eq $file) {$delete = 0;}
else {
$sql = "select p.filename FROM tb_pictures AS p, tb_messages AS u WHERE u.picID=p.picID AND p.filename='$file'";
$sth = $dbh->prepare($sql);
$sth->execute ||
           die "Could not execute SQL statement ... maybe invalid?";
@row = $sth->fetchrow_array();
if (@row[0] eq $file) {$delete = 0;}
else {
$sql = "select publicPic FROM tb_verified WHERE publicPic='$file'";
$sth = $dbh->prepare($sql);
$sth->execute ||
           die "Could not execute SQL statement ... maybe invalid?";
@row = $sth->fetchrow_array();
if (@row[0] eq $file) {$delete = 0;}
else {
$sql = "select adminPic FROM tb_verified WHERE adminPic='$file'";
$sth = $dbh->prepare($sql);
$sth->execute ||
           die "Could not execute SQL statement ... maybe invalid?";
@row = $sth->fetchrow_array();
if (@row[0] eq $file) {$delete = 0;}
}
}
}
}
}
}
}
}

if ($delete == 1 && $file != "default.jpg") {print "$dirname/$file"; print "$dir2name/$file";$d = $d + 1;}
}
closedir(DIR);
print "$d deleted\n";


