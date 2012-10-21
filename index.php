<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta name="description" content="Discover Instagram Photos Related to Twitter Trends.">
		<meta name="keywords" content="Twitter,trends,Instagram,photos,mashup">
		<link rel="icon" type="image/png" href="images/favicon.png">
		<title>Tweetogram</title>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="assets/js/script.js"></script>
		<link rel="stylesheet" href="assets/css/style.css" />
		<link rel="stylesheet" href="assets/css/ajax.css" />
	</head>


	<body>

		<div class="header">
			<img src="assets/images/logo.png" alt="Tweetogram" />
			<h1><a href="index.php">Tweetogram</a></h1>
		</div>

		<div class="container">
			<div class="twitteruser">@<input type="text" id="twitteruser" placeholder=" -   Twitter or Instagram user"></div>
			<ul class="hashtags">
			<?php
				$json = json_decode(file_get_contents("https://api.twitter.com/1/trends/1.json"));
				for($i=0;$i<count($json[0]->trends);$i++) {
					echo "<li class='hashclick'>".$json[0]->trends[$i]->name."</li>";
				}
			?>
			</ul>
			<div class="clear"></div>
		</div>

		<div id="imagecontainer" class="imagecontainer">
			
		</div>
		<div class="clear"></div>

		<div class="footer">
			Copyleft <span class="copyleft">&copy;</span> 2012 - Based on <a href="http://tweetogram.aymanfarhat.com" target="_blank">Ayman Farhat's Tweetogram</a> - Available on <a href="http://github.com/aymanfarhat/tweetogram" target="_blank">github</a>
		</div>



		<script>
		//$(document).load(function(){
			$("input").focus();
			clickHash();
			$("input").keypress(function(e) {
				if(e.which == 13) {
					window.location.hash = "@"+this.value;
					loadContent({"user":this.value});
				}
			});
		//});
		</script>

	</body>

</html>