<?php

//$tonic_note = 53;

//$tonic_note = strip_tags(substr($_POST['tonic_note'],0, 100));
//$tonic_note = intval(mysql_escape_string($term));

$alpha = array("C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G");
$octave = array(-2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 8, 8, 8, 8, 8, 8, 8, 8);

//$tonic_array = array();
$tonic = intval($_POST['tonic']);
//console.log("Tonic: ");
console.log($tonic);
$starting_note = intval($_POST['starting_note']);
$scale = $_POST['scale'];

switch ($scale) {
	case "chromatic":
		// Chromatic scale MIDI intervals {0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11}
		$scale_mask = array(1,1,1,1,1,1,1,1,1,1,1,1);
		break;
	case "blues":
		// Blues scale MIDI intervals: {0, 2, 3, 4, 5, 7, 9, 10, 11}
		$scale_mask = array(1,0,1,1,1,1,0,1,0,1,1,1);
		break;
	case "major":
		//Major scale MIDI intervals: {0, 2, 4, 5, 7, 9, 11} Max tonic 62
		$scale_mask = array(1, 0, 1, 0, 1, 1, 0, 1, 0, 1, 0, 1);
		break;
	case "minor":
		// Minor {0, 2, 3, 5, 7, 8, 10}
		$scale_mask = array(1,0,1,1,0,1,0,1,1,0,1,0);
		break;
	case "pentatonic":
		// Pentatonic Scale MIDI intervals: {0, 2, 4, 7, 9}
		$scale_mask = array(1,0,1,0,1,0,0,1,0,1,0,0); // Maximum tonic is 53
		break;
	case "indian":
		// Indian Scale MIDI intervals {0, 1, 1, 4, 5, 8, 10}
		$scale_mask = array(1,1,0,0,1,1,0,0,1,0,1,0);
		break;
	default:
		$scale_mask = array(1, 0, 1, 0, 1, 1, 0, 1, 0, 1, 0, 1); // Major
}

$treads = array();
$scale_array = array();

$octave_position = 0;
$dist_from_tonic = 0;



echo "Tonic note is: $tonic_note <br><br>";
echo "Scale choice is: $scale <br><br>";

$note = $tonic;
while ($note < 128) {	
	//echo "$x $octave_position<BR>";
	if ($scale_mask[$octave_position] > 0) {
		$scale_array[$note] = $tonic + $dist_from_tonic;
		//echo "$note : ";
		//echo " $scale_array[$note] ";
		$name = $alpha[ $scale_array[$note] ];
		//echo " $name <BR>";
		$note++;
	}
	$dist_from_tonic++;
	$octave_position++;
	if ($octave_position > 11) {
		$octave_position = 0;
	}
}


//echo "<form id=\"starting_form\" method=\"post\">";
echo "<select name=\"starting_note\" id=\"starting_note\">";
$index = 0;
foreach($scale_array as $value) {
    if ($value < 128) {
		echo "<option value=\"";
		echo $index;
		echo "\">";
		echo $value;
		echo "</option>";
	}
	$index++;
}
echo "</select></form><br><br>";

$tread_to_fill = 0;

echo "<div class=\"div-table\">";
echo "<div class=\"div-table-row\">
		<div class=\"div-table-col\">Tread</div>
		<div class=\"div-table-col\">MIDI</div>
		<div class=\"div-table-col\">Note</div>
		<div class=\"div-table-col\">Octave</div>
	</div>
	";
while ($tread_to_fill < 32) {	
	$treads[$tread_to_fill] = $scale_array[($tread_to_fill + $starting_note)];
	echo "<div class=\"div-table-row\">";
	echo "<div class=\"div-table-col\">";
	echo "$tread_to_fill : ";
	echo "</div>";
	echo "<div class=\"div-table-col\">";
	echo " $treads[$tread_to_fill] ";
	echo "</div>";
	echo "<div class=\"div-table-col\">";
	$name = $alpha[ $treads[$tread_to_fill] ];
	echo " $name <BR>";
	echo "</div>";
	echo "<div class=\"div-table-col\">";
	$oct = $octave[ $treads[$tread_to_fill] ];
	echo " $oct";
	echo "</div>";

	echo "</div>";
	$tread_to_fill++;
}
echo "</div>";
?>