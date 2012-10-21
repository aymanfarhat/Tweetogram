<?php

$TOKEN = "240112712.dff4a66.329513a0b84c44d9a9d7fcebabeb577d";
$COUNT = 20;

if(isset($_GET["user"]) && !empty($_GET["user"])) {

	$user = $_GET["user"];
	$hashtags = array();

	// Check if the user is on instagram
	$user_on_instagram = false;
	$checkIfUserOnInstagram = json_decode(@file_get_contents("https://api.instagram.com/v1/users/search?q=".$user."&access_token=".$TOKEN));
	if(count($checkIfUserOnInstagram->data) > 0) {
		$user_on_instagram = true;
		$u = $checkIfUserOnInstagram->data[0];
		$user_id = $u->id;
		echo "<div class='instagramprofile'>
		<h1>".$u->username." (".$u->full_name.")</h1>
		<img src='".$u->profile_picture."'>
		<h2>".$u->bio."</h2></div>";
	}

	// Check if the user is on twitter
	$checkIfUserOnTwitter = @file_get_contents("https://api.twitter.com/1/users/show.json?screen_name=".$user."&include_entities=true");
	$user_on_twitter = false;
	if($checkIfUserOnTwitter) {
		$checkIfUserOnTwitter = json_decode($checkIfUserOnTwitter);
		if($checkIfUserOnTwitter->errors[0]->code != 34) {
			$user_on_twitter = true;
			echo "<div class='twitterprofile'>
				<h1>@".$checkIfUserOnTwitter->screen_name." (".$checkIfUserOnTwitter->name.")</h1>
				<img src='".$checkIfUserOnTwitter->profile_image_url."'>
				<h2>".$checkIfUserOnTwitter->description."</h2>
				<ul class='tweepinfo'>
					<li><strong>Tweets:</strong> ".$checkIfUserOnTwitter->statuses_count."</li>
					<li><strong>Following:</strong> ".$checkIfUserOnTwitter->friends_count."</li>
					<li><strong>Followers:</strong> ".$checkIfUserOnTwitter->followers_count."</li>
				</ul>
				<div class='clear'></div>
			</div>";
		}
	}

	// Dissect the tweets and getting the hashtags
	if($user_on_twitter) {
		$tweetsOfUser = json_decode(@file_get_contents("http://search.twitter.com/search.json?q=from:".$user."&rpp=5"));
		$tweets = $tweetsOfUser->results;
		echo "<ul class='twittertweets'>";
		foreach($tweets as $tweet) {
			$final = "";
			$t = explode(" ", $tweet->text);
			for($i=0;$i<count($t);$i++) {
				if(substr($t[$i],0,1) == "#") {
					if(!in_array(substr($t[$i],1), $hashtags)) {
						array_push($hashtags, substr($t[$i],1));
					}
					$t[$i] = "<span class='hashclick'>".$t[$i]."</span>";
				}
				$final .= $t[$i]." ";
			}
			echo "<li>$final<div class='clear'></div></li>";
		}
		echo "</ul>";
	}


	// Showing the images related to the hashtags
	for($i=0;$i<count($hashtags);$i++) {
		if(urlencode($hashtags[$i]) != "") {
			echo "<h3>Photos about ".$hashtags[$i]."</h3>";
			echo "<ul class='instagramfeed'>";
			$h = preg_replace("/[^a-zA-Z0-9]*/i", "", $hashtags[$i]);
			$json = json_decode(@file_get_contents("https://api.instagram.com/v1/tags/".$h."/media/recent?access_token=".$TOKEN."&count=".$COUNT));
			$json = $json->data;
			if(gettype($json) == "array") {
				foreach ($json as $img) {
					echo "<li data-src='".$img->images->standard_resolution->url."' data-imageid='".$img->caption->id."' data-userid='".$img->from->id."'><a href='".$img->link."' target='_blank'><img src='".$img->images->thumbnail->url."'></a></li>";
				}
			}
			echo "</ul><div class='clear'></div>";
		}
	}
	if($user_on_instagram) {
		$feed = json_decode(@file_get_contents("https://api.instagram.com/v1/users/".$user_id."/media/recent?q=".$user."&access_token=".$TOKEN));
		echo "<h3>Latest Images from ".$user."</h3>";
		echo "<ul class='instagramfeed'>";
		$feed = $feed->data;
		if(gettype($feed)=="array") {
			foreach ($feed as $img) {
				echo "<li data-src='".$img->images->standard_resolution->url."' data-imageid='".$img->caption->id."' data-userid='".$img->from->id."'><a href='".$img->link."' target='_blank'><img src='".$img->images->thumbnail->url."'></a></li>";
			}
		}
		echo "</ul><div class='clear'></div>";
	}


} else if (isset($_GET["hash"]) && !empty($_GET["hash"])) {

	// Search Instagram's API for images with tags similar to the one provided
	$h = preg_replace("/[^a-zA-Z0-9]*/i", "", $_GET["hash"]); 
	echo "<ul class='instagramfeed'>";
	$json = @file_get_contents("https://api.instagram.com/v1/tags/".$h."/media/recent?access_token=".$TOKEN."&count=".$COUNT);
	if($json) {
		$json = json_decode($json);
		$json = $json->data;
		foreach ($json as $img) {
			echo "<li data-src='".$img->images->standard_resolution->url."' data-imageid='".$img->caption->id."' data-userid='".$img->from->id."'><a href='".$img->link."' target='_blank'><img src='".$img->images->thumbnail->url."'></a></li>";
		}
	}
	echo "</ul>";

} else {
	echo "Invalid Request";
}




?>