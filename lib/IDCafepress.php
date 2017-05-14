<?php

include_once 'lib/ImageDownload.php';
/**
* 	@author khoatx	
*	@date 2017-05-13
**/
class IDCafepress extends ImageDownload  
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

		//URL: http://www.cafepress.com/mf/33014016/girls-softball_tshirt?productId=482526936
		preg_match_all('/mf\/([^\/]+)/', $url, $url_parts);

		if (empty($url_parts[1][0]))
		{
			echo "<br/>NO URL<br/>";
			return false;
		}

		$tee_id = $url_parts[1][0];

		//IMAGE
		$img_url = 'http://i3.cpcache.com/merchandise_zoom/167_4600x4600_Front_Color-undefined.png?region=name:FrontCenter,id:' . $tee_id;
		
		$result['origin'] = $url;
		$result['img'] = $img_url;

		//TITLE
		/*<li class="pdp-design-name">Design Name: Softball Is Importanter</li>*/
		// preg_match_all('/<li class="pdp-design-name">Design Name: ([^<]+)<\/li>/', $content, $content_parts_title);

		// <h1 itemprop="name" title="Softball Is Importanter Dark T-Shirt">Softball Is Importanter Dark T-Shirt</h1>

		preg_match_all('/<h1 itemprop="name"[^>]*>([^<]+)<\/h1>/', $content, $content_parts_title);

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
		// <li class="pdp-design-comments">Description: This funny Education Is Important But Softball Is Importanter design makes a funny gift for any softball player.</li>
		preg_match_all('/<li class="pdp-design-comments">Description: ([^<]+)<\/li>/', $content, $content_parts_description);
// pr($content_parts_description);
// return;
		$description = !empty($content_parts_description[1][0]) ? $content_parts_description[1][0] : $productTitle;

		if (strlen($description) > 30)
		{
			$description = $productTitle;
		}
		$result['description'] = $description;

		return $result;
	}
}