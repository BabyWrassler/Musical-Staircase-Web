<?php
$servername = "localhost";
$username = "root";
$password = "royalair";
$dbname = "dinahdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully<br>";

$sql = "INSERT INTO treads (id, midi, alpha, red, green, blue)
VALUES ('1', '48', 'C2', '255', '0', '0')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>