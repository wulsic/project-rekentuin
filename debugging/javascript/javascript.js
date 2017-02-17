// Section 1 - Variables.
	// Section 1.1 - Temporary Memory aka a Temporary save storage for one variable.
	var tmpMemory;
	
	//Section 1.2 - Minutes / Seconds
	var minutes;// Time limit for the test
	var seconds; // Time limit for the test
	var aMinutes; // assignment minutes. Time limit per assignments
	var aSeconds; // assignment seconds. Time limit per assignments
	
	// Section 1.3 - Initialize multiple variables and functions for each ID in the hierachy of index.php
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
					operator: (val == "Ja") ? tmpMemory : val
				};
			return dataSend;
			}
		},
		"opdrachtenSelectie": {
			dataSend:
			function(val){
				if (val == "Resultaten"){
					dataSend = {
						functions: "callResultpage"
					};
				}
				else {
					dataSend = {
							functions: (val == "Ja" || val == "Opnieuw beginnen") ? "delete" : "callindexCheckerandGenerator",
							index: (val == "Ja") ? tmpMemory : val
					};
				}
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
					loopInitiator("reset", null, null); // Reset assignment timer per assignment
					ifToets2 = (tmpMemory == "Toets" || tmpMemory == "Oefentoets" || tmpMemory == "oefentoets") ? $("input[name='input'], input[type='submit']").prop('disabled', false) : null;
					ifToets4 = (tmpMemory == "Toets" || tmpMemory == "Oefentoets" || tmpMemory == "oefentoets") ? $("input[name='input']").val(null).focus() : null;
					$("#opdrachten").children("form").children("h1").text(ifToets = (tmpMemory == "Toets" || tmpMemory == "Oefentoets") ? data : data[0]).fadeIn("fast");
				});
			}
		},
		"moveToassignment": {
			dataSend:
			function(){
				dataSend = {
					functions: "callTomoveAssignment",
					operator: $("#opdrachten").children("form").children("h1").text().replace(/[\w ]/g,"")
				};
			return dataSend;
			},
			success: null
		}
	};
// Section 1 - END

// Section 2 - On DOM (page) ready.
$(document).ready(function(){

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
			ifLoop  = (typeof(timeLimitloop) == "undefined") ? null : clearTimeout(timeLimitloop);
			if ($(this).parent().attr("id") == null){
				id = $(this).parent().parent().attr("id");
			}
			else {
				id = $(this).parent().attr("id");	
			}
			if ($("#" + id).prev().attr("id") == "opdrachtenSelectie" || $("#" + id).prev().attr("id") == "opdrachten") {
				post(null, "operators");
			}
			$("button").prop('disabled', true);
			$("#" + id).fadeOut("slow", function(){
				id 		  = (tmpMemory == "Toets") ? "opdrachtenSelectie" : (id == "uitslag") ? "opdrachten" : id;
				tmpMemory = (tmpMemory == "Toets") ? null : tmpMemory;
				$($("#" + id).prev()).fadeIn("slow").css("display", "inline-flex");
				$("button").prop('disabled', false);
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
		$("button").prop('disabled', false);
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
function loopInitiator(setOrreset = "set", setMinutes = 30, setSeconds = 0, setAminutes = 5, setAseconds = 0){
	if (setOrreset == "set" || setOrreset == "reset"){
		if (setMinutes != null && setSeconds != null){
			minutes  = setMinutes;// Time limit for the test
			seconds  = setSeconds; // Time limit for the test
		}
		aMinutes = setAminutes; // assignment minutes. Time limit per assignments
		aSeconds = setAseconds; // assignment seconds. Time limit per assignments
	}
	if (setOrreset == "set"){
		ifLoop  = (typeof(timeLimitloop) == "undefined") ? null : clearTimeout(timeLimitloop);
		countDownloop();		
	}
}
function countDownloop(){
	seconds--;
	aSeconds--;
	if (minutes != 0 && seconds <= 0){
		minutes--;
		seconds = 59;
	}
	if (aMinutes != 0 && aSeconds <= 0){
		aMinutes--;
		aSeconds = 59;
	}
	if (aMinutes == 0 && aSeconds <= 0){
		clearTimeout(timeLimitloop);
		var getAssignment = $("#opdrachten").children("form").children("h1").text().replace(/[\d ]/g,"");
		if (getAssignment == "+"){
			operatorText = "plus";
		}
		else if (getAssignment == "-") {
			operatorText = "min";
		}
		else if (getAssignment == "x") {
			operatorText = "keer";
		}
		else if (getAssignment == ":") {
			operatorText = "gedeelddoor";
		}
		text = "<p> Je hebt te lang over deze opdracht gedaan, je wordt nu doorverzonden naar opdrachten pagina, " + operatorText + "</p>";
		modal("opdrachten", "moveToassignment", text, 5000);
		console.log("call");
	}
	else if (minutes == 0 && seconds <= 0){
		clearTimeout(timeLimitloop);
		post("Toets", "operators");
	}
	else {
		timeLimitloop = setTimeout(countDownloop, 1000);	
	}
	$("#timer").text("Tijd: " + ("00" + minutes).substr(-2) + ":" + ("00" + seconds).substr(-2));
}
// Section 6 - END

// Section 7 - Popup function modal()
function modal(id, val, text, closeDelay = 2000){
	
	//  Section 7.1 - Set variables
	var modal = $("#" + id + "modal");
	var modalId = document.getElementById(id + "modal");
	
	// Section 7.2 - Enable / Disable X button or yes and no button
	if (pageVisibility("#startpagina") || val == "Resultaten" || val == "Opnieuw beginnen" || id == "opdrachten" || tmpMemory == "Oefentoets" || tmpMemory == "errorToets"){
		modal.children(".modal-content").children("span").css("display", "block");
	}
	else {
		modal.children(".modal-content").children("span").css("display", "none");
	}
	if (val == "Resultaten" || val == "Opnieuw beginnen" || val == "Opnieuw beginnen" || id == "opdrachten" || tmpMemory == "Oefentoets" || tmpMemory == "errorToets"){
		modal.children(".modal-content").children("button").css("display", "none");
	}
	else {
		modal.children(".modal-content").children("button").css("display", "inline-block");
	}
	
	// Section 7.3 - Popup fade in
	modal.fadeIn("fast", function(){
		$("button").prop('disabled', false);
	});
	
	// Section 7.4 - Set text when it's id is not the same as over and uitleg
	if (id != "over" && id != "uitleg"){
		console.log(tmpMemory);
		$("input[name='input']").val(null);
		ifTestalreadyMade = (pageVisibility("#opdrachtenSelectie") || pageVisibility("#opdrachten") || pageVisibility("#operators") ) ?  modal.children(".modal-content").children("span").after(text) : modal.children(".modal-content").prepend(text);
		if (pageVisibility("#opdrachten") || val == "Resultaten" || val == "Opnieuw beginnen" || tmpMemory == "Oefentoets" || tmpMemory == "errorToets" ){
			if (typeof(pClosedelay) != "undefined"){
				clearTimeout(pClosedelay);
			}
			pClosedelay = setTimeout(closeAnswerModal, closeDelay); // pClosedelay = Popup close delay.
		}
	}
	
	// Section 7.5 - Close modal onclick + remove p when startpagina is not active.
	function closeAnswerModal() {
		$("input[name='input'], input[type='submit']").prop('disabled', false);
		modal.fadeOut("fast", function(){
			if (val == "moveToassignment"){
				$("button").prop('disabled', true);
				post("moveToassignment", "moveToassignment");
			}
			else {
				$("button").prop('disabled', false);
			}
			whenNottoRemove = (pageVisibility("#startpagina")) ? null : modal.children(".modal-content").children("p").remove();
		});
		$("input[name='input']").focus();
	}
	
	$(".close, #yesOrno, #testResults").click(function(){
		closeAnswerModal();
	});
	
	window.onclick = function(event) {
		if (event.target == modalId) {
			closeAnswerModal();
	}}
	
	/*if (this === document.activeElement){
		$(document).keyup(function(e) {
			if (e.keyCode==13){
				$(modalId).hide();
			}
		})
	}*/


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
	   dataType: (id == "opdrachtenSelectie" || id == "opdrachten" || id == "operators" || val == "dynamicColours" || val == "Resultaten" || val == "Toets") ? "JSON" : "text",
	   success: function(data){
			ifOpdracht = (id == "opdracht") ? null : $("button").prop('disabled', true);
		   if (data[0] == "popup"){
				if (tmpMemory == "Opnieuw beginnen"){
					console.log($("#operators").children(".div-center").children("button:contains("+ data[2] +")"));
					$("#operators").children(".div-center").children("button:contains("+ data[2] +")").removeAttr("style");
					$("#oefen").removeAttr("style");
					$("#opdrachtenSelectie").children(".text-center").children(".margin-spacer").children("button").removeAttr("style");
				}
			   tmpMemory = (data[2] == null) ? tmpMemory : data[2];
			   modal(id, val, data[1]);
		   }
		   else if (data[0] == "table"){
			   createTable(id, data[1]);
		   }
		   else {
				if (data[0] == "colour") {
					if (data[1] != null){
						var idShorten = $("#opdrachtenSelectie").children(".text-center").children(".margin-spacer");
						for (let [key, value] of Object.entries(data[1])){ // Source : https://github.com/babel/babel-loader/issues/84
							ifExist = (idShorten.children(":contains("+ key +"):first").attr("style") == true) ? null : idShorten.children(":contains("+ key +"):first").css("border", value);
						}
					}
					if (data[2] != null){
						for (let [key, value] of Object.entries(data[2])){ // Source : https://github.com/babel/babel-loader/issues/84
							ifExist = ($("#oefen").attr("style") == true) ? null : $("#oefen").css("border", value);
						}
					}
					if (data[3] != null){
						var idShorten2 = $("#operators").children(".div-center");
						for (let [key, value] of Object.entries(data[3])){ // Source : https://github.com/babel/babel-loader/issues/84
							ifExist = (idShorten2.children(":contains("+ key +"):first").attr("style") == true) ? null : idShorten2.children(":contains("+ key +"):first").css("border", value);
						}
					}
					if (data[4] != null){
						var idShorten2 = $("#groepen").children(".div-center");
						for (let [key, value] of Object.entries(data[4])){ // Source : https://github.com/babel/babel-loader/issues/84
							ifExist = (idShorten2.children(":contains("+ key +"):first").attr("style") == true) ? null : idShorten2.children(":contains("+ key +"):first").css("border", value);
						}
					}
				}
				else if (data[0] == "empty") {
					$("#oefen").removeAttr("style");
					$("#opdrachtenSelectie").children(".text-center").children(".margin-spacer").children("button").removeAttr("style");
				}
			   ifVal = (val == null) ? null : fadeAnimation(id, val, data);
		   }
	   }
	});
}
function fadeAnimation(id1, val, data){
	if (id1 == "opdrachten" && val != "moveToassignment") {
		$("button").prop('disabled', false);
		myFunctions[id1].success(data);
	}
	else {
		id1 = (val == "moveToassignment") ? "opdrachten" : id1;
		$("#" + id1).fadeOut("slow", function(){
			$("button").prop('disabled', false);
			id1 = (val == "moveToassignment") ? "moveToassignment" : id1;
			$("input[name='input'], input[type='submit']").prop('disabled', false);
			if (val == "Toets" || val == "Oefentoets" || val == "Ja" && id1 != "opdrachtenSelectie"){
				$("#timer").css("display", "inline-block");
				
				if (val == "Ja") {
					tmpMemory = "Toets";
				}
				else {
					$("#timer").css("display", "block");
				}
				
				$("#opdrachten").children("form").children("h1").text(data.replace(/\"/g, ""));
				loopInitiator();
				$("#opdrachten").fadeIn("slow").css("display", "inline-flex");
				$("input[name='input']").val(null).focus();
			}
			else {
				ifFunction = (typeof(myFunctions[id1].success) == "function") ? myFunctions[id1].success(data) : null;
				id1 = (val == "moveToassignment") ? "operators" : id1;
				$($("#" + id1).next()).fadeIn("slow").css("display", "inline-flex");
				ifStartpagina = (id1 == "groepen") ? null : $("input[name='input']").val(null).focus();
			}
		});
	}
}
// Section 8 - END