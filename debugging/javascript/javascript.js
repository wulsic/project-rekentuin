$(document).ready(function(){
	$("#startpagina").fadeIn("slow").css("display", "inline-flex");
	$("form").submit(function(){
		event.preventDefault();
		post($(this).find("input[name='input']").val());
	});

});
function post(val) {
	var dataType = "";
	
	if (val !== undefined || val !== null){
		$("button").click(function(){
		post($(this).text());
		})
	}

	if ($("#startpagina").css("display") != "none"){
		dataSend = {
			functions: "callLoginsystem",
			username: val
		}
		dataType = "text";
		success = function success(data){
			$("#startpagina").fadeOut("slow", function(){
				$("#groepen").children("h1:first-child").text("hallo " + data);
				$("#groepen").fadeIn("slow").css("display", "inline-flex");
			});
		}
	}
	if ($("#groepen").css("display") != "none"){
		dataSend = {
			functions: "group", 
			group: val.replace(/[^0-9]/g, "")
		}
		success = function success(){
			$("#groepen").fadeOut("slow", function(){
				$("#operators").fadeIn("slow").css("display", "inline-flex");
			});
		}
	}
	if ($("#operators").css("display") != "none"){
		if (val == ":"){
			var val = val.replace(":", "/");
		}
		else if (val == "x"){
			var val = val.replace("x", "*");
		}
		dataSend = {
			functions: "callRekundigeoperator", 
			operator: val
		}
		dataType = "text"
		success = function success(data){
			if (val == "Toets"){
				$("#operators").fadeOut("slow", function(){
					$("#opdrachten").children("form").children("h1").text(data);
					$("#opdrachten").fadeIn("slow").css("display", "inline-flex");
				});		
			}
			else {
				$("#operators").fadeOut("slow", function(){
					$("#opdrachtenSelectie").fadeIn("slow").css("display", "inline-flex");
				});
			}
		}
	}
	if ($("#opdrachtenSelectie").css("display") != "none"){
		dataSend = {
			functions: "callAssignmentindexCheckerandGenerator",
			index: val
		}
		//dataType = "JSON";
		success = function success(data){
			console.log(data);
				$("#opdrachtenSelectie").fadeOut("slow", function(){
				$("#opdrachten").children("form").children("h1").text(data);
				$("#opdrachten").fadeIn("slow").css("display", "inline-flex");
			});
		}
	}
	if ($("#opdrachten").css("display") != "none"){
		dataSend = {
			functions: "callControlsaveAndassignmentGenerator",
			antwoord: val
		}
		dataType = "JSON";
		success = function success(data){
			console.log(data);
			$("#opdrachten").children("form").children("h1").fadeOut("slow", function(){
				$("#opdrachten").children("form").children("h1").text(data[0]).fadeIn("slow");
			});
		$('input[name="input"]').val("").focus();
		}		
	}
	$.ajax({
	   type: "POST",
	   url: "tweeGetallen.php",
	   data: dataSend,
	   dataType: dataType,
	   success: success
	});
}
