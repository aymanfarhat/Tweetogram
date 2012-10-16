var opts = {
  lines: 12,
  length: 15,
  width: 6,
  radius: 30,
  color: '#3f8df9',
  speed: 2,
  trail: 100,
  shadow: false
};

$(document).ready(function(){
	var target = document.getElementById('result');
	var spinner = new Spinner(opts);
	
	$('.fancybox').fancybox();

	$("#nav ul li a").click(function(){
		$('.result').html("");
		spinner.spin(target);

		var url = $(this).attr("href");
		
		$("#nav ul li a").removeClass("selected");

		$(this).addClass("selected");

		$.get(url,function(data){
			spinner.stop();
			$('.result').html(data);
		});
		return false;
	});


});