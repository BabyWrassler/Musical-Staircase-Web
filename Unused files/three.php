<html> 
<head> 
<title>+++ Test +++</title> 
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="keys.css">
<script src="./jquery.js"></script>

<script>

/*
function chooseStarting(elmnt) {
    //elmnt.style.color = 'blue';
    $('.chosen').removeClass("chosen");
    elmnt.classList.add("chosen");
    var name = $(elmnt).attr('scale_index'); // name or scale_index...?
    $("#starting").val(name);
    create_scale();
    //console.log(name);
    //elmnt.classList.remove("unchosen");
}*/

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


function highlightScale() {
	$('[name="someval"]');

}

$(document).ready(function(){ 
create_scale();
//$("#scale_results").slideUp(); 
    $("#generate_button").click(function(e){ 
        e.preventDefault(); 
        //ajax_generate(); 
        create_scale();
    }); 
    $("#tonic_note").keyup(function(e){ 
        //console.log(parseInt($("#tonic_note").val()));
        if (parseInt($("#tonic_note").val()) < 0) $("#tonic_note").val(0);
	    if (parseInt($("#tonic_note").val()) > 127) $("#tonic_note").val(127);
        e.preventDefault();
        create_scale(); 
        //ajax_generate(); 
    }); 
    $('form').change(function(e){ 
        e.preventDefault();
        create_scale();
        //ajax_generate(); $("#scale").val();
    }); 
    $('form').click(function(e){ 
        e.preventDefault();
        create_scale();
        //ajax_generate(); 
    }); 
    $("#scale").change(function(e){ 
        e.preventDefault();
        $("#starting").val(0);
        create_scale();
        //ajax_generate(); $("#scale").val();
    }); 
    $("#scale").click(function(e){ 
        e.preventDefault();
        $("#starting").val(0);
        create_scale();
        //ajax_generate(); 
    }); 

});

/*function ajax_generate(){ 
  
  $("#scale_results").show();
  var note_val=$("#tonic_note").val();
  var scale_val = $("#scale").val();
  var starting_val=$("#select-result").val();
  var tonic_val=$("#tonic").val();
  //console.log(starting_val);
  $.post("./generate.php", {scale : scale_val, tonic_note : note_val, tonic : tonic_val, starting_note : starting_val}, function(data){
   if (data.length>0){ 
     //$("#scale_results").html(data); 
   } 
  }) 
} */

function underOneTwoEight(value) {
  return ((value < 128) && (value > -1));
}

function create_scale(){
	
	var alpha = ["C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G"];
	var octave = [-2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -2, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 8, 8, 8, 8, 8, 8, 8, 8];
	var scale_mask = [];
	var maxStartNote = 0;

	//$tonic_array = array();
	var tonic = parseInt($("#tonic").val());
	//console.log("Tonic: ");
	//console.log(tonic);
	var starting_note = parseInt($("#starting").val());
	//$starting_note = 0;
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
		//maxStartNote = 62;
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
		// Indian Scale MIDI intervals {0, 2, 3, 5, 7, 9, 10}
		scale_mask = [1,0,1,1,0,1,0,1,0,1,1,0]; 
		notes_in_scale = 7; 
		break;
	case "locrian":
		// Indian Scale MIDI intervals {0, 1, 3, 5, 6, 8, 10}
		scale_mask = [1,1,0,1,0,1,1,0,1,0,1,0]; 
		notes_in_scale = 7; 
		break;
	case "lydian":
		// Indian Scale MIDI intervals {0, 2, 4, 6, 7, 9, 10}
		scale_mask = [1,0,1,0,1,0,1,1,0,1,1,0]; 
		notes_in_scale = 7; 
		break;
	case "melodic_minor":
		// Scale MIDI intervals {0, 2, 3, 5, 7, 8, 9, 10, 11}
		scale_mask = [1,0,1,1,0,1,0,1,1,1,1,1]; 
		notes_in_scale = 9; 
		break;
	case "mixolydian":
		// Indian Scale MIDI intervals {0, 2, 4, 5, 7, 9, 10}
		scale_mask = [1,0,1,0,1,1,0,1,0,1,1,0]; 
		notes_in_scale = 7; 
		break;
	case "natural_minor":
		// Indian Scale MIDI intervals {0, 2, 3, 5, 7, 8, 10}
		scale_mask = [1,0,1,1,0,1,0,1,1,0,1,0]; 
		notes_in_scale = 7; 
		break;
	case "phrygian":
		// Indian Scale MIDI intervals {0, 1, 3, 5, 7, 8, 10}
		scale_mask = [1,1,0,1,0,1,0,1,1,0,1,0]; 
		notes_in_scale = 7; 
		break;
	case "harmonic_minor":
		// Indian Scale MIDI intervals {0, 2, 3, 5, 7, 8, 11}
		scale_mask = [1,0,1,1,0,1,0,1,1,0,0,1];
		notes_in_scale = 7; 
		break;
	case "turkish":
		// Indian Scale MIDI intervals {0, 1, 3, 5, 7, 10, 11}
		scale_mask = [1,1,0,1,0,1,0,1,0,0,1,1]; 
		notes_in_scale = 7; 
		break;
	default:
		scale_mask = [1, 0, 1, 0, 1, 1, 0, 1, 0, 1, 0, 1]; // Major
		notes_in_scale = 7;
		//maxStartNote = 62;
	}
	
	/*var ii;
	for (ii=0; ii>12; ii++) {
		var log = scale_mask[ii];
		//console.log(log);
	}*/
	
	var treads = [];
	var scale_array = [];

	var octave_position = 0;
	var dist_from_tonic = 0;
	
	<?php
	//document.getElementById("chosen_starting").innerHTML = starting_note;
	//document.getElementById("chosen_tonic").innerHTML = tonic;
	//document.getElementById("chosen_scale").innerHTML = scale;
	?>
	
	var note = tonic;
	
	while (note < 140) {	
	//echo "$x $octave_position<BR>";
	if (scale_mask[octave_position] > 0) {
		scale_array[note] = tonic + dist_from_tonic;
		//echo "$note : ";
		//echo " $scale_array[$note] ";
		//var name = alpha[ scale_array[note] ];
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

var x=0;


/*
for (x=0; x<scale_array.length; x++) {
	var see = x + " : " + scale_array[x];
	console.log(see);
	
}*/

/*
for (x=0; x<128; x++) {
	//var dest = scale_array[(x)];
	//var src = (scale_array[x + notes_in_scale] -12); // was -12
	//var tmp = (dest.toString()).concat(" = ");
	//tmp = tmp.concat(src);
	//console.log(tmp);
	var tmp = (scale_array[x + (notes_in_scale)] - 12)
	//console.log(tmp);

	//if (tmp<127) {
		if ((Number.isInteger(tmp)) && (tmp<128)) {
			if (tmp > -1) {
				scale_array[x] = tmp;
				//console.log("Is number");
				//console.log(tmp);
			} else {
				scale_array.splice(x,1);
				//scale_array.shift();
				//console.log("splice");
			}
		}
	//}
}*/

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

//console.log(scale_array);
var scale_array = scale_array.filter(underOneTwoEight);
//console.log(scale_array);


var tread_to_fill = 0;
var scale_ind = 0;

var table_string = "";
table_string += "<div class=\"div-table\">";
table_string += "<div class=\"div-table-row\"> <div class=\"div-table-col\">Tread</div> <div class=\"div-table-col\">MIDI</div> <div class=\"div-table-col\">Note</div> <div class=\"div-table-col\">Octave</div> </div>";


while (tread_to_fill < 32) {	
	
	var blog = scale_array[(scale_ind + starting_note)];
	if (Number.isInteger(blog) && ((blog > -1) && (blog < 128)) ) {
		treads[tread_to_fill] = blog;
		
		//console.log("filling tread:");
		//console.log(blog);
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
//document.getElementById("scale_table").innerHTML = table_string;

	$('.tread').removeClass("tread");
	$('.first-tread').removeClass("first-tread");
	$('.note').attr("scale_index", 128);
	
	var $noteDiv
	for(var z=0; z<treads.length; z++) {
		// $('.scale').removeClass("scale");
		//console.log("[name='" + z + "']");
		//var comment = $("[name='" + treads[z] + "']");
		//console.log( comment );
		$noteDiv = $("[name='" + treads[z] + "']")[0];
		//console.log($noteDiv);
		$noteDiv.classList.add("tread");
		if (z == 0) $noteDiv.classList.add("first-tread");
		//$noteDiv.setAttribute("scale_index", z);
    	
    	//$("[name='" + treads[z] + "']")[0].classList.add("scale");
    	//$("[name='" + treads[z] + "']").attr("scale_index", z);
    	//$("[name='0']");
    	
    }
	
	var w=0;
	var n=0;
	
	/*$('.avail-start').removeClass("avail-start");
	for(w=0; w<treads.length; w++) {
		n = treads[w];
		//if((n > -1) && (n < 128)) {
			$noteDiv = $("[name='" + treads[w] + "']")[0];
			//$noteDiv.setAttribute("scale_index", w);
			$noteDiv.classList.add("avail-start");
			$noteDiv.setAttribute("onclick", "chooseStarting(this)");
		//}
	}*/
	
	
	$('.scale').removeClass("scale");
	$('.avail-start').removeClass("avail-start");
	
	//maxStartNote = scale_array.indexOf(127);
	var scale_array = scale_array.filter(underOneTwoEight);
	//console.log(scale_array);
	var max = Math.max.apply( Math, scale_array );
	//console.log(max);
    //maxStartNote = scale_array.indexOf(Math.max.apply( Math, scale_array )) - 31;
    //maxStartNote = (Math.max.apply( Math, scale_array ));
    maxStartNote = scale_array.length - 32;
    //console.log(maxStartNote);
    
	for(w=0; w<scale_array.length; w++) {
		//n = scale_array[w];
		//if((n > -1) && (n < 128)) {
			$noteDiv = $("[name='" + scale_array[w] + "']")[0];
			$noteDiv.setAttribute("scale_index", w);
			$noteDiv.classList.add("scale");
			//$noteDiv.setAttribute("onclick", "chooseStarting(this)");
			if (w <= maxStartNote) {
				$noteDiv.classList.add("avail-start");
//				$noteDiv.setAttribute("onclick", 'chooseStarting(this)');
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
		//console.log("cycle");
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
	
	prepTreads = {"0": "1", "1": "2"};

	var objTreads = {};
	for (t=0; t<treads.length; t++) {
		objTreads[("i" + t)] = treads[t];
	}
	console.log(objTreads);
	
	//var jsonTreads = JSON.stringify(treads);
	//var jsonTreads = JSON.stringify(prepTreads);
	//console.log(jsonTreads);
	
	$.post('postNotes.php', objTreads, function(data){	 
		// show the response
		$('#response').html(data);
	}).fail(function() {
		// just in case posting your form failed
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
    //document.getElementById("id01").innerHTML = out;
    console.log(out);
}

</script>


</head> 



<body> 
<h1 class="page-title"><span class="glyphicon glyphicon-music"></span> Musical Stairs Tread Assignments <span class="glyphicon glyphicon-music"></span></h1> 
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
<input type="submit" value="Generate Scale" id="generate_button" /> 
</div> 
</form>

<div id="scale_results"> </div> 
 
 
 
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



<?php
//<p id="feedback"><span id="scale_table">none</span><span id="chosen_tonic">none</span><span id="chosen_scale">none</span><span id="chosen_starting">none</span></p>
?>
<br>
<span class="scale-label">Step 1: Choose a scale<span class="glyphicon glyphicon-arrow-down" style="position:relative; top:10px; display:none;"></span></span>
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
<span class="tonic-label"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Step 2: Choose a tonic note</span>
</div>

<div class="div-note-table">

<?php
$m = 0;
for ($r = 0; $r < 11; $r++) {
	//echo "<div id=\"selectable\" class=\"div-mtable-row\">";
	//echo "<div class=\"div-mtable-col\">";
	//echo ($r - 2);
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
<span class="note-label"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Step 3: Choose an<br><span class="available-text">available</span> starting note<BR>for the bottom-most tread</span>

    
<BR>
<div class=\"div-mtable\">
<div class=\"div-mtable-row\">
</div>
</div>

<div id='response'></div>
</body> 
</html>