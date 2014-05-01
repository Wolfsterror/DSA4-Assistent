$(document).ready(function(){
	$(".adddice").click(function(){
		var num = parseInt($(this).text().substring(1));
		var dice = $("<button />")
					.attr("type", "button")
					.attr("data-dice", num)
					.attr("data-toggle", "tooltip")
					.attr("data-placement", "top")
					.attr("title", "W"+num)
					.addClass("btn btn-default")
					.text("W"+num).tooltip()
					.click(function(){$(".tooltip").remove();$(this).remove();});

		$("#diceoutput").append(dice).append(" ");
	});
	$("#rolldice").click(function(){
		$("#diceoutput > .btn").each(function(){
			$(this).text( Math.ceil(Math.random()*$(this).attr("data-dice")) );
		});
	});
});