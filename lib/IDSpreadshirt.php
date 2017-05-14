<?php

include_once 'lib/ImageDownload.php';
/**
* 	@author khoatx	
*	@date 2017-05-14
**/
class IDSpreadshirt extends ImageDownload  
{

	function parse_content($url)
	{
		$url = trim($url);
		$result = [];
		$content = $this->get_content($url);
	
		if (empty($content))
		{
			echo "<br/>EMPTY<br/>";
			return false;
		}

		//data-design-id="1008125251"
		preg_match_all('/data-design-id="([^"]+)"/', $content, $content_parts);
		if (empty($content_parts[1][0]))
		{
			return false;
		}
		$design_id = $content_parts[1][0];
		$img_url = 'http://image2.spreadshirtmedia.com/image-server/v1/designs/' . $design_id . '?height=1200&mediaType=png';
		$result['origin'] = $url;
		$result['img'] = $img_url;

		//TITLE
		/*<div class="title headline secondary">school's out forever</div>*/
		preg_match_all('/<div class="title headline secondary">([^<]+)<\/div>/', $content, $content_parts_title);

		if (empty($content_parts_title[1][0]))
		{
			echo "<br/>NO TITLE<br/>";
			return false;
		}

        $productTitle = $content_parts_title[1][0];
		$result['productTitle'] = trim($productTitle);

		//RANKS
		$result['rank1'] = '#NULL';
		$result['rank2'] = '#NULL';

		//DESCRIPTION
		$description = $productTitle;
		$result['description'] = $description;

		return $result;
	}
}