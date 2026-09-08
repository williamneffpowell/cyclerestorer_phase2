#!/usr/bin/perl
use DBI;
$dbh = DBI->connect('dbi:mysql:cyclerestorer','redbug2','cyclerestorer');

$dirname = "/usr/local/apache2/htdocs/redbug2/cyclerestorer/tempdir";

opendir(DIR, $dirname) or die "can't opendir tempdir: $!";
while (defined($file = readdir(DIR))) {
  unlink("$dirname/$file");
}  
closedir(DIR);
  
$dirname =  "/usr/local/apache2/htdocs/redbug2/cyclerestorer/image_upload";
$dir2name = "/usr/local/apache2/htdocs/redbug2/cyclerestorer/image_upload/thumbs";
$d = -2;

opendir(DIR, $dir2name) or die "can't opendir tempdir: $!";
while (defined($file = readdir(DIR))) {

	$delete = 1;

	$sql = "select p.filename FROM tb_pictures AS p, registry AS u WHERE u.picID=p.picID AND p.filename='$file'";
	$sth = $dbh->prepare($sql);
	$sth->execute ||
           die "Could not execute SQL statement ... maybe invalid?";
	@row = $sth->fetchrow_array();
		if (@row[0] eq $file) {
			$delete = 0;
			}
			else 
			{$sql = "select p.filename FROM before_after_pics AS p, registry AS u WHERE u.picID=p.pic_row_ID AND p.filename='$file'";
			$sth = $dbh->prepare($sql);
			$sth->execute ||
           			die "Could not execute SQL statement ... maybe invalid?";
					@row = $sth->fetchrow_array();
		   # print "EQUALITY @row[0] $file \n";
			if (@row[0] eq $file) {
				$delete = 0;
				}
			} 




if ($delete == 1 & $file != "default.jpg") { 

print " dirname = $dirname $file \n";
print " dir2name = $dir2name $file \n"; 

#unlink("$dir2name/$file"); 
#unlink("$dirname/$file");




 $d = $d + 1;}
 

}

closedir(DIR);
print "$d deleted\n";



