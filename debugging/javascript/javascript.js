// Section 1 - Variables.
	// Section 1.1 - Temporary Memory aka a Temporary save storage for one variable.
	var tmpMemory;
	
	//Section 1.2 - Minutes / Seconds
	var minutes = 30;
    var aMinutes = 2; // assignment minutes. Time limit per assignments
	var seconds = 0;

	// Section 1.3 - Initialization multiple variables and functions for each ID in the hierachy of index.php
	var myFunctions = {
		"startpagina": {
			dataSend:
			function(val){
				dataSend = {
					functions: "callLoginsystem",
					username: val
				};
				return dataSend;
			},
			success: function(data) {
				$("#groepen").children("h1:first-child").text("hallo " + data);
			}
		},
		"groepen": {
			dataSend:
			function(val){
				dataSend = {
					functions: "group", 
					group: val.replace(/[^0-9]/g, ""),
				};
			return dataSend;
			}
		},
		"operators": {
			dataSend:
			function(val){
				if (val == ":"){
					var val = val.replace(":", "/");
				}
				else if (val == "x"){
					var val = val.replace("x", "*");
				};
				dataSend = {
					functions: (val == "Ja") ? "delete" : "callRekundigeoperator",
					operator: (val == "Ja") ? null : val
				};
			return dataSend;
			}
		},
		"opdrachtenSelectie": {
			dataSend:
			function(val){
				dataSend = {
					functions: (val == "Ja" || val == "Opnieuw beginnen") ? "delete" : (val == "Resultaten") ? "callResultpage" : "callindexCheckerandGenerator",
					index: (val == "Ja") ? tmpMemory : (val == "Resultaten") ? null : val
				};
			return dataSend;
			},
			success: 
			function(data) {
					ifTimerexist = (pageVisibility("#timer")) ? $("#timer").css("display", "none") : null;
					$("#opdrachten").children("form").children("h1").text(data.replace(/\"/g, ""));
					$("input[name='input']").val(null).focus();
			}
		},
		"opdrachten": {
			dataSend:
			function(val){
				dataSend = {
					functions: "callControlsaveAndassignmentGenerator",
					antwoord: val
				};
			return dataSend;
			},
			success:
			function(data){
				ifToets = (tmpMemory == "Toets" || tmpMemory == "Oefentoets" || tmpMemory == "oefentoets" ) ? null : modal("opdrachten", null, data[1]) ;
				$("#opdrachten").children("form").children("h1").fadeOut("fast", function(){
					ifToets2 = (tmpMemory == "Toets" || tmpMemory == "Oefentoets" || tmpMemory == "oefentoets") ? $("input[name='input'], input[type='submit']").prop('disabled', false) : null;
					ifToets4 = (tmpMemory == "Toets" || tmpMemory == "Oefentoets" || tmpMemory == "oefentoets") ? $("input[name='input']").val(null).focus() : null;
					$("#opdrachten").children("form").children("h1").text(ifToets = (tmpMemory == "Toets") ? data : data[0]).fadeIn("fast");
				});
			}
		},
	};
// Section 1 - END

// Section 2 - On DOM (page) ready.
$(document).ready(function(){
	// Section 2.1 - Append timer to id="Opdrachten"
	$("#opdrachten").children("button").after("<p id='timer'> Tijd : " + ("00" + minutes).substr(-2) + ":" + ("00" + seconds).substr(-2) +"</p>");
	// Section 2.1 - Fade in
	$("#startpagina").fadeIn("slow").css("display", "inline-flex");
	// Section 2.2 - Form submit
	$("form").submit(function(){
		event.preventDefault(); // Prevent a default action on submit.
		$("input[name='input'], input[type='submit']").prop('disabled', true);
		post($(this).find("input[name='input']").val(), $(this).parent().attr("id")); // send the val of the set input to function post.			
	});
	// Section 2.3 - On button click
	$("button").click(function(){
		if ($(this).attr("class") == "backwards"){
			if ($(this).parent().attr("id") == null){
				id = $(this).parent().parent().attr("id");
			}
			else {
				id = $(this).parent().attr("id");	
			}
			$("#" + id).fadeOut("slow", function(){
				console.log(tmpMemory);
				id = (tmpMemory == "Toets") ? "opdrachtenSelectie" : (id == "uitslag") ? "opdrachten" : id;
				$($("#" + id).prev()).fadeIn("slow").css("display", "inline-flex");
			});
		}
		else if ($(this).attr("id") == "over" || $(this).attr("id") == "uitleg"){
			modal($(this).attr("id"));
		}
		else if ($(this).text() != "Nee") {
			if ($(this).parent().parent().attr("id") == null || $(this).parent().parent().attr("class") == "modal"){
				parentId = $(this).parent().parent().parent().attr("id");
			}
			else {
				parentId = $(this).parent().parent().attr("id");			
			}
			getText = $(this).text();
			ifJa = (getText == "Ja" || (pageVisibility("#operators") && getText == "Resultaten")) ? null : tmpMemory = $(this).text();
			post(getText, parentId);
		}
	});
});
// Section 2 - END

// Section 3 - pageVisibility checks whether the 1 given argument page is visible or not
function pageVisibility(id1){
	var text = $(id1).css("display") != "none";
	return text;
}
// Section 3 - END

// Section 4 - create table for the results page.

function createTable(id1, table){
	$("#" + id1).fadeOut("slow", function(){
		$("#uitslag").children("p").remove();
		$("#uitslag").children("br").remove();
		$("#uitslag").children("table").remove();
		$("#uitslag").append(table);
		$("#uitslag").fadeIn("slow");
	});
}
// Section 4 - END

// Section 5 - username verfications.
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
// Section 5 - END

// Section 6 - Time limit for the user making a test.
function loopIniator(val){
	minutes = 30;
	seconds = 0;
	ifLoop = (typeof(timeLimitloop) == "undefined") ? null : clearTimeout(timeLimitloop);
	countDownloop();
}
function countDownloop(){
	seconds--;
	if (seconds <= 0 && minutes != 0){
		seconds = 59;
		minutes--
	}
	if (minutes == 0 && seconds == 0){
		clearTimeout(timeLimitloop);
		post("Toets", "operators");
	}
	else {
		timeLimitloop = setTimeout(countDownloop, 1000);	
	}
	$("#timer").text("Tijd : " + ("00" + minutes).substr(-2) + ":" + ("00" + seconds).substr(-2));
}
function testAtimeLimit(){ //  Time limit per assignments
}
// Section 6 - END

// Section 7 - Popup function modal()
function modal(id, val, text){

	//  Section 7.1 - Set variables
	var modal = $("#" + id + "modal");
	var modalId = document.getElementById(id + "modal");
	var closeDelay = 2000; // 2 second delay
	
	// Section 7.2 - Enable / Disable X button or yes and no button	
	ifEresults  = (pageVisibility("#startpagina") || val == "Resultaten" || val == "Opnieuw beginnen" || id == "opdrachten" || tmpMemory == "Oefentoets") ? modal.children(".modal-content").children("span").css("display", "block")  : modal.children(".modal-content").children("span").css("display", "none");
	ifEresults2 = 				(val == "Resultaten" || val == "Opnieuw beginnen" || id == "opdrachten" || tmpMemory == "Oefentoets")				      ? modal.children(".modal-content").children("button").css("display", "none") : modal.children(".modal-content").children("button").css("display", "inline-block");
	
	// Section 7.3 - Set text when it's id is not the same as over and uitleg
	if (id != "over" && id != "uitleg"){
		$("input[name='input']").val(null);
		ifTestalreadyMade = (pageVisibility("#opdrachtenSelectie") || pageVisibility("#opdrachten")) ?  modal.children(".modal-content").children("span").after(text) : modal.children(".modal-content").prepend(text);
		if (pageVisibility("#opdrachten") || pageVisibility("#operators") || val == "Resultaten" || val == "Opnieuw beginnen" || tmpMemory == "Oefentoets" ){
			if (typeof(pClosedelay) != "undefined"){
				clearTimeout(pClosedelay);
			}
			pClosedelay = setTimeout(closeAnswerModal, closeDelay); // pClosedelay = Popup close delay.
		}
	}
	// Section 7.4 - Popup fade in
	modal.fadeIn("fast");
	
	// Section 7.5 - Close modal onclick + remove p when startpagina is not active.
	function closeAnswerModal() {
		$("input[name='input'], input[type='submit']").prop('disabled', false);
		modal.fadeOut("fast", function(){
			whenNottoRemove = (pageVisibility("#startpagina")) ? null : modal.children(".modal-content").children("p").remove();
		});
		$("input[name='input']").focus();
	}
	
	$(".close, #yesOrno, #testResults").click(function(){
		closeAnswerModal();
	});
	
	/*$(document).keyup(function(e) {
		if (e.keyCode==13){
			$(modalId).hide();
		}
	})*/
}
// Section 7 - END

// Section 8 - Submit form replacement. POST using AJAX.
function post(val, id) {
	$.ajax({
	   type: "POST",
	   url: "ajax.php", // The url where the post is going to be send and the response orginate.
	   data: myFunctions[id].dataSend(val, id),
	   dataType: (id == "opdrachtenSelectie" || id == "opdrachten" || val == "Resultaten" || val == "Toets") ? "JSON" : "text",
	   success: function(data){
		   if (data[0] == "popup"){
			   tmpMemory = (data[2] == null) ? tmpMemory : data[2];
			   modal(id, val, data[1]);
		   }
		   else if (data[0] == "table"){
			   createTable(id, data[1]);
		   }
		   else {
			   fadeAnimation(id, val, data);	   
		   }
	   }
	});
}

function fadeAnimation(id1, val, data){
	if (id1 == "opdrachten") {
		myFunctions[id1].success(data);
	}
	else {
		$("input[name='input'], input[type='submit']").prop('disabled', true);
		$("#" + id1).fadeOut("slow", function(){
			$("input[name='input'], input[type='submit']").prop('disabled', false);
			if (val == "Toets" || val == "Ja" && id1 != "opdrachtenSelectie"){
				$("#timer").css("display", "inline-block");
				if (val == "Ja") {
					tmpMemory = "Toets";
				}
				
				$("#opdrachten").children("form").children("h1").text(data.replace(/\"/g, ""));
				loopIniator();
				$("#opdrachten").fadeIn("slow").css("display", "inline-flex");
				$("input[name='input']").val(null).focus();
			}
			else {
				ifFunction = (typeof(myFunctions[id1].success) == "function") ? myFunctions[id1].success(data) : null;
				$($("#" + id1).next()).fadeIn("slow").css("display", "inline-flex");
				ifStartpagina = (id1 == "groepen") ? null : $("input[name='input']").val(null).focus();
			}
		});
	}
}
// Section 8 - END