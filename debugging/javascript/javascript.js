$( "document" ).ready(function() {
  $("#startpagina").fadeIn("slow").css("display", "inline-flex");
});
var tmpMemory = [];
console.log(tmpMemory);
var index = 0;

function send() {
	var form = $("form"),
		term = form.find('input[name="gebruikersNaam"]').val();
	    $.ajax({
           type: "POST",
           url: "tweeGetallen.php",
           data: {functions: "gebruikersNaam", gebruikersNaam: term},
		   success: function(data){
			$("#startpagina").fadeOut("slow", function(){
				$("#groepen").children("h1:first-child").text("hallo " + data);
				$("#groepen").fadeIn("slow").css("display", "inline-flex");
			});
		   }
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
	$("#operators").fadeOut("slow", function(){
		$("#opdrachtenSelectie").fadeIn("slow").css("display", "inline-flex");
	});
}
function assignmentGenerator(index){
	$.ajax({
           type: "POST",
           url: "tweeGetallen.php",
           data: {functions: "opdrachtGenerator", indexNumber: index, groep: tmpMemory[0], operator: tmpMemory[1]},
		   dataType: "text",
           success: function(data)
           {
            console.log(data);
			if ($("#opdrachtenSelectie").css("display") == "none"){
				$("#opdrachten").children("form").children("h1").fadeOut("slow", function(){
					$("#opdrachten").children("form").children("h1").text(data).fadeIn("slow");
				});
			}
			else {
				$("#opdrachtenSelectie").fadeOut("slow", function(){
					$("#opdrachten").children("form").children("h1").text(tmpMemory[3]);
					$("#opdrachten").fadeIn("slow").css("display", "inline-flex");
				});
			}
			tmpMemory[3] = data;
           }
    });
}
function select(index){
	tmpMemory[2] = index;
	console.log(tmpMemory[2])
	console.log(index);
	assignmentGenerator(tmpMemory[2]);
}
function answerSend(){
		var antwoord = $('input[name="antwoord"]').val();
		console.log(tmpMemory[2]);
		console.log(antwoord);
		$.ajax({
           type: "POST",
           url: "tweeGetallen.php",
           data: {functions: "antwoord", indexNumber: tmpMemory[2], antwoord: antwoord, operator: tmpMemory[1]},
		   dataType: "JSON",
		   success: function(data)
           {
            console.log(data);
			console.log(data.length);
			if (tmpMemory[2] == 20){
				results();
			}
			else {
			tmpMemory[2] += 1;
			}
			assignmentGenerator(tmpMemory[2]);
			$('input[name="antwoord"]').val("").focus();
           }
         });
		event.preventDefault();
}
function results(){
	$.ajax({
           type: "POST",
           url: "tweeGetallen.php",
           data: {functions: "results"},
		   //dataType: "JSON",
		   success: function(data)
           {
            console.log(data);
           }
         });
}