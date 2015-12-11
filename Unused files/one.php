<html> 
<head> 
<title>+++ Testing +++</title> 
<link rel="stylesheet" type="text/css" href="keys.css">
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<script src="./jquery.js"></script>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
/*$(function() {
$("#selectable, #aselectable").selectable({
      selecting: function(event, ui){
            if( $(".ui-selected, .ui-selecting").length > 1){
                  $(ui.selecting).removeClass("ui-selecting");
            }
      }
});
});*/

/*$(function() {
$("#aselectable").selectable({
      selecting: function(event, ui){
            if( $(".ui-selected, .ui-selecting").length > 1){
                  $(ui.selecting).removeClass("ui-selecting");
            }
      }
});
});*/

$(function() {
	$( "#selectable" ).selectable({
	  stop: function() {
		var result = $( "#select-result" ).empty();
		$( ".ui-selected", this ).each(function() {
		  var index = $( "#selectable div" ).index( this );
		  console.log(index);
		  result.append( " #" + ( index ) );
		});
	  }
	});
});


$(function() {
	$( "#aselectable" ).selectable({
	  stop: function() {
		var aresult = $( "#aselect-result" ).empty();
		$( ".ui-selected", this ).each(function() {
		  var index = $( "#aselectable div" ).index( this );
		  console.log(index);
		  aresult.append( " #" + ( index ) );
		});
	  }
	});
});
</script>


<script type='text/javascript'>
$(document).ready(function(){ 
//$("#scale_results").slideUp(); 
    $("#generate_button").click(function(e){ 
        e.preventDefault(); 
        ajax_generate(); 
        create_scale();
    }); 
    $("#tonic_note").keyup(function(e){ 
        console.log(parseInt($("#tonic_note").val()));
        if (parseInt($("#tonic_note").val()) < 0) $("#tonic_note").val(0);
	    if (parseInt($("#tonic_note").val()) > 127) $("#tonic_note").val(127);
        e.preventDefault(); 
        ajax_generate(); 
    }); 
    $('form').change(function(e){ 
        e.preventDefault(); 
        ajax_generate(); 
    }); 
    $('form').click(function(e){ 
        e.preventDefault(); 
        ajax_generate(); 
    }); 

});

function ajax_generate(){ 
  
  $("#scale_results").show();
  var note_val=$("#tonic_note").val();
  var scale_val = $("#scale").val();
  var starting_val=$("#select-result").val();
  var tonic_val=$("#tonic").val();
  console.log(starting_val);
  $.post("./generate.php", {scale : scale_val, tonic_note : note_val, tonic : tonic_val, starting_note : starting_val}, function(data){
   if (data.length>0){ 
     //$("#scale_results").html(data); 
   } 
  }) 
} 
</script>

<script>

function create_scale(){
	
	var alpha = ["C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G"];
	var octave = [-2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 8, 8, 8, 8, 8, 8, 8, 8];
	var scale_mask = [];

	//$tonic_array = array();
	var tonic = parseInt($("#tonic").val());
	console.log("Tonic: ");
	console.log(tonic);
	var starting_note = parseInt($("#starting").val());
	//$starting_note = 0;
	var scale = $("#scale").val();
	var notes_in_scale = 0;

	switch (scale) {
	case "chromatic":
		// Chromatic scale MIDI intervals {0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11}
		scale_mask = [1,1,1,1,1,1,1,1,1,1,1,1];
		notes_in_scale = 12;
		break;
	case "blues":
		// Blues scale MIDI intervals: {0, 2, 3, 4, 5, 7, 9, 10, 11}
		scale_mask = [1,0,1,1,1,1,0,1,0,1,1,1];
		notes_in_scale = 9;
		break;
	case "major":
		//Major scale MIDI intervals: {0, 2, 4, 5, 7, 9, 11} Max tonic 62
		scale_mask = [1, 0, 1, 0, 1, 1, 0, 1, 0, 1, 0, 1];
		notes_in_scale = 7;
		break;
	case "minor":
		// Minor {0, 2, 3, 5, 7, 8, 10}
		scale_mask = [1,0,1,1,0,1,0,1,1,0,1,0];
		notes_in_scale = 7;
		break;
	case "pentatonic":
		// Pentatonic Scale MIDI intervals: {0, 2, 4, 7, 9}
		scale_mask = [1,0,1,0,1,0,0,1,0,1,0,0]; // Maximum tonic is 53
		notes_in_scale = 5;
		break;
	case "indian":
		// Indian Scale MIDI intervals {0, 1, 1, 4, 5, 8, 10}
		scale_mask = [1,1,0,0,1,1,0,0,1,0,1,0]; // Skips the double 1
		notes_in_scale = 6; // Should be 7
		break;
	default:
		scale_mask = [1, 0, 1, 0, 1, 1, 0, 1, 0, 1, 0, 1]; // Major
	}
	
	var ii;
	for (ii=0; ii>12; ii++) {
		var log = scale_mask[ii];
		console.log(log);
	}
	
	var treads = [];
	var scale_array = [];

	var octave_position = 0;
	var dist_from_tonic = 0;
	
	document.getElementById("chosen_starting").innerHTML = starting_note;
	document.getElementById("chosen_tonic").innerHTML = tonic;
	document.getElementById("chosen_scale").innerHTML = scale;
	
	var note = tonic;
	
	while (note < 140) {	
	//echo "$x $octave_position<BR>";
	if (scale_mask[octave_position] > 0) {
		scale_array[note] = tonic + dist_from_tonic;
		//echo "$note : ";
		//echo " $scale_array[$note] ";
		var name = alpha[ scale_array[note] ];
		//echo " $name <BR>";
		note++;
	}
	dist_from_tonic++;
	octave_position++;
	if (octave_position > 11) {
		octave_position = 0;
	}
}

/*for (var x=0; x<12; x++) {
	scale_array.shift();
}*/


for (var x=0; x<128; x++) {
	//var dest = scale_array[(x)];
	//var src = (scale_array[x + notes_in_scale] -12); // was -12
	//var tmp = (dest.toString()).concat(" = ");
	//tmp = tmp.concat(src);
	//console.log(tmp);
	var tmp = (scale_array[x + notes_in_scale] - 12)
	console.log(tmp);
	// add isNAN shift here!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

	//if (tmp<127) {
		if ((Number.isInteger(tmp)) && (tmp<128)) {
			if (tmp > -1) {
				scale_array[x] = tmp;
				console.log("Is number");
				console.log(tmp);
			} else {
				scale_array.splice(x,1);
				//scale_array.shift();
				console.log("splice");
			}
		} else if ( isNaN(tmp) ) {
			scale_array.splice(x,1);
			//scale_array.shift();
			console.log("splice");
		}
	//}
}

for (x=0; x<scale_array.length; x++) {
	if (isNaN(scale_array[x])) {
		scale_array.splice(x,1);
	}
}

var tread_to_fill = 0;

var table_string = "";
table_string += "<div class=\"div-table\">";
table_string += "<div class=\"div-table-row\"> <div class=\"div-table-col\">Tread</div> <div class=\"div-table-col\">MIDI</div> <div class=\"div-table-col\">Note</div> <div class=\"div-table-col\">Octave</div> </div>";

while (tread_to_fill < 32) {	
	var blog = scale_array[(tread_to_fill + starting_note)];
	if (Number.isInteger(blog) && ((blog > -1) && (blog < 128)) ) {
		treads[tread_to_fill] = blog;
	
		console.log("filling tread:");
		console.log(blog);
		table_string += "<div class=\"div-table-row\">";
		table_string += "<div class=\"div-table-col\">";
		table_string += tread_to_fill;
		table_string += "</div>";
		table_string += "<div class=\"div-table-col\">";
		table_string += treads[tread_to_fill];
		table_string += "</div>";
		table_string += "<div class=\"div-table-col\">";
		name = alpha[ treads[tread_to_fill] ];
		table_string += name;
		table_string += "<br></div>";
		table_string += "<div class=\"div-table-col\">";
		var oct = octave[ treads[tread_to_fill] ];
		table_string += oct;
		table_string += "</div>";

		table_string += "</div>";
	}
	tread_to_fill++;
}
table_string += "</div><BR><BR>";
document.getElementById("scale_table").innerHTML = table_string;

}

</script>


</head> 



<body> 
<h1>Choose a tonic note</h1> 
    <form id="scale_form" method="post"> 
<div> 
        <select name="scale" id="scale" >
        	<option value="major">Major</option>
        	<option value="minor">Minor</option>
        	<option value="blues">Blues</option>
        	<option value="pentatonic">Pentatonic</option>
        	<option value="indian">Indian</option>
        	<option value="chromatic">Chromatic</option>
        </select>
        <select name="tonic" id="tonic">
        	<option value="0">C</option>
			<option value="1">C#</option>
			<option value="2">D</option>
			<option value="3">D#</option>
			<option value="4">E</option>
			<option value="5">F</option>
			<option value="6">F#</option>
			<option value="7">G</option>
			<option value="8">G#</option>
			<option value="9">A</option>
			<option value="10">A#</option>
			<option value="11">B</option>
		</select>
		<select name="starting" id="starting">
        	<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
		</select>


<input type="submit" value="Generate Scale" id="generate_button" /> 
</div> 
</form>
    <div id="scale_results">
    
    
    </div> 
 
 
 
 
 
 
 <?php
/*
//$tonic_note = 53;

//$tonic_note = strip_tags(substr($_POST['tonic_note'],0, 100));
//$tonic_note = intval(mysql_escape_string($term));

$alpha = array("C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G");
$octave = array(-2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 8, 8, 8, 8, 8, 8, 8, 8);

//$tonic_array = array();
$tonic = intval($_POST['tonic']);
//console.log("Tonic: ");
console.log($tonic);
$starting_note = intval($_POST['starting_note']);
//$starting_note = 0;
$scale = $_POST['scale'];
$notes_in_scale = 0;

switch ($scale) {
	case "chromatic":
		// Chromatic scale MIDI intervals {0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11}
		$scale_mask = array(1,1,1,1,1,1,1,1,1,1,1,1);
		$notes_in_scale = 12;
		break;
	case "blues":
		// Blues scale MIDI intervals: {0, 2, 3, 4, 5, 7, 9, 10, 11}
		$scale_mask = array(1,0,1,1,1,1,0,1,0,1,1,1);
		$notes_in_scale = 9;
		break;
	case "major":
		//Major scale MIDI intervals: {0, 2, 4, 5, 7, 9, 11} Max tonic 62
		$scale_mask = array(1, 0, 1, 0, 1, 1, 0, 1, 0, 1, 0, 1);
		$notes_in_scale = 7;
		break;
	case "minor":
		// Minor {0, 2, 3, 5, 7, 8, 10}
		$scale_mask = array(1,0,1,1,0,1,0,1,1,0,1,0);
		$notes_in_scale = 7;
		break;
	case "pentatonic":
		// Pentatonic Scale MIDI intervals: {0, 2, 4, 7, 9}
		$scale_mask = array(1,0,1,0,1,0,0,1,0,1,0,0); // Maximum tonic is 53
		$notes_in_scale = 5;
		break;
	case "indian":
		// Indian Scale MIDI intervals {0, 1, 1, 4, 5, 8, 10}
		$scale_mask = array(1,1,0,0,1,1,0,0,1,0,1,0); // Skips the double 1
		$notes_in_scale = 6; // Should be 7
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
while ($note < 140) {	
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

for ($x=0; $x<140; $x++) {
	$dest = $scale_array[($x)];
	$src = ($scale_array[$x + $notes_in_scale] -12);
	//echo "$dest = $src <br>";
	$scale_array[($x)] = ($scale_array[$x + $notes_in_scale] - 12);
}
	


//echo "<form method=\"post\"><select name=\"starting_note\" id=\"starting_note\">";
//$index = 0;
//foreach($scale_array as $value) {
 //   if ($value < 128) {
//		echo "<option value=\"";
//		echo $value;
//		echo "\">";
//		echo $value;
//		echo "</option>";
//	}
//	$index++;
//}
//echo "</select></form><br><br>";
echo "</form>";

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
echo "</div><BR><BR>";
*/
?>

<span id="scale_table">none</span>


<p id="feedback"><span>Tonic note: </span> <span id="chosen_tonic">none</span>.</p>
<p id="feedback"><span>Scale choice: </span> <span id="chosen_scale">none</span>.</p>
<p id="feedback"><span>Starting note: </span> <span id="chosen_starting">none</span>.</p>


<p id="afeedback"><span>You've selected:</span> <span id="aselect-result">none</span>.</p>

<p id="feedback"><span>You've selected:</span> <span id="select-result">none</span>.</p>

<div class="div-octave-table">
<div class="div-octave-col">Octave</div><br>
<div class="div-octave-col">-2</div><br>
<div class="div-octave-col">-1</div><br>
<div class="div-octave-col">0</div><br>
<div class="div-octave-col">1</div><br>
<div class="div-octave-col">2</div><br>
<div class="div-octave-col">3</div><br>
<div class="div-octave-col">4</div><br>
<div class="div-octave-col">5</div><br>
<div class="div-octave-col">6</div><br>
<div class="div-octave-col">7</div><BR>
<div class="div-octave-col">8</div>
</div>

<div class="table-container">
<div id="aselectable" class="div-mtable">
<div class="div-alpha-table-col">C</div>
<div class="div-alpha-table-col">C#</div>
<div class="div-alpha-table-col">D</div>
<div class="div-alpha-table-col">D#</div>
<div class="div-alpha-table-col">E</div>
<div class="div-alpha-table-col">F</div>
<div class="div-alpha-table-col">F#</div>
<div class="div-alpha-table-col">G</div>
<div class="div-alpha-table-col">G#</div>
<div class="div-alpha-table-col">A</div>
<div class="div-alpha-table-col">A#</div>
<div class="div-alpha-table-col">B</div>
</div>


<div id="selectable">

<?php
$m = 0;
for ($r = 0; $r < 11; $r++) {
	//echo "<div id=\"selectable\" class=\"div-mtable-row\">";
	//echo "<div class=\"div-mtable-col\">";
	//echo ($r - 2);
	//echo "</div>";
	for ($c = 0; $c < 12; $c++) {
		if ($m < 128) {
			echo "<div class=\"div-mtable-col\">$m</div>";
			$m++;
		}
	}
	echo "<BR>";
	//echo "</div>";
}
echo "</div>";
echo "</div>";

?>
</div>
 

    
<BR>
<div class=\"div-mtable\">
<div class=\"div-mtable-row\">
</div>
</div>
</body> 
</html>