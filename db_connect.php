<?php
$servername = "127.0.0.1:3305";
$username = "root";
$password = "root";
$dbase = "faker_dump";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbase);

// Check connection
if ($conn->connect_error) {
    die ("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected";
}
//echo "connected.";
?>