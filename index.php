<html> 
<head> 
<title>+++ Testing +++</title> 
<link rel="stylesheet" type="text/css" href="keys.css">
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<script src="./jquery.js"></script>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script type='text/javascript'>
$(document).ready(function(){ 
//$("#scale_results").slideUp(); 
    $("#generate_button").click(function(e){ 
        e.preventDefault(); 
        ajax_generate(); 
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
     $("#scale_results").html(data); 
   } 
  }) 
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

<input type="submit" value="Generate Scale" id="generate_button" /> 
</div> 
</form>
    <div id="scale_results"></div> 
    
<BR>
<div class=\"div-mtable\">
<div class=\"div-mtable-row\">
</div>
</div>
</body> 
</html>