<!DOCTYPE html>
<html>
<head>
	<title>Lazy Loader</title>
</head>

<style>
.country { height: 200px; overflow: auto; width: 500px; }
.loading { color: red; }
li {font-size:24px;}
#loading { display:none; color:red; font-size:30px; }
</style>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.js"></script>

<script>
$(function() {
   	loadResults(0);
   	$('.country').animate({scrollTop: 0}, 1000);

    $('.country').scroll(function() {
      if($("#loading").css('display') == 'none') {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
			var limitStart = $("#results li").length;
			loadResults(limitStart);
        }
      }
	});

    var limitReached = false;
	function loadResults(limitStart) {
		if(!limitReached)
		{
			$("#loading").show();
		    $.ajax({
		        url: "request.php",
		        type: "post",
		        dataType: "json",
		        data: {
		            limitStart: limitStart
		        },
		        success: function(data) {
		        		limitReached = data['limitReached'];
		              	$.each(data['html'], function(index, value) {
		               		$("#results").append("<li id='"+index+"'>"+value+"</li>");
						});
					$("#loading").hide();     
		        }
		    });
		}
		else
		{
			console.log('Nothing new to display');
		}
	};
});
</script>

<body>
<div class="country">
    <ul id="results"></ul>
</div>
 <span id="loading">Loading Please wait...</span>
</body>
</html>