<?php

include_once 'lib/ImageDownload.php';
/**
* 	@author khoatx	
*	@date 2017-05-14
**/
class IDDesignbyhuman extends ImageDownload  
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

		//<meta property="og:image" content="https://cdn4.designbyhumans.com/product/design/u1049972/pr246056-2-2669514-1200x675-b-p-ffffff.jpg">
		preg_match_all('/<meta property="og:image" content="([^"]+)">/', $content, $content_parts);
		if (empty($content_parts[1][0]))
		{
			return false;
		}

		$img_url = $content_parts[1][0];
		$result['origin'] = $url;
		$result['img'] = $img_url;

		//TITLE
		/*<h1 id="product-title" class="title detail-view-title">
			
				
								
				
			I Love Dad Mustache
			
		</h1>*/
		preg_match_all('/<h1 id="product-title"[^>]*>([^<]+)<\/h1>/', $content, $content_parts_title);

		/*pr($content_parts_title);
		exit;*/

		if (empty($content_parts_title[1][0]))
		{
			echo "<br/>NO TITLE<br/>";
			return false;
		}

        $productTitle = $content_parts_title[1][0];
		// $result['productTitle'] = trim($productTitle);
		// $result['productTitle'] = preg_replace_all('/^[^ ][\w\W ]*[^ ]/', '', $productTitle);
  //       $productTitle = preg_replace('/^\n+/', '', $productTitle);
		// $productTitle = preg_replace('/\n+$/', '', $productTitle);

		$productTitle = preg_replace('/^\s+/', '', $productTitle);
		$productTitle = preg_replace('/\s+$/', '', $productTitle);

		//RANKS
		$result['rank1'] = '#NULL';
		$result['rank2'] = '#NULL';

		//DESCRIPTION
		$description = $productTitle;
		$result['description'] = $description;

		return $result;
	}
}