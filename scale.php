<html> 
<head> 
<title>StepNotes Control Panel</title> 
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="keys.css">
<script src="./jquery.js"></script>

<script>

function chooseStarting(nn) {
    $("#starting").val(nn);
    create_scale();
}

function chooseTonic(elmnt) {
    $('.div-alpha-table-col.chosen').removeClass("chosen");
    elmnt.classList.add("chosen");
    var value = $(elmnt).attr('value');
    $("#tonic").val(value);
    $("#starting").val(0);
    //if (value > 5) $("#starting").val(1);
    //console.log(value);
    //elmnt.classList.remove("unchosen");
    create_scale();
}

function chooseScale(elmnt) {
    //elmnt.style.color = 'white';
    $('.scale-choice.chosen').removeClass("chosen");
    elmnt.classList.add("chosen");
    var value = $(elmnt).attr('value');
    $("#scale").val(value);
    $("#starting").val(0);
    create_scale();
}

$(document).ready(function(){ 
	create_scale();
    $("#generate_button").click(function(e){ 
        e.preventDefault(); 
        create_scale();
    }); 
    $("#tonic_note").keyup(function(e){ 
        if (parseInt($("#tonic_note").val()) < 0) $("#tonic_note").val(0);
	    if (parseInt($("#tonic_note").val()) > 127) $("#tonic_note").val(127);
        e.preventDefault();
        create_scale(); 
    }); 
    $('form').change(function(e){ 
        e.preventDefault();
        create_scale();
    });
    $('form').click(function(e){ 
        e.preventDefault();
        //create_scale();
    }); 
    $("#scale").change(function(e){ 
        e.preventDefault();
        $("#starting").val(0);
        create_scale();
    }); 
    $("#scale").click(function(e){ 
        e.preventDefault();
        $("#starting").val(0);
        create_scale();
    }); 

});

// Filter for scale_array to make sure bad values go through
function underOneTwoEight(value) {
  return ((value < 128) && (value > -1));
}

// Main function for generating notes using chosen scale, tonic note, starting note.
function create_scale(){
	
	var alpha = ["C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G"];
	var octave = [-2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 8, 8, 8, 8, 8, 8, 8, 8];
	var scale_mask = [];
	var maxStartNote = 0;

	var tonic = parseInt($("#tonic").val());
	var starting_note = parseInt($("#starting").val());
	var scale = $("#scale").val();
	var notes_in_scale = 0;

	switch (scale) {
	case "aeolian":
		// Aeolian scale MIDI intervals {0, 2, 3, 5, 7, 8, 10}
		scale_mask = [1,0,1,1,0,1,0,1,1,0,1,0];
		notes_in_scale = 7;
		break;
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
		notes_in_scale = 6; // should be 7?
		break;
	case "diatonic_minor":
		// MIDI intervals {0, 2, 3, 5, 7, 8, 10}
		scale_mask = [1,0,1,1,0,1,0,1,1,0,1,0]; 
		notes_in_scale = 7; 
		break;
	case "dorian":
		// Dorian Scale MIDI intervals {0, 2, 3, 5, 7, 9, 10}
		scale_mask = [1,0,1,1,0,1,0,1,0,1,1,0]; 
		notes_in_scale = 7; 
		break;
	case "locrian":
		// Locrian Scale MIDI intervals {0, 1, 3, 5, 6, 8, 10}
		scale_mask = [1,1,0,1,0,1,1,0,1,0,1,0]; 
		notes_in_scale = 7; 
		break;
	case "lydian":
		// Lydian Scale MIDI intervals {0, 2, 4, 6, 7, 9, 10}
		scale_mask = [1,0,1,0,1,0,1,1,0,1,1,0]; 
		notes_in_scale = 7; 
		break;
	case "melodic_minor":
		// Melodic Minor Scale MIDI intervals {0, 2, 3, 5, 7, 8, 9, 10, 11}
		scale_mask = [1,0,1,1,0,1,0,1,1,1,1,1]; 
		notes_in_scale = 9; 
		break;
	case "mixolydian":
		// Mixolydian Scale MIDI intervals {0, 2, 4, 5, 7, 9, 10}
		scale_mask = [1,0,1,0,1,1,0,1,0,1,1,0]; 
		notes_in_scale = 7; 
		break;
	case "natural_minor":
		// Natural Minor Scale MIDI intervals {0, 2, 3, 5, 7, 8, 10}
		scale_mask = [1,0,1,1,0,1,0,1,1,0,1,0]; 
		notes_in_scale = 7; 
		break;
	case "phrygian":
		// Phrygian Scale MIDI intervals {0, 1, 3, 5, 7, 8, 10}
		scale_mask = [1,1,0,1,0,1,0,1,1,0,1,0]; 
		notes_in_scale = 7; 
		break;
	case "harmonic_minor":
		// Harmonic Minor Scale MIDI intervals {0, 2, 3, 5, 7, 8, 11}
		scale_mask = [1,0,1,1,0,1,0,1,1,0,0,1];
		notes_in_scale = 7; 
		break;
	case "turkish":
		// Turkish Scale MIDI intervals {0, 1, 3, 5, 7, 10, 11}
		scale_mask = [1,1,0,1,0,1,0,1,0,0,1,1]; 
		notes_in_scale = 7; 
		break;
	default:
		// Default to Major scale
		scale_mask = [1, 0, 1, 0, 1, 1, 0, 1, 0, 1, 0, 1]; // Major
		notes_in_scale = 7;
	}
	
	var treads = []; // Will hold note assignments for each tread
	var scale_array = []; // Will hold scale generated from tonic and scale choice
	var octave_position = 0; // Track movement through 12-note octaves
	var dist_from_tonic = 0;
	var note = tonic;
	
	while (note < 140) {	
	if (scale_mask[octave_position] > 0) {
		scale_array[note] = tonic + dist_from_tonic;
		note++;
	}
	dist_from_tonic++;
	octave_position++;
	if (octave_position > 11) {
		octave_position = 0;
	}
}

// Shift scale array over by 12 to fill gaps left by possible non-C tonic choice.
var x=0;
for (x=0; x<128; x++) {
	var tmp = (scale_array[x + (notes_in_scale)] - 12)
	scale_array[x] = tmp;
}
for (x=0; x<scale_array.length; x++) {
	//console.log(scale_array[x]);
	
	if (isNaN(scale_array[x]) || (typeof scale_array[x]) == 'undefined') {
		scale_array.splice(x,1);
	}
}
var scale_array = scale_array.filter(underOneTwoEight);

var tread_to_fill = 0;
var scale_ind = 0;
var table_string = "";
table_string += "<div class=\"div-table\">";
table_string += "<div class=\"div-table-row\"> <div class=\"div-table-col\">Tread</div> <div class=\"div-table-col\">MIDI</div> <div class=\"div-table-col\">Note</div> <div class=\"div-table-col\">Octave</div> </div>";

// Fill treads array from scale_array using starting_note
while (tread_to_fill < 32) {		
	var blog = scale_array[(scale_ind + starting_note)];
	if (Number.isInteger(blog) && ((blog > -1) && (blog < 128)) ) {
		treads[tread_to_fill] = blog;
		// HTML here is for debugging output
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
		tread_to_fill++;
	}
	scale_ind++;
}
table_string += "</div><BR><BR>";
// Disable output of ugly debugging treads table:
//document.getElementById("scale_table").innerHTML = table_string;

	$('.tread').removeClass("tread");
	$('.first-tread').removeClass("first-tread");
	$('.note').attr("scale_index", 128);
	
	var $noteDiv
	for(var z=0; z<treads.length; z++) {
		$noteDiv = $("[name='" + treads[z] + "']")[0];
		$noteDiv.classList.add("tread");
		if (z == 0) $noteDiv.classList.add("first-tread");
    }
	
	var w=0;
	var n=0;
		
	$('.scale').removeClass("scale");
	$('.avail-start').removeClass("avail-start");
	
	var scale_array = scale_array.filter(underOneTwoEight);
	//console.log(scale_array);
	var max = Math.max.apply( Math, scale_array ); // Not sure if I used this
	//console.log(max);
    maxStartNote = scale_array.length - 32;
    //console.log(maxStartNote);
    
	for(w=0; w<scale_array.length; w++) {
			$noteDiv = $("[name='" + scale_array[w] + "']")[0];
			$noteDiv.setAttribute("scale_index", w);
			$noteDiv.classList.add("scale");
			if (w <= maxStartNote) {
				$noteDiv.classList.add("avail-start");
				$noteDiv.setAttribute("onclick", 'chooseStarting("' + w + '")');
			} else {
				$noteDiv.setAttribute("onclick", null);
			}
	}

	var prepTreads = "";
	prepTreads += "[";
	tLimit = treads.length - 1;
	//console.log(tLimit);
	for(var t=0; t < tLimit; t++) {
		prepTreads += '"';
		prepTreads += t;
		prepTreads += '": "';
		prepTreads += treads[t];
		prepTreads += '", ';
	}
	prepTreads += '"';
	prepTreads += t;
	prepTreads += '": "';
	prepTreads += treads[t];
	prepTreads += '" ]';
	console.log("done");
	
	var objTreads = {};
	for (t=0; t<treads.length; t++) {
		objTreads[("i" + t)] = treads[t];
	}
	objTreads["i32"] = parseInt($("#instrument").val());;
	
	//console.log(objTreads);
	
	$.post('postNotes.php', objTreads, function(data){	 
		$('#response').html(data);
	}).fail(function() {
		alert( "Posting failed." );
	});
}



function myFunction(response) {
    var arr = JSON.parse(response);
    var i;
    var out = "Data = ";

    for(i = 0; i < arr.length; i++) {
        out += arr[i];
    }
    console.log(out);
}

</script>
</head> 

<body> 
<h1 class="page-title"><span class="glyphicon glyphicon-music"></span> StepNotes Control Panel <span class="glyphicon glyphicon-music"></span></h1> 
    <form id="scale_form" method="post"> 
<div> 
        <select name="scale" id="scale" >
        	<option value="major">Major</option>
        	<option value="minor">Minor</option>
        	<option value="blues">Blues</option>
        	<option value="pentatonic">Pentatonic</option>
        	<option value="indian">Indian</option>
        	<option value="chromatic">Chromatic</option>
        	<option value="aeolian">Chromatic</option>
        	<option value="diatonic_minor">Diatonic Minor</option>
        	<option value="dorian">Dorian</option>
        	<option value="harmonic_minor">Harmonic Minor</option>
        	<option value="locrian">Locrian</option>
        	<option value="lydian">Lydian</option>
        	<option value="melodic_minor">Melodic Minor</option>
        	<option value="mixolydian">Mixolydian</option>
        	<option value="natural_minor">Natural Minor</option>
        	<option value="phrygian">Phryrian</option>
        	<option value="turkish">Turkish</option>
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
<?php
	for($y=0; $y < 128; $y++) {
		echo"<option value=\"$y\">$y</option>";
	}
?>
		</select>
<select name="instrument" id="instrument">	
<?php
	$instNames = ["Strangler Lead", "Hammer Dulcimer", "Brassinski", "Silk Horns", "Analog Saw Bass", "Boffner Bass", "Fat Leather Bass", "Wobble Bass", "Sogawni Arp", "Stutter Pad", "African Bars", "Bright Marimba", "Haunted Bell", "Funky Organ", "Grand Piano", "Stevie Wow", "M Tron Strings", "Space Arp", "Buzzer Lead", "Minor to Major Lead", "Bass Groove", "Euro Dance Lead", "Sister", "Spacious Choir", "Flute Lead"];
	$instLimit = count($instNames);
	for($iii=0; $iii < $instLimit; $iii++) {
		echo"<option value=\"$iii\">$instNames[$iii]</option>";
	}
?>
</select>
<input type="submit" value="Generate Scale" id="generate_button" /> 
</div> 
</form>
 
<br>
<span class="scale-label">Choose a scale<span class="glyphicon glyphicon-arrow-down" style="position:relative; top:10px; display:none;"></span></span>
<div class="div-scale-table">
	<div onclick="chooseScale(this)" class="scale-choice chosen" value="major">Major</div>
	<div onclick="chooseScale(this)" class="scale-choice" value="minor">Minor</div>
	<div onclick="chooseScale(this)" class="scale-choice" value="blues">Blues</div>
	<div onclick="chooseScale(this)" class="scale-choice" value="indian">Indian</div>
	<div onclick="chooseScale(this)" class="scale-choice" value="pentatonic">Pentatonic</div>
	<div onclick="chooseScale(this)" class="scale-choice" value="chromatic">Chromatic</div>
	<div onclick="chooseScale(this)" class="scale-choice" value="aeolian" style="display:none;">Aeolian</div>
	<div onclick="chooseScale(this)" class="scale-choice" value="diatonic_minor">Aeolian/Diatonic Minor</div>
	<div onclick="chooseScale(this)" class="scale-choice" value="dorian">Dorian</div>
	<div onclick="chooseScale(this)" class="scale-choice" value="harmonic_minor">Harmonic Minor</div>
	<div onclick="chooseScale(this)" class="scale-choice" value="locrian">Locrian</div>
	<div onclick="chooseScale(this)" class="scale-choice" value="lydian">Lydian</div>
	<div onclick="chooseScale(this)" class="scale-choice" value="melodic_minor">Melodic Minor</div>
	<div onclick="chooseScale(this)" class="scale-choice" value="mixolydian">Mixolydian</div>
	<div onclick="chooseScale(this)" class="scale-choice" value="natural_minor">Natural Minor</div>
	<div onclick="chooseScale(this)" class="scale-choice" value="phrygian">Phryrian</div>
	<div onclick="chooseScale(this)" class="scale-choice" value="turkish">Turkish</div>
</div>
<br>

<span class="tonic-label">Choose a tonic note</span>
<span class="note-label">and then choose an <span class="available-text">available</span> starting note</span>
<br>
<br>
<div class="div-octave-table">
<div class="div-octave-col">Oct</div><br>
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
<div onclick="chooseTonic(this)" value="0" name="C" class="div-alpha-table-col chosen">C</div>
<div onclick="chooseTonic(this)" value="1" name="C#" class="div-alpha-table-col">C#</div>
<div onclick="chooseTonic(this)" value="2" name="D" class="div-alpha-table-col">D</div>
<div onclick="chooseTonic(this)" value="3" name="D#" class="div-alpha-table-col">D#</div>
<div onclick="chooseTonic(this)" value="4" name="E" class="div-alpha-table-col">E</div>
<div onclick="chooseTonic(this)" value="5" name="F" class="div-alpha-table-col">F</div>
<div onclick="chooseTonic(this)" value="6" name="F#" class="div-alpha-table-col">F#</div>
<div onclick="chooseTonic(this)" value="7" name="G" class="div-alpha-table-col">G</div>
<div onclick="chooseTonic(this)" value="8" name="G#" class="div-alpha-table-col">G#</div>
<div onclick="chooseTonic(this)" value="9" name="A" class="div-alpha-table-col">A</div>
<div onclick="chooseTonic(this)" value="10" name="A#" class="div-alpha-table-col">A#</div>
<div onclick="chooseTonic(this)" value="11" name="G" class="div-alpha-table-col">B</div>
</div>

<div class="div-note-table">

<?php
$m = 0;
for ($r = 0; $r < 11; $r++) {
	//echo "<div id=\"selectable\" class=\"div-mtable-row\">";
	//echo "<div class=\"div-mtable-col\">";
	//echo "</div>";
	for ($c = 0; $c < 12; $c++) {
		if ($m < 128) {
			echo "<div name=\"$m\" scale_index=\"$m\" class=\"div-mtable-col note\">$m</div>";
			$m++;
		}
	}
	if ($r<10) echo "<BR>";
	//echo "</div>";
}
?>
</div>
</div>
    
<BR>
<div id='response'></div>
</body> 
</html>