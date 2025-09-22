<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {

    /**
	 * Rekomendasi BSSN 2023
	 * Add Hash - Crypt - Decrypt Function to hash id from user.
	 * 28/03/2023 9.27 AM
	 */

	public function hashData($data){
		$privateKey 	= '@RSOMH12903123BUKITTINGGI2023)!^%@!*$('; // user define key
		$secretKey      = '1b2532b238123b129'; // user define secret key
		$encryptMethod  = "AES-256-CBC";
		$string 	= $data; // user define value

		$key     = hash('sha256', $privateKey);
		$ivalue  = substr(hash('sha256', $secretKey), 0, 16); // sha256 is hash_hmac_algo
		$result      = openssl_encrypt($string, $encryptMethod, $key, 0, $ivalue);
		echo $output = base64_encode($result);  // output is a encripted value
	}

	public function decryptData($data){
		$privateKey 	= '@RSOMH12903123BUKITTINGGI2023)!^%@!*$('; // user define key
		$secretKey      = '1b2532b238123b129'; // user define secret key
		$encryptMethod  = "AES-256-CBC";
		$stringEncrypt  = $data; // user encrypt value
		$key    = hash('sha256', $privateKey);
		$ivalue = substr(hash('sha256', $secretKey), 0, 16); // sha256 is hash_hmac_algo
		$output = openssl_decrypt(base64_decode($stringEncrypt), $encryptMethod, $key, 0, $ivalue);
		return $output;
		// output is a decripted value
	}
}