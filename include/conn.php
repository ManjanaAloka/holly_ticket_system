<?php
date_default_timezone_set("Asia/Colombo");
$date = date("Y/m/d") . ' - ' . date("h:i:s");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "holly";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


