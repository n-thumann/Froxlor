<?php
namespace Froxlor\Http;

use Exception;

class HttpClient
{
    /**
     * Executes simple GET request
     *
     * @return bool|string
     * @throws Exception
     */
	public static function urlGet(string $url, bool $follow_location = true, int $timeout = 10)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Froxlor/' . \Froxlor\Froxlor::getVersion());
		if ($follow_location) {
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		}
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)$timeout);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		if ($output === false) {
			$e = curl_error($ch);
			curl_close($ch);
			throw new Exception("Curl error: " . $e);
		}
		curl_close($ch);
		return $output;
	}

    /**
     * Downloads and stores a file from an url
     *
     * @throws Exception
     */
	public static function fileGet(string $url, string $target)
    {
		$fh = fopen($target, 'w');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Froxlor/' . \Froxlor\Froxlor::getVersion());
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		// give curl the file pointer so that it can write to it
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FILE, $fh);
		$output = curl_exec($ch);
		if ($output === false) {
			$e = curl_error($ch);
			curl_close($ch);
			throw new Exception("Curl error: " . $e);
		}
		curl_close($ch);
		return $output;
	}
}
