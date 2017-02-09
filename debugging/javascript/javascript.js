// Section 1 - Variables.
	// Section 1.1 - Temporary Memory aka a Temporary save storage for one variable.
	var tmpMemory;
	
	//Section 1.2 - Minutes / Seconds
	var minutes = 30;
	var seconds = 0;
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
		post($(this).find("input[name='input']").val(), $(this).parent().attr("id")); // send the val of the set input to function post.			
	});
	// Section 2.3 - On button click
	$("button").click(function(){
		console.log($(this))
		if ($(this).attr("class") == "backwards"){
			if ($(this).parent().attr("id") == null){
				console.log($(this).parent().parent().attr("id"));
				fadeAnimation($(this).parent().parent().attr("id"), $(this).text());	
			}
			else {
				console.log($(this).parent().attr("id"));
				fadeAnimation($(this).parent().attr("id"), $(this).text());	
			}
		}
		else if ($(this).text() != "Nee" ) {
			if ($(this).parent().parent().attr("id") == null || $(this).parent().parent().attr("class") == "modal"){
				parentID = $(this).parent().parent().parent().attr("id");
				console.log($(this).parent().parent().parent().prev());
			}
			else {
				parentID = $(this).parent().parent().attr("id");
				console.log($(this).parent().parent().attr("id"));				
			}
			ifJa = ($(this).text() == "Ja") ? null : tmpMemory = $(this).text();
			post($(this).text(), parentID);
		}
	});
});
// Section 2 - END

// Section 3 - pageVisibility checks whether the 1 given argument page is visible or not
function pageVisibility(id1){
	var text = $(id1).css("display") != "none";
	return text;
}

// Section 4 - fadeAnimation manages the transition between the 2 given arguments

function createTable(id1, table){
	console.log(id1);
	console.log(table);
	$("#" + id1).fadeOut("slow", function(){
		$("#uitslag").children("p").remove();
		$("#uitslag").children("table").remove();
		ifEresults = (table == "eResults") ? $("#uitslag").append("<p> ???????? wat </p>") : $("#uitslag").append(table);
		$("#uitslag").fadeIn("slow");
	});
	timeLimit(); // Minutes and Seconds are 0 so it is going to reset the minutes to a set variable;
}
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

// Section 7 - Time limit for the user making a test.
function timeLimit() {
	if (minutes != 0 || seconds != 0){
		seconds--;
		if (seconds <= 0 && minutes != 0){
			seconds = 60;
			minutes--
		}
		if (minutes == 0 && seconds == 0){
			clearTimeout(timeLimitloop);
			post(null);
		}
		else {
			timeLimitloop = setTimeout(timeLimit, 1000);	
		}
		$("#timer").text("Tijd : " + ("00" + minutes).substr(-2) + ":" + ("00" + seconds).substr(-2));		
	}
	else {
		minutes = 30;
		timeLimit();
	}
}
// Section 7 - END

// Section 6 - Popup function modal()
var popup = {
	"operators": {
		function(){
			text =  "<p> Je hebt deze toets al gemaakt </p>"+
					"<p> wil je deze toets opnieuw maken? </p>";
			return text;
		}
	},
	"opdrachtenSelectie": {
		function(id, val, som, uitkomst, antwoord, foutofGoed, naam){
			console.log(val);
			if (val != "Resultaten"){
			text =  "<p> Je hebt deze som al gemaakt </p>"+
					"<p> Het som was: </p>" +
					"<p>" + som + " = " + uitkomst + "</p>" +
					"<p> Jouw antwoord was: </p>" +
					"<p>" + antwoord + "</p>" +
					"<p> wil je deze som opnieuw maken? </p>";				
			}
			else {
				text = "<p> Je hebt nog geen resultaten. </p>";
			}
			return text;
		}
	},
	"opdrachten": {
		function(id, val, som, uitkomst, antwoord, foutofGoed, naam){
			var somEnuitkomst = som + " = " + uitkomst;
			console.log(naam);
			if (foutofGoed == "fout"){
				text = "<p>Jammer, " + naam + " jouw antwoord is niet goed. " + som + " = " + uitkomst + "</p>";
			}
			else {
				text = "<p>Ja, "+ naam + " jouw antwoord is goed! " + som + " = " + uitkomst + "</p>" ;	
			}
			return text;
		}
	},	
}
function modal(id, val, som, uitkomst, antwoord, foutofGoed, naam){
	console.log(val);
	var text = "";
	var modal = $("#" + id + "modal");
	ifEresults = (val == "Resultaten" || id == "opdrachten") ? modal.children(".modal-content").children("span").css("display", "block") : modal.children(".modal-content").children("span").css("display", "none");
	ifEresults2 = (val == "Resultaten" || id == "opdrachten") ? modal.children(".modal-content").children("button").css("display", "none") : modal.children(".modal-content").children("button").css("display", "inline-block");
	text = popup[id].function(id, val, som, uitkomst, antwoord, foutofGoed, naam);
	console.log(modal);
	console.log(text);
	console.log(id);
	ifTestalreadyMade = ($("#opdrachtenSelectie").css("display") != "none") ?  modal.children(".modal-content").children("span").after(text) : modal.children(".modal-content").prepend(text);	
	modal.fadeIn("fast");
	$(".close, #yesOrno, #testResults").click(function() {
		$("input[name='input'], input[type='submit']").prop('disabled', false);
		modal.fadeOut("fast", function(){
			whenNotremove = ($("#startpagina").css("display") != "none") ? null : modal.children(".modal-content").children("p").remove();				
			var somEnuitkomst = som + " = " + uitkomst;
		});
		$("input[name='input']").val(null).focus();
	});
}
// Section 6 - END

// Section 7 - Submit form replacement. POST using AJAX.
function post(val, functions) {
	console.log(val);
	$.ajax({
	   type: "POST",
	   url: "ajax.php", // The url where the post is going to be send and the response orginate.
	   data: myFunctions[functions].dataSend(val, functions),
	   dataType: (functions == "opdrachtenSelectie" || functions == "opdrachten") ? "JSON" : "text",
	   success: function(data){
			console.log(data);
		   if (data[0] == "popup"){
			   console.log("data[0]");
			   modal(functions, val, data[1], data[2], data[3]);
		   }
		   else if (data == "popup"){
			   console.log("data");
			   modal(functions, val);
		   }
		   else if (data[0] == "table"){
			   console.log(data);
			   createTable(functions, data[1]);
		   }
		   else {
			   fadeAnimation(functions, val, data);		   
		   }
	   }
	});
}
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
		},
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
		},
	},
	"opdrachtenSelectie": {
		dataSend:
		function(val){
			console.log(val);
			console.log(tmpMemory);
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
			console.log(data);
			$("input[name='input'], input[type='submit']").prop('disabled', true);
			ifToets = (tmpMemory == "Toets") ? null : modal("opdrachten", null, data[0], data[1], data[2], data[3], data[4]) ;
			$('input[name="input"]').val(null).focus();
			$("#opdrachten").children("form").children("h1").fadeOut("fast", function(){
				ifToets2 = (tmpMemory == "Toets") ? $("input[name='input'], input[type='submit']").prop('disabled', false) : null;
				ifToets4 = (tmpMemory == "Toets") ? $("input[name='input']").val(null).focus() : null;
				$("#opdrachten").children("form").children("h1").text(ifToets = (tmpMemory == "Toets") ? data : data[5]).fadeIn("fast");
			});
		}
	},
};

function fadeAnimation(id1, val, data){
	console.log(id1);
	console.log(val);
	if (val == "Ga terug") {
		$("#" + id1).fadeOut("slow", function(){
				id1 = (tmpMemory == "Toets") ? "opdrachtenSelectie" : (id1 == "uitslag") ? "opdrachten" : id1;
			$($("#" + id1).prev()).fadeIn("slow").css("display", "inline-flex");
		});
	}
	else {
		if (id1 == "opdrachten") {
			myFunctions[id1].success(data);
		}
		else {
			$("#" + id1).fadeOut("slow", function(){
			if (val == "Toets" || val == "Ja" && id1 != "opdrachtenSelectie"){
				$("#timer").css("display", "inline-block");
				if (val == "Ja") {
					tmpMemory = "Toets";
				}
				$("#opdrachten").children("form").children("h1").text(data.replace(/\"/g, ""));
				$("#opdrachten").fadeIn("slow",  function(){timeLimit();}).css("display", "inline-flex");
				$("input[name='input']").val(null).focus();
			}
			else {
				ifFunction = (typeof(myFunctions[id1].success) == "function") ? myFunctions[id1].success(data) : null;
				$($("#" + id1).next()).fadeIn("slow").css("display", "inline-flex");	
			}
			});
		}
	}
}