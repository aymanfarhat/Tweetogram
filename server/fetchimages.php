<?php
$instagramAccessToken = "YOUR_INSTAGRAM_ACCESS_TOKEN";
$imageCount = 20;

/* Check the parameter and if ajax request */
if(isset($_GET['tag']) && !empty($_GET['tag']) && (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'))
{
	$tag = preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['tag']);

	$reqString = "https://api.instagram.com/v1/tags/".$tag."/media/recent?access_token=".$instagramAccessToken."&count=".$imageCount;
	
	/* Make sure that open_ssl ie enabled for this to work */
	$data = @file_get_contents($reqString);
	$photos = json_decode($data);

	echo generateContentView($photos);
}
else
	echo 'Invalid Request';

/* Generates html code to be echoed back to the client, based on an JSON object of data */
function generateContentView($photos)
{
	if(is_object($photos) && count($photos->data) > 0)
	{
		$html = '<ul class="imageList">';

		foreach ($photos->data as $obj) 
			$html .='<li><a class="fancybox" data-fancybox-group="gallery" title="'.implode(", ", $obj->tags).'" href="'.$obj->images->standard_resolution->url.'"><img src="'.$obj->images->thumbnail->url.'"/></a></li>';
		
		$html.='<div style="clear:both;"></div></ul>';
	}
	else 
		$html = "<span class='error'> We couldn't find photos related to this hashtag, please try again later! </span>";
	
	return $html;
}
?>