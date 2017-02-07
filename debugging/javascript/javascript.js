// Section 1 - Variables.
	// Section 1.1 - Temporary Memory aka a Temporary save storage for one variable.
var tmpMemory;
// Section 1 - END

// Section 2 - On DOM (page) ready.
$(document).ready(function(){
	// Section 2.1 - Fade in
	$("#startpagina").fadeIn("slow").css("display", "inline-flex");
	// Section 2.2 - Form submit
	$("form").submit(function(){
		event.preventDefault(); // Prevent a default action on submit.
		post($(this).find("input[name='input']").val()); // send the val of the set input to function post.			
	});
	// Section 2.3 - On button click
	$("button").click(function(){
		if ($(this).attr("class") == "backwards"){
			if (tmpMemory == "Toets"){
				$("#uitslag").fadeOut("slow", function(){
					fadeAnimation("#opdrachten", "#operators");				
				});
			}
			else {
				previous();
			}
		}
		// Section 2.3.1 - Popup
		else if ($(this).attr("class") == "popup"){
			modal($(this).attr("id"));
		}
		else if ($(this).text() == "Nee"){
			null
		}
		else {
			post($(this).text());
			tmpMemory = $(this).text();
		}
	});
});
// Section 2 - END

// Section 3 - Function previous. Fade out from current page to fade in the previous page from the hierarchy. Refer to html page for the hierarchy.

//Function - pageVisibility checks whether the 1 given argument page is visible or not
function pageVisibility(id1){
	var text = $(id1).css("display") != "none";
	return text;
}

//Function - fadeAnimation manages the transition between the 2 given arguments
function fadeAnimation(id1, id2){
	$(id1).fadeOut("slow", function(){
		$(id2).fadeIn("slow");
	});
}

function previous(){
	if (pageVisibility("#operators")){
		fadeAnimation("#operators", "#groepen");
	}
	else if (pageVisibility("#opdrachtenSelectie")){
		fadeAnimation("#opdrachtenSelectie", "#operators");
	}
	
	else if (pageVisibility("#opdrachten")){
		fadeAnimation("#opdrachten", "#opdrachtenSelectie");
	}
	else if (pageVisibility("#uitslag")){
		fadeAnimation("#uitslag", "#opdrachtenSelectie")
	}
}
// Section 3 - END

// Section 4 - username verfications.
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
// Section 4 - END

// Section 5 - Popup function modal()
function modal(id, som, uitkomst, antwoord, foutofGoed, naam){
	var text = "";
	var modal = ("#" + id + "modal");
	ifEresults = (id == "eResults") ? $("#alreadyMademodal").children(".modal-content").children("span").css("display", "block") : $("#alreadyMademodal").children(".modal-content").children("span").css("display", "none");
	ifEresults2 = (id == "eResults") ? $("#alreadyMademodal").children(".modal-content").children("button").css("display", "none") : $("#alreadyMademodal").children(".modal-content").children("button").css("display", "inline-block");
	if (som != null){
		if (id == "response"){
			if (foutofGoed == "fout"){
				text = "<p>Jammer, " + naam + " jouw antwoord is niet goed. " + som + " = " + uitkomst + "</p>";
			}
			else {
				text = "<p>Ja, "+ naam + " jouw antwoord is goed! " + som + " = " + uitkomst + "</p>" ;							
			}			
		}
		else if (id == "alreadyMade"){
			text =  "<p> Je hebt deze som al gemaakt </p>"+
					"<p> Het som was: </p>" +
					"<p>" + som + " = " + uitkomst + "</p>" +
					"<p> Jouw antwoord was: </p>" +
					"<p>" + antwoord + "</p>" +
					"<p> wil je deze som opnieuw maken? </p>";
		}
		$(modal).children(".modal-content").children("span").after(text);
	}
	else {
		if (id == "testAlreadymade") {
			text =  "<p> Je hebt deze toets al gemaakt </p>"+
					"<p> wil je deze toets opnieuw maken? </p>";
		}
		else if (id == "eResults") {
			text = "<p> Je hebt nog geen resultaten. </p>";
		}
		ifTestalreadyMade = ($("#opdrachtenSelectie").css("display") != "none") ?  $(modal).children(".modal-content").children("span").after(text) : $(modal).children(".modal-content").prepend(text); 	
	}
	
	$(modal).fadeIn("fast");
	$(".close, #yesOrno, #testResults").click(function() {
		$("input[name='input'], input[type='submit']").prop('disabled', false);
		$(modal).fadeOut("fast", function(){
			whenNotremove = ($("#startpagina").css("display") != "none") ? null : $(modal).children(".modal-content").children("p").remove();				
			var somEnuitkomst = som + " = " + uitkomst;
		});
	});
}
// Section 5 - END

// Section 6 - Submit form replacement. POST using AJAX.
function post(val) {
	var success = "";  // Reset success va 	riable
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
		
		With ternary operator it looks like:
		dataSend {
			postName : (condition) ? (postValue for YES) : (postValue for NO)
		}
		dataType: (condition) ? (html, text or JSON for YES) : (html, text or JSON for NO).
		
		on successfull AJAX response:
		success = (condition) ? (code for YES) : function success(any name for data from PHP){
			Your executions after a successfull AJAX response, like a page fade in or out.
		}
		
		anything with e infront of it is short version for empty. Like: eResults ; emptyResults
		
	}*/
	
	if (pageVisibility("#startpagina")){
		$("input[name='input'], input[type='submit']").prop('disabled', true);
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
	if (pageVisibility("#groepen")){
		dataSend = {
			functions: "group", 
			group: val.replace(/[^0-9]/g, "")
		}
		success = function success(){
			fadeAnimation("#groepen", "#operators");
		}
	}
	if (pageVisibility("#operators")){
		$("input[name='input'], input[type='submit']").prop('disabled', false);
		if (val == ":"){
			var val = val.replace(":", "/");
		}
		else if (val == "x"){
			var val = val.replace("x", "*");
		}
		dataSend = {
			functions: (val == "Ja") ? "delete" : "callRekundigeoperator",
			operator: (val == "Ja") ? null : val
		}
		dataType = (val == "Toets" || val == "Ja") ? "JSON" : "text";
		success = function success(data){
			if (data == "true") {
				modal("testAlreadymade");
			}
			else {
				$("#operators").fadeOut("slow", function(){
					if (val == "Toets" || val == "Ja"){
						if (val == "Ja") {
							tmpMemory = "Toets";
						}
						$("#opdrachten").children("form").children("h1").text(data.replace(/\"/g, ""));
						$("#opdrachten").fadeIn("slow").css("display", "inline-flex");
						$("input[name='input']").val(null).focus();
					}
					else if (val == "Resultaten"){
						tmpMemory = "Toets";
						$("#uitslag").children("table").remove();
						$("#uitslag").append(data);
						$("#uitslag").fadeIn("slow");
					}
					else {
						$("#opdrachtenSelectie").fadeIn("slow").css("display", "inline-flex");
					}
				});				
			}
		}
	}
	if (pageVisibility("#opdrachtenSelectie")){
		if (val == "Resultaten"){
			dataSend = {
				functions: "callResultpage"
			}
			success = function success(data){
				if (data == "eResults"){
					modal("eResults");
				}
				else {
					$("#opdrachtenSelectie").fadeOut("slow", function(){
						$("#uitslag").children("table").remove();
						$("#uitslag").append(data);
						$("#uitslag").fadeIn("slow");
					});	
				}
			}
		}
		else {
			dataSend = {
				functions: (val == "Ja" || val == "Opnieuw beginnen") ? "delete" : "callindexCheckerandGenerator",
				index: (val == "Toets") ? null : (val == "Ja") ? tmpMemory : val
			}
			dataType = "JSON";
			success = (val == "Opnieuw beginnen") ? null : function success(data){
				if (data[0] == "true") {
					modal("alreadyMade", data[1][0], data[1][2], data[1][3]);
				}
				else {
					$("#opdrachtenSelectie").fadeOut("slow", function(){
						$("#opdrachten").children("form").children("h1").text(data.replace(/\"/g, ""));
						$("#opdrachten").fadeIn("slow").css("display", "inline-flex");
						$("input[name='input']").val(null).focus();
					});
				}
			}
		}
	}
	if (pageVisibility("#opdrachten")){
		dataSend = {
			functions: "callControlsaveAndassignmentGenerator",
			antwoord: val
		}
		dataType = "JSON";
		success = function success(data){
			$("input[name='input'], input[type='submit']").prop('disabled', true);
			if (data[0] == "eNumber"){
				$("#opdrachten").fadeOut("slow", function(){
					$("#uitslag").children("table").remove();
					$("#uitslag").append(data[1]);
					$("#uitslag").fadeIn("slow");
				});
			}
			else {
				ifToets = (tmpMemory == "Toets") ? null : modal("response", data[0],data[1], data[2], data[3], data[4]) ;
				$('input[name="input"]').val(null);
				$("#opdrachten").children("form").children("h1").fadeOut("fast", function(){
					ifToets2 = (tmpMemory == "Toets") ? $("input[name='input'], input[type='submit']").prop('disabled', false) : null;
					ifToets4 = (tmpMemory == "Toets") ? $("input[name='input']").val(null).focus() : null;
					$("#opdrachten").children("form").children("h1").text(ifToets = (tmpMemory == "Toets") ? data : data[5]).fadeIn("fast");
				});
			}
		}
	}
	if ($("#uitslag").css("display") != "none"){
		dataSend = {
			functions: "results",
		}
		success = function success(data){
			$("#uitslag").append(data);				
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


