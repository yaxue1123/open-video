<?php
	$h = 'localhost';
	$u = 'root';
	$p = '';
	$dbname = 'openvideo';
	$mysqli= new mysqli($h,$u,$p,$dbname);
	if ($mysqli->connect_errno) {
		echo "Connect failed" .$mysqli->connect_error;
		exit();
}

?>
