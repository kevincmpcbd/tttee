<?php

include_once 'lib/Config.php';
/**
* 	@author khoatx	
*	@date 2017-04-20
**/
class ImageDownload 
{
	public $data = [];

	public $log_file;

	public function run($file_path)
	{
		$this->scan_files($file_path);
		$this->handle_data();
	}

	public function get_tee_content($url)
	{
		$url = trim($url);
		$opts = array(
		  'http'=>array(
		    'method'=>"GET",
		    'header'=>"Accept-language: en\r\n" .
		              "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
        		      "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-22 20:23:10\r\n" // i.e. An iPad 
 
		  )
		);

		$context = stream_context_create($opts);

		// Open the file using the HTTP headers set above
		$file = file_get_contents($url, false, $context);
		return $file;
	}

	function scan_files($file_name)
	{
		//Get file log name
		$handle = fopen($file_name, "r");
		if ($handle) 
		{
			while (($line = fgets($handle)) !== false) {
		        // process the line read.
		        if (preg_match('/^file_name=/', $line))//file name is first line
		        {
		        	$this->log_file = str_replace('file_name=', '', $line);
		        	$this->log_file = trim($this->log_file);
		        	break;
		        }
		        
		    }
		}

		$log_file_no_extension = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->log_file);
		$dir = DIR_LOG . date('Ymd');
		$filepath = $dir . '/' . $log_file_no_extension . '_json_data' . '.txt';

		if (file_exists($filepath)) 
		{
			$file_content = file_get_contents($filepath);
			
			if (!empty($file_content))
			{
				$this->data = json_decode($file_content, true);
				fclose($handle);
				return true;
			}
		}

		if ($handle) {
			
		    while (($line = fgets($handle)) !== false) {
		        // process the line read.
				$this->data[] = $this->parse_content($line);	
		        
		    }

		    fclose($handle);
		} else {
		    // error opening the file.
		}

		$this->save_data_json(); 
	}

	public function save_data_json()
	{
		$this->log_file = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->log_file);
		$dir = DIR_LOG . date('Ymd');

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $filepath = $dir . '/' . $this->log_file . '_json_data' . '.txt';
        $handle = fopen($filepath, "a+");

        //write log
        fwrite($handle, json_encode($this->data));
		fclose($handle);
	}

	function get_content($url)
	{
		$url = trim($url);
		$opts = array(
		  'http'=>array(
		    'method'=>"GET",
		    'header'=>"Accept-language: en\r\n" .
		              "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
        		      "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-22 20:23:10\r\n" // i.e. An iPad 
 
		  )
		);

		$context = stream_context_create($opts);

		// Open the file using the HTTP headers set above
		$file = file_get_contents($url, false, $context);
		return $file;
	}

	public function handle_data()
	{
		$dir = DIR_LOG . date('Ymd');
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $this->log_file = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->log_file);

        $filepath = $dir . '/' . $this->log_file . '_result' . '.txt';
        $handle = fopen($filepath, "a+");

        //write log
        $i = 1;
		foreach ($this->data as $row)
		{
			pr($row);

			$file_index = $i;
			$this->download_img($row['img'], $this->log_file, $file_index);

			fwrite($handle, "#{$i}-");
			fwrite($handle, "{$row['origin']}\n");
			fwrite($handle, "\t{$row['productTitle']}\n");
			fwrite($handle, "\t{$file_index}\n");
			fwrite($handle, "\t{$row['rank1']}\n");
			fwrite($handle, "\t{$row['rank2']}\n\n");

			fwrite($handle, "\t{$row['description']}\n\n\n");

			$i ++;
		}
		fclose($handle);
	}

	public function download_img($img_url, $sub_folder='', &$file_index)
	{
		$img_url = trim($img_url);
		$sub = preg_replace('/\..+?$/', '', $this->log_file);

		preg_match_all('/([^\/]+)$/', $img_url, $parts);
		
		if (!empty($sub_folder))
		{
			$sub_folder = $sub_folder . '\\';
		}

		// $img = "download\\{$sub_folder}" . $parts[0][0];

		$ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $parts[0][0]);
		$img = DIR_IMG . date('Ymd') . "/{$sub_folder}/{$file_index}." . $ext;
		$file_index = "{$file_index}." . $ext;

		$dir = DIR_IMG . date('Ymd') . "/{$sub_folder}" ;
		if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        @file_put_contents($img, file_get_contents($img_url));
	}
}