

function testu(){


    var url = "tweeGetallen.php"; // the script where you handle the form input.
    $.ajax({
           type: "POST",
           url: url,
           data: {functions: "opdrachtGenerator"},
		   dataType: "json",
           success: function(data)
           {
				$("#title").text(data[0]);
               console.log(data);
           }
         });
}
function control(){
	
	event.preventDefault();
}

function send() {
	var form = $("form"),
		term = form.find('input[name="gebruikersNaam"]').val();
			$("#startpagina").fadeOut("slow", function(){
				$("#groepen").append("<h1 class='text-center'>" + term + "</h1>");
				
			});
		
	    $.ajax({
           type: "POST",
           url: "tweeGetallen.php",
           data: {functions: "gebruikersNaam", gebruikersNaam: term}
         });
	event.preventDefault();
}