function clickHash() {
	$(".hashclick").click(function() {
		loadContent({"hash":this.innerHTML});
	});
}
function loadContent(obj) {
	var image = $("<img>").attr({"src":"assets/images/loading.gif","class":"loading"});
	$("#imagecontainer").empty();
	$("#imagecontainer").append(image);
	if(obj.user) {
		$.ajax({
			type:"GET",
			url: "server/result.php?user="+obj.user,
			success:function(data) {
				$("#imagecontainer").html(data);
				$('html, body').animate({scrollTop: $("input").offset().top-10}, 1000, "swing");
				clickHash();
			},
			error: function() {
				console.log("ERROR");
			}
		});
	} else if (obj.hash) {
		var hash = obj.hash.replace(/[\s+|#]?/gi,"");
		window.location.hash = hash;
		$.ajax({
			type:"GET",
			url: "server/result.php?hash="+hash,
			success:function(data) {
				$("#imagecontainer").html(data);
				$('html, body').animate({scrollTop: $("input").offset().top-10}, 1000, "swing");
			},
			error: function() {
				console.log("ERROR");
			}
		});
	}
}