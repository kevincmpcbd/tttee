<?php

include_once 'lib/ImageDownload.php';
/**
* 	@author khoatx	
*	@date 2017-04-20
**/
class IDEbay extends ImageDownload  
{
	function parse_content($url)
	{
		$url = trim($url);
		$result = [];
		$content = $this->get_content($url);
		
		$dom = new DOMDocument;
		@$dom->loadHTML($content);

		//download
		preg_match_all('/id="icImg".+src="([^"]+)"/', $content, $viEnlargeImgLayer_img_ctr_parts);
		
		$img_url_1300 = $viEnlargeImgLayer_img_ctr_parts[1][0];
		$url_parts = split('~/', $img_url_1300);
		$img_url = $url_parts[0] . '~/s-l1600.jpg';

		$result['origin'] = $url;
		$result['img'] = $img_url;

		/*<span id="productTitle" class="a-size-large">
              
                  OFFICIAL Tired As A Mother T Shirt For All Ages
          
        </span>*/
        $productTitle = $dom->getElementById('itemTitle');
		$result['productTitle'] = trim($productTitle->nodeValue);


		/*<span class="zg_hrsr_rank">#1254</span>*/
		preg_match_all('/class="zg_hrsr_rank"[^>]*>([^<]+)</', $content, $parts_ranks);
		$result['rank1'] = '#NULL';
		$result['rank2'] = '#NULL';

		//Description
		/*$feature_bullets = $dom->getElementById('feature-bullets');
		$description = trim($feature_bullets->nodeValue);
		$description = preg_replace('/\s{2,}/', '###', $description);
		$description = str_replace('Preshrunk 100% cotton###', '', $description);
		$description = str_replace('100% Cotton###Imported###Machine wash cold with like colors, dry low heat###', '', $description);
		$description = str_replace('###Lightweight, Classic fit, Double-needle sleeve and bottom hem', '', $description);
		$description = str_replace('###', "\n\t", $description);*/

		$description = '';

		$result['description'] = $description;

		return $result;
	}
}