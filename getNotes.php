<?php
$servername = "localhost";
$username = "root";
$password = "royalair";
$dbname = "dinahdb";

$sqlString = "";
$inData = $_POST;
$sql = "SELECT id, midi FROM treads";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully<br>";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $string = '{"1": 128,"2": 129,"3": 130,';
    $row = $result->fetch_assoc();
    $row = $result->fetch_assoc();
    $row = $result->fetch_assoc();
    while($row = $result->fetch_assoc()) {
        $string = $string . '"' . strval(intval($row["id"]) + 1) . '": ' . $row["midi"] . ",";
    }
    $string = rtrim($string, ",");
    $string = $string . "}";
    echo $string;
} else {
    echo "0 results";
}



//print_r($_POST);

$conn->close();
?>