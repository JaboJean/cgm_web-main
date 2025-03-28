<?php

// CHECK ADMIN Status
require("configs/connection.php");
$IHZ_ADMINID 	= $_COOKIE["CGMTOKEN"];

if (!isset($_COOKIE["CGMTOKEN"])) {
	header("location:./");
}

if (isset($_GET["sign"])) {
	$sign = $_GET["sign"];
	
	if ($sign == "out") {
		setcookie("CGMTOKEN", 0, time() + (86400 * 0), "/");
		// setcookie("IHZ_ADMIN_NAME", 0, time() + (86400 * 0), "/");
		header("location:./");
	}
}
