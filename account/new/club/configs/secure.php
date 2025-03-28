<?php

// CHECK ADMIN Status
require("configs/connection.php");
$CLUBID 	= $_COOKIE["CLUB_ID"];

if (!isset($_COOKIE["CLUB_ID"])) {
	header("location:./");
}

if (isset($_GET["sign"])) {
	$sign = $_GET["sign"];

	if ($sign == "out") {
		setcookie("CLUB_ID", 0, time() + (86400 * 0), "/");
		setcookie("CLUB_NAME", 0, time() + (86400 * 0), "/");
		header("location:./");
	}
}
