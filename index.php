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
			<h2>Discover Instagram Photos Related to Twitter Trends and Users.</h2>
		</div>
		<div class="container">
			<div class="twitteruser">@<input type="text" id="twitteruser" placeholder=" -  Twitter or Instagram user"></div>
			<?php $trendingData = json_decode(@file_get_contents("https://api.twitter.com/1/trends/1.json")); ?>
			<?php if($trendingData != null && count($trendingData[0]->trends) > 0): ?>
				<ul class="hashtags">
					<?php foreach($trendingData[0]->trends as $trend): ?>
						<?php if(mb_check_encoding($trend->name,'ASCII')): ?>
							<li class="hashclick"><?php echo $trend->name;?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				<div class="clear"></div>
				</ul>
			<?php else: ?>
				<span class="error">We Couldn't find any trending data for now, please come back later!</span>
			<?php endif; ?>
		<div class="clear"></div>
		</div>
		<div id="imagecontainer" class="imagecontainer">
		</div>
		<div class="clear"></div>
		<div class="footer">
			Mini project by <a href="http://aymanfarhat.com">Ayman Farhat</a> and <a href="http://george.zakhour.me/">George Zakhour</a> - Source svailable on <a href="http://github.com/aymanfarhat/tweetogram" target="_blank">github</a>
		</div>
		<script type="text/javascript">
			$("input").focus();
			clickHash();
			$("input").keypress(function(e) {
				if(e.which == 13) {
					window.location.hash = "@"+this.value;
					loadContent({"user":this.value});
				}
			});
		</script>
	</body>
</html>