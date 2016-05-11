<?php
$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '123456o';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
mysql_query("set character set 'utf8'");
mysql_query("set names 'utf8'");
mysql_select_db('ids');
?>