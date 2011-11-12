#!/usr/bin/php
<?php

$data = file_get_contents('php://stdin');

$dbh = mysql_connect('localhost', 'observer', 'observer');
mysql_select_db('observer');

$sql = "INSERT INTO emails (body, created) VALUES ('$data', NOW())";
if (mysql_query($sql)) {
	print "success";
}

?>
