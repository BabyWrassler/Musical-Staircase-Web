<?php
$servername = "localhost";
$username = "root";
$password = "royalair";
$dbname = "dinahdb";

$sqlString = "";
$inData = $_POST;
$delSql = "DELETE FROM treads;";
$sql = "INSERT INTO treads (id, midi) VALUES ";

for ($i=0; $i < 31; $i++) {
	//print_r("Test:");
	$g = "i" . $i;
	$h = $inData[$g];
	//print_r($h);
	$sql .= "('$i', '$h'), ";
}
	$g = "i" . $i;
	$h = $inData[$g];
	//print_r($h);
	$sql .= "('$i', '$h');";

/*
for ($i=0; $i < 31; $i++) {
	//print_r("Test:");
	$g = "i" . $i;
	$h = $inData[$g];
	print_r($h);
	$sqlString = $sqlString ."'".$h."', ";
}
//$i++;
$g = "i" . $i;
$h = $inData[$g];
print_r($h);
$sqlString = $sqlString ."'".$h."'";
print_r($sqlString);*/

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully<br>";

//$sql = "INSERT INTO treads (id, midi, alpha, red, green, blue) VALUES ('1', '48', 'C2', '255', '0', '0')";

if ($conn->query($delSql) === TRUE) {
    //echo "Records deleted successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

if ($conn->query($sql) === TRUE) {
    //echo "Records created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


//print_r($_POST);

$conn->close();
?>