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

$sql = "SELECT * FROM treads";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Tread: " . $row["id"]. " - MIDI: " . $row["midi"]. " - Alpha: " . $row["alpha"] . " - Color: " . $row["red"] .",". $row["green"] .",". $row["blue"] . "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>