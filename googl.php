#!/usr/bin/env php
<?php
#
# googl.php
# a url shortener using goo.gl service
# return short url
# ./googl.php http://mweldan.com
####################################

class Googl {

	public function __construct() {
		// have to get $argv from $GLOBALS
		$this->argv = $GLOBALS['argv'];
		
		$this->countArguments();
		$this->checkExtensionLoaded();
		$this->process();
	}
	
	private function countArguments() {
		// check passed argument
		if (count($this->argv) < 2 ){
			$this->printhelp();
		}	
	}
	
	private function checkExtensionLoaded() {
		// check curl extension is loaded or not 
		if (!extension_loaded('curl') ) {
			echo "===========================================\n";
			echo "curl extension is required!\n";
			echo "===========================================\n";
			exit;
		}	
	}
	
	private function printhelp() {
		// print help text
		echo "\n===========================================\n";
		echo "googl.php - A googl url shortener cli script\n";  
		echo "[ Weldan Jamili <mweldan@gmail.com> ]\n";
		echo "-------------------------------------------\n";
		echo "Usage: ./googl.php http://mweldan.com\n";
		echo "===========================================\n\n";
		exit;
	}
	
	private function process() {
		// process url
		$url = "https://www.googleapis.com/urlshortener/v1/url";
		$payload = json_encode(
			array("longUrl" => $this->argv[1])
		);
		$headers = array(
			"Content-Type: application/json"
		);

		$process = curl_init($url);
		curl_setopt($process, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($process, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, true);	
		curl_setopt($process, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($process);
		if ($response) {
			$result = json_decode($response);
			echo "===========================================\n";
			echo "Short URL: ".$result->id."\n";
			echo "===========================================\n";
		}	
	}
	
}

$googl = new Googl;
 
?>
