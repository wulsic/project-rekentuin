var tmpMemory = [];
console.log(tmpMemory);
function send() {
	var form = $("form"),
		term = form.find('input[name="gebruikersNaam"]').val();
			$("#startpagina").fadeOut("slow", function(){
				$("#groepen").children("h1:first-child").text("hallo " + term);
				$("#groepen").fadeIn("slow").css("display", "inline-flex");
			});
	    $.ajax({
           type: "POST",
           url: "tweeGetallen.php",
           data: {functions: "gebruikersNaam", gebruikersNaam: term}
         });
	event.preventDefault();
}
function groepen(groep){
	tmpMemory[0] = groep;
	$("#groepen").fadeOut("slow", function(){
		$("#operators").fadeIn("slow").css("display", "inline-flex");
	});	
}
function operators(operator){
	tmpMemory[1] = operator;
	assignmentGenerator();
	$("#operators").fadeOut("slow", function(){
		$("#opdrachten").fadeIn("slow").css("display", "inline-flex");
	});
}
function assignmentGenerator(){
	var antwoord = $("#opdrachten").find('input[name="antwoord"]').val();
	$.ajax({
           type: "POST",
           url: "tweeGetallen.php",
           data: {functions: "opdrachtGenerator", groep: tmpMemory[0], operator: tmpMemory[1], antwoord: antwoord},
           success: function(data)
           {
			$("#opdrachten").children("form").children("h1").fadeOut("slow", function(){
				$("#opdrachten").children("form").children("h1").text(data).fadeIn("slow");
			});
            console.log(data);
           }
    });
	
}
function answerSend(){
		var antwoord = $("#opdrachten").find('input[name="antwoord"]').val();
		console.log(antwoord);
		$.ajax({
           type: "POST",
           url: "tweeGetallen.php",
           data: {functions: "antwoord", antwoord: antwoord, operator: tmpMemory[1]},
		   dataType: "JSON",
		   success: function(data)
           {
            console.log(data);
			if (data[1] == true) {
				// ToDo: Popup here.
			}
			if (data[0] == 20){
					$("#opdrachten").fadeOut("slow");
				// ToDo: A way to itterate the session : opdrachtOpslaan. Couple possible ways: Javascript or PHP function call via javascript.
			}
			assignmentGenerator();
           }
         });
		event.preventDefault();
}