// Global Section 1 - Variables.
	// Section 1 - Text for the Pop up (subject to change).
var aboutSchool = "Text over school";
var explainPage = "Text over uitleg";
	// Section 2 - Temporary Memory aka a Temporary save storage for one variable.
var tmpMemory;
// Global Section 1 - END

// Global Section 2 - On DOM (page) ready.
$(document).ready(function(){
	// Section 1 - Fade in
	$("#startpagina").fadeIn("slow").css("display", "inline-flex");
	// Section 2 - Form submit
	$("form").submit(function(){
		event.preventDefault(); // Prevent a default action on submit.
			post($(this).find("input[name='input']").val()); // send the val of the set input to function post.			
	});
	// Section 3 - On button click
	$("button").click(function(){
		if ($(this).attr("class") == "backwards"){
			if (tmpMemory == "Toets"){
				$("#uitslag").fadeOut("slow", function(){
					$("#opdrachten").fadeOut("slow", function(){
						$("#operators").fadeIn("slow");
					});				
				});
			}
			else {
				previous();
			}
		}
		//popup modal
		else if ($(this).attr("class") == "popup"){
			modal($(this).attr("id"));
		}
		else {
			post($(this).text());
			tmpMemory = $(this).text();
		}
	});
});
// Global Section 2 - END

// Global Section 3 - Function previous. Fade out from current page to fade in the previous page from the hierarchy. Refer to html page for the hierarchy.
function previous(){
	if ($("#operators").css("display") != "none"){
		$("#operators").fadeOut("slow", function(){
			$("#groepen").fadeIn("slow");
		});
	}
	else if ($("#opdrachtenSelectie").css("display") != "none"){
		$("#opdrachtenSelectie").fadeOut("slow", function(){
			$("#operators").fadeIn("slow");
		});
	}
	else if ($("#opdrachten").css("display") != "none"){
		$("#opdrachten").fadeOut("slow", function(){
			$("#opdrachtenSelectie").fadeIn("slow");
		});
	}
	else if ($("#uitslag").css("display") != "none"){
		$("#uitslag").fadeOut("slow", function(){
			$("#opdrachtenSelectie").fadeIn("slow");
		});
	}
}
// Global Section 3 - END

// Global Section 4 - username verfications.
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
// Global Section 4 - END

// Global Section 5 - Popup function modal()
function modal(id, som, uitkomst, antwoord, foutofGoed, naam){
	var text = "";
	if (id == "assignment"){
		if (foutofGoed == "fout"){
			text = "<p>Jammer, " + naam + " jouw antwoord is niet goed. " + som + " = " + uitkomst + "</p>";
		}
		else {
			text = "<p>Ja, "+ naam + " jouw antwoord is goed! " + som + " = " + uitkomst + "</p>" ;							
		}		
	}
	else {
		if (id == "uitleg"){
			text = aboutSchool
		}
		else if (id == "over")(
			text = explainPage
		)		
	}
	$("body").children(".modal").remove();
	$("body").append("<div class='modal'>" +
					"<div class='modal-content'>" +
						"<span class='close'>&times;</span>" +
							"<p>" + text + "</p>" +
					"</div>" +
				   "</div>");
	$(".modal").fadeIn("fast");
	$(".close").click(function() {
		$(".modal").fadeOut("fast");
		$('input[name="input"]').val("").focus();
	});
}
// Global Section 5 - END

//Global Section 6 - Submit form replacement. POST using AJAX.
function post(val) {
	var success = "";  // Reset success variable
	var dataType = ""; // Reset dataType variable
	var dataSend = ""; // Reset dataSend variable
	
	/* Everything from here on follows simple hierarchy:
	if (the current page is displayed is true) {
		dataSend {
			postName : postValue
		}
		dataType: html, text or JSON (refer to jquery for more).
		
		on successfull AJAX response:
		success = function success(any name for data from PHP){
			Your executions after a successfull AJAX response, like a page fade in or out.
		}
	}*/
	
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
				$("#operators").fadeOut("slow", function(){
					ifToets = (val == "Toets") ? $("#opdrachten").children("form").children("h1").text(data) : null;
					ifToets2 = (val == "Toets") ? $("#opdrachten").fadeIn("slow").css("display", "inline-flex") : $("#opdrachtenSelectie").fadeIn("slow").css("display", "inline-flex");
					ifToets3 = (val == "Toets") ? $('input[name="input"]').val(null).focus() : null;
				});
		}
	}
	if ($("#opdrachtenSelectie").css("display") != "none"){
		if (val == "Resultaten"){
			$("#opdrachtenSelectie").fadeOut("slow", function(){
				$("#uitslag").children("table").remove();
				$("#uitslag").fadeIn("slow");
				post(null);
			});
		}
		else {
			dataSend = {
				functions: (val == "Opnieuw beginnen") ? "delete" : "callAssignmentindexCheckerandGenerator",
				index: val
			}
			dataType: "text";
			success = (val == "Opnieuw beginnen") ? null : function success(data){
				if (data == true){
					alert("Opdracht gemaakt");
				}
				else {
					$("#opdrachtenSelectie").fadeOut("slow", function(){
						$("#opdrachten").children("form").children("h1").text(data);
						$("#opdrachten").fadeIn("slow").css("display", "inline-flex");
						$('input[name="input"]').val(null).focus();
					});
				}
			}
		}
	}
	if ($("#opdrachten").css("display") != "none"){
		dataSend = {
			functions: "callControlsaveAndassignmentGenerator",
			antwoord: val
		}
		dataType = (tmpMemory == "Toets") ? "text" : "JSON";
		success = function success(data){
				if (data == true){
					$("#opdrachten").fadeOut("slow", function(){
						$("#uitslag").children("table").remove();
						$("#uitslag").fadeIn("slow");
						post(null);
					});
				}
				else {
					console.log(data);
					ifToets = (tmpMemory == "Toets") ? null : modal("assignment", data[0],data[1], data[2], data[3], data[4]) ;
					$("#opdrachten").children("form").children("h1").fadeOut("fast", function(){
						$("#opdrachten").children("form").children("h1").text(ifToets = (tmpMemory == "Toets") ? data : data[5]).fadeIn("fast");
					});
					ifToets2 = (tmpMemory == "Toets") ? $('input[name="input"]').val("").focus() : $('input[name="input"]').val("");
				}
		}
	}
	if ($("#uitslag").css("display") != "none"){
		dataSend = {
			functions: "results",
		}
		success = function success(data){
			if ($("#uitslag").children("table").length == 0){
				$("#uitslag").append(data);				
			}
		}
	}
	$.ajax({
	   type: "POST",
	   url: "ajax.php", // The url where the post is going to be send and the response orginate.
	   data: dataSend,
	   dataType: dataType,
	   success: success
	});
}


