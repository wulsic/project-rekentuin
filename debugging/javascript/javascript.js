$(document).ready(function(){
	$("#startpagina").fadeIn("slow").css("display", "inline-flex");
	$("form").submit(function(){
		event.preventDefault();
		post($(this).find("input[name='input']").val());
	});
	$("button").click(function(){
		post($(this).text());
	})
});
function post(val) {
	var dataType = "";
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
		else {
			if (val == "x"){
				var val = val.replace("x", "*");
			}
			else {
				if (val == "Toets"){
					var val = val.replace("Toets", "");
				}
			}
		}
		dataSend = {
			functions: "callRekundigeoperator", 
			operator: val
		}
		success = function success(){
					if (val == ""){
						$("#operators").fadeOut("slow", function(){
							assignmentGenerator(1);
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
		dataType = "JSON";
		success = function success(data){
					console.log(data);
					$("#opdrachtenSelectie").fadeOut("slow", function(){
						$("#opdrachten").children("form").children("h1").text(data[0]);
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
						$("#opdrachten").children("form").children("h1").text(data[1][0]).fadeIn("slow");
					});
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
