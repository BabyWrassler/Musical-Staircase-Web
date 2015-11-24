<?php

$root_note = 53;
//$root_plus_twelve = $root_note + 12;

//$root_note = strip_tags(substr($_POST['root_note'],0, 100));
//$root_note = mysql_escape_string($term);

//Major scale MIDI intervals: {0, 2, 4, 5, 7, 9, 11}
$major = array(1, 0, 1, 0, 1, 1, 0, 1, 0, 1, 0, 1);
// Blues scale MIDI intervals: {0, 2, 3, 4, 5, 7, 9, 10, 11}
$blues = array(1,0,2,3,4,5,0,7,0,9,10,11);
// Pentatonic Scale MIDI intervals: {0, 2, 4, 7, 9}
$pentatonic = array(1,0,2,0,1,0,0,1,0,1,0,0); // Maximum root is 53

$treads = array();

$octave_position = 0;
$dist_from_root = 0;
$tread_to_fill = 0;

while ($tread_to_fill < 32) {	
	//echo "$x $octave_position<BR>";
	if ($blues[$octave_position] > 0) {
		$treads[$tread_to_fill] = $root_note + $dist_from_root;
		echo "$tread_to_fill : ";
		echo " $treads[$tread_to_fill] <BR>";
		$tread_to_fill++;
	}
	$dist_from_root++;
	$octave_position++;
	if ($octave_position > 11) {
		$octave_position = 0;
	}
}
?>