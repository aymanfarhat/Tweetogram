<?php 
/* Fetch worldwide trending hashtags */
$trendingData = json_decode(@file_get_contents("https://api.twitter.com/1/trends/1.json"));
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta name="description" content="Discover Instagram Photos Related to Twitter Trends.">
		<meta name="keywords" content="Twitter,trends,Instagram,photos,mashup">
		<title>Tweetogram</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/jquery.fancybox.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/jquery.fancybox-buttons.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="assets/js/spin.min.js"></script>
		<script type="text/javascript" src="assets/js/jquery.fancybox.js"></script>
		<script type="text/javascript" src="assets/js/jquery.fancybox-buttons.js"></script>
		<script type="text/javascript" src="assets/js/script.js"></script>
	</head>
	<body>
		<div id="main">
			<div class="contentWrapper">
				<div id="header">
					<img src="assets/images/logo.png" /><h1>TweetoGram</h1>
					<h2>Discover Instagram Photos Related to Twitter Trends.</h2>
				</div>
				<div class="clr"></div>
				<div id="nav">
					<?php if($trendingData != null && count($trendingData[0]->trends) > 0): ?>
						<ul>
							<?php foreach($trendingData[0]->trends as $trend): ?>
								<?php if(mb_check_encoding($trend->name,'ASCII')): ?>
									<li><a href="<?php echo 'http://'.$_SERVER["SERVER_NAME"].'/server/fetchimages.php?tag='.implode(explode(" ",str_replace("#", "", $trend->name))); ?>"><?php echo $trend->name; ?></a></li>
								<?php endif; ?>
							<?php endforeach; ?>
						<div class="clr"></div>
						</ul>
					<?php else: ?>
						<span class="error">We Couldn't find any trending data for now, please come back later!</span>
					<?php endif; ?>
				</div>
				<div id="content">
						<div class="result" id="result"></div>
					<div class="clr"></div>
				</div>
			<div id="footer">Mini Project by <a href="http://www.aymanfarhat.com">Ayman Farhat</a>. Source available on <a href="#">Github</a>.</div>
			</div>
			<div class="clr"></div>
		</div>
	</body>
</html>