<?php

include_once 'lib/ImageDownload.php';
/**
* 	@author khoatx	
*	@date 2017-04-20
**/
class IDAmz extends ImageDownload  
{
	function parse_content($url)
	{
		$url = trim($url);
		$result = [];
		$content = $this->get_content($url);
		// var_dump($content);

		$dom = new DOMDocument;
		@$dom->loadHTML($content);

		//data-old-hires="https://images-na.ssl-images-amazon.com/images/I/71dPX2LtnXL._UL1500_.jpg"
		preg_match_all('/data-old-hires="([^"]+)"/', $content, $parts_data_old_hires);

		//download
		$img_url = $parts_data_old_hires[1][0];
		
		$result['origin'] = $url;
		$result['img'] = $img_url;

		/*<span id="productTitle" class="a-size-large">
              
                  OFFICIAL Tired As A Mother T Shirt For All Ages
          
        </span>*/
        $productTitle = $dom->getElementById('productTitle');
		$result['productTitle'] = trim($productTitle->nodeValue);


		/*<span class="zg_hrsr_rank">#1254</span>*/
		preg_match_all('/class="zg_hrsr_rank"[^>]*>([^<]+)</', $content, $parts_ranks);
		$rank1 = !empty($parts_ranks[1][0]) ? trim($parts_ranks[1][0]) : '#NULL';
        $rank2 = !empty($parts_ranks[1][1]) ? trim($parts_ranks[1][1]) : '#NULL';
		$result['rank1'] = $rank1;
		$result['rank2'] = $rank2;

		//Description
		$feature_bullets = $dom->getElementById('feature-bullets');
		$description = trim($feature_bullets->nodeValue);
		$description = preg_replace('/\s{2,}/', '###', $description);
		$description = str_replace('Preshrunk 100% cotton###', '', $description);
		$description = str_replace('100% Cotton###Imported###Machine wash cold with like colors, dry low heat###', '', $description);
		$description = str_replace('###Lightweight, Classic fit, Double-needle sleeve and bottom hem', '', $description);
		$description = str_replace('###', "\n\t", $description);

		$result['description'] = $description;

		return $result;
	}
}