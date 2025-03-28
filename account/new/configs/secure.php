<?php

// CHECK ADMIN Status
require("configs/connection.php");
$F_ADMINID 	= $_COOKIE["ETNGTOKEN"];

if (!isset($_COOKIE["ETNGTOKEN"])) {
	header("location:./");
}

if (isset($_GET["sign"])) {
	$sign = $_GET["sign"];

	if ($sign == "out") {
		setcookie("ETNGTOKEN", 0, time() + (86400 * 0), "/");
		setcookie("F_ADMIN_NAME", 0, time() + (86400 * 0), "/");
		header("location:./");
	}
}
