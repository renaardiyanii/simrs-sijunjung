<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException as Exception;
use LZCompressor\LZString;

class Vclaim
{
    private $clients;
    private $headers;
    private $cons_id;
    private $timestamp;
    private $signature;
    private $secret_key;
    private $user_key;
    private $base_url;
    private $service_name;
    private $decrypt_key;
    public function __construct()
    {

        $this->cons_id = $_ENV['CONSID']??'';
        $this->secret_key = $_ENV['SECRETKEY']??'';
        $this->base_url = $_ENV['BASEURL']??'';
        $this->service_name = $_ENV['SERVNAME']??'';
        $this->user_key = $_ENV['USERKEY']??'';
        $this->clients = new Client([
            'verify' => false,
            // 'curl'=>[CURLOPT_SSL_VERIFYPEER=>false,CURLOPT_SSL_VERIFYHOST=>false,CURLOPT_SSL_CIPHER_LIST=>'DEFAULT@SECLEVEL=1']
        ]);

        $this->setTimestamp()->setSignature()->setHeaders();
    }


    public function setHeaders()
    {
        $this->headers = [
            'X-cons-id' => $this->cons_id,
            'X-Timestamp' => $this->timestamp,
            'X-Signature' => $this->signature,
            'user_key' => $this->user_key
        ];
        return $this;
    }

    protected function setTimestamp()
    {
        $dateTime = new \DateTime('now', new \DateTimeZone('UTC'));
        $this->timestamp = (string)$dateTime->getTimestamp();
        return $this;
    }

    protected function setSignature()
    {
        $data = $this->cons_id . '&' . $this->timestamp;
        $signature = hash_hmac('sha256', $data, $this->secret_key, true);
        $encodedSignature = base64_encode($signature);
        $this->signature = $encodedSignature;

        $this->decrypt_key = $this->cons_id . $this->secret_key . $this->timestamp;

        return $this;
    }

    protected function stringDecrypt($key, $string)
    {
        $encrypt_method = 'AES-256-CBC';

        // hash
        $key_hash = hex2bin(hash('sha256', $key));

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        return $output;
    }

    protected function decompress($string)
    {
        return LZString::decompressFromEncodedURIComponent($string);
    }

    protected function decryptResponse($response)
    {
        $responseVar = json_decode($response);
        if (isset($responseVar->response)) {
            $responseVar->response = json_decode($this->decompress($this->stringDecrypt($this->decrypt_key, $responseVar->response)));
        }
        return json_encode($responseVar);
    }

    public function get($feature, $url = '')
    {
        try {
            $response = $this->clients->request(
                'GET',
                ($url != '' ? $url : $this->base_url . '/' . $this->service_name . '/')  . $feature,
                [
                    'headers' => $this->headers
                ]
            )->getBody()->getContents();

            $response = $url != '' ? $response : $this->decryptResponse($response);
        } catch (Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }
        return $response;
    }

    public function post($feature, $data = [], $headers = [], $url = '')
    {
        $this->headers['Content-Type'] = $url != '' ? 'application/json' : 'application/x-www-form-urlencoded';
        if (!empty($headers)) {
            $this->headers = array_merge($this->headers, $headers);
        }
        try {
            $response = $this->clients->request(
                'POST',
                ($url != '' ? $url : $this->base_url . '/' . $this->service_name . '/')  . $feature,
                [
                    'headers' => $this->headers,
                    'json' => $data,
                ]
            )->getBody()->getContents();

            $response =  $url != '' ? $response : $this->decryptResponse($response);
        } catch (Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }
        return $response;
    }

    public function put($feature, $data = [])
    {
        // var_dump($this->headers);die();

        $this->headers['Content-Type'] = 'application/x-www-form-urlencoded';
        try {
            $response = $this->clients->request(
                'PUT',
                $this->base_url . '/' . $this->service_name . '/' . $feature,
                [
                    'headers' => $this->headers,
                    'json' => $data,
                ]
            )->getBody()->getContents();

            $response = $this->decryptResponse($response);
        } catch (Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }
        return $response;
    }

    public function delete($feature, $data = [])
    {
        $this->headers['Content-Type'] = 'application/x-www-form-urlencoded';
        try {
            $response = $this->clients->request(
                'DELETE',
                $this->base_url . '/' . $this->service_name . '/' . $feature,
                [
                    'headers' => $this->headers,
                    'json' => $data,
                ]
            )->getBody()->getContents();

            $response = $this->decryptResponse($response);
        } catch (Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }
        return $response;
    }

    public function getSignature()
    {
        //set X-Timestamp, X-Signature, and finally the headers
        $this->setTimestamp()->setSignature()->setHeaders();

        return $this->headers;
    }
}
