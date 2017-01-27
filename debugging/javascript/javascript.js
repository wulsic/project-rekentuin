var tmpMemory;
$(document).ready(function(){
	$("#startpagina").fadeIn("slow").css("display", "inline-flex");
	$("form").submit(function(){
		event.preventDefault();
		post($(this).find("input[name='input']").val());
	});
	$("button").click(function(){
		if ($(this).text() == "Ga terug" && tmpMemory == "Toets"){
			$("#opdrachten").fadeOut("slow", function(){
				$("#operators").fadeIn("slow");
			});
		}
		else if($(this).text() == "Ga terug"){
			previous(this);
		}
		else if ($("#startpagina").css("display") != "none"){
			//popup modal
			if ($(this).text() == "Over school"){
				modal("over");
			}
			else if ($(this).text() == "Klik hier voor uitleg :)"){
				modal("uitleg");
			}
		}
		else{
			console.log($(this).text()); 
			post($(this).text());
			tmpMemory = $(this).text();
		}
	});
});
function previous(val){
	if ($("#operators").find(val) && $("#operators").css("display") != "none"){
		$("#operators").fadeOut("slow", function(){
			$("#groepen").fadeIn("slow");
		});
	}
	else if ($("#opdrachtenSelectie").find(val) && $("#opdrachtenSelectie").css("display") != "none"){
		$("#opdrachtenSelectie").fadeOut("slow", function(){
			$("#operators").fadeIn("slow");
		});
	}
	else if ($("#opdrachten").find(val) && $("#opdrachten").css("display") != "none"){
		$("#opdrachten").fadeOut("slow", function(){
			$("#opdrachtenSelectie").fadeIn("slow");
		});
	}
	else if ($("#uitslag").find(val) && $("#uitslag").css("display") != "none"){
		$("#uitslag").fadeOut("slow", function(){
			$("#operators").fadeIn("slow");
		});
	}
}
function post(val) {
	var success = "";
	var dataType = "";
	var dataSend = "";
	
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
		dataType = "text";
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
		console.log(val);
		dataSend = {
			functions: "callAssignmentindexCheckerandGenerator",
			index: val
		}
		//dataType = "JSON";
		success = function success(data){
			console.log(data);
				if (data == true){
					alert("Opdracht gemaakt");
				}
				else {
					$("#opdrachtenSelectie").fadeOut("slow", function(){
						$("#opdrachten").children("form").children("h1").text(data);
						$("#opdrachten").fadeIn("slow").css("display", "inline-flex");
						$('input[name="input"]').val("").focus();
					});					
				}
		}
	}
	if ($("#opdrachten").css("display") != "none"){
		dataSend = {
			functions: "callControlsaveAndassignmentGenerator",
			antwoord: val
		}
		success = function success(data){
			console.log(data);
				if (data == true){
					$("#opdrachten").fadeOut("slow", function(){
						$("#uitslag").children("table").remove();
						post("");
						$("#uitslag").fadeIn("slow");
					});
				}
				else {
					console.log(data);
					$("#opdrachten").children("form").children("h1").fadeOut("fast", function(){
						$("#opdrachten").children("form").children("h1").text(data).fadeIn("fast");
					});
					$('input[name="input"]').val("").focus();			
				}
		}
	}
	if ($("#uitslag").css("display") != "none"){
		console.log("test");
		dataSend = {
			functions: "results",
		}
		success = function success(data){
			$("#uitslag").append(data);
			console.log(data);
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
function usernameVerify(txt) {
    if (txt.value == '') {
        txt.setCustomValidity('Vul je naam in');
    }
    else if(txt.validity.patternMismatch){
        txt.setCustomValidity('Gebruik alleen letters');
    }
    else {
        txt.setCustomValidity('');
    }
    return true;
}

function modal(name) {
	var modal = document.getElementById(name+"Modal");
	var btn = document.getElementById(name);
	var span = document.getElementsByClassName(name+"close")[0];
	modal.style.display = "block";

	span.onclick = function() {
		modal.style.display = "none";
	}

	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
}
