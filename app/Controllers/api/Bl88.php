<?php

namespace App\Controllers\api;

use App\Controllers\RestController;
use CodeIgniter\HTTP\Message;
use DOMDocument;
use DOMXPath;
use Exception;

class Bl88 extends RestController {
    private $url = "https://vk99bet.com/api/v1/";
    private $code = "ag024";
    private $token = "7506d35fe9fe68d7785a44ddaee346e7";
    private $reffix = "blbet789.com";
    private $prefix = "bl789";
    private $curl;
    public function __construct() {
        $this->curl = curl_init();
    }
    public function test() {
        $Message = new Message();
        $Message->populateHeaders();
        return $this->sendData($Message->header("Cf-Ipcountry")->getValue());
    }
    public function login() {
        $body = $this->getPost();
        if (substr($body->username, 0, strlen($this->prefix)) != $this->prefix) $body->username = "{$this->prefix}{$body->username}";
        $form = [
            "s_username" => $body->username,
            "s_password" => $body->password,
            "_hash" => $this->get_hash(),
        ];
        $login = $this->post("Authen/Login", $form);
        return $this->sendData($login->data, $login->message, $login->status);
    }
    protected function get_hash() {
        $body = $this->getPost();
        $curl = curl_init();
        $endpoint = isset($body->endpoint) ? $body->endpoint : 'https://vk99bet.com/';
        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(),
        ));

        $response = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        // $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($curl);

        $inputs = [];
        $arr = explode("\n", $body);
        // echo json_encode($arr); exit;
        foreach ($arr as $row) {
            if (strpos($row, "_hash") != false) {
                $inputs[] = $row;
                break;
            }
        }

        if (count($inputs) == 0) return null;

        $result = [];
        $document = new DOMDocument();
        $document->loadHTML(implode("", $inputs));
        $xpath = new DOMXPath($document);
        $result["_hash"] = $xpath->query("//input[@name=\"_hash\"]")[0]->getAttribute("value");

        return $result["_hash"];
    }
    protected function post($path, $data = array()) {
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => "{$this->url}{$path}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "authorization-agent: {$this->code}",
                "authorization-token: {$this->token}",
                "Content-Type: application/json",
            ),
        ));

        $response = curl_exec($this->curl);
        curl_close($this->curl);

        // echo print_r($data); exit;
        try {
            $response = json_decode($response);
            if ($response->statusCode == 0) return (object)[
                "status" => true,
                "message" => $response->statusDesc,
                "data" => $response->bean,
            ];
            return (object)[
                "status" => false,
                "message" => $response->statusDesc,
                "data" => null,
            ];
        } catch (Exception $e) {
            return (object)[
                "status" => false,
                "message" => $e->getMessage(),
                "data" => null,
            ];
        }
    }
    protected function get($path) {
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => "{$this->url}{$path}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "authorization-agent: {$this->code}",
                "authorization-token: {$this->token}",
                "Content-Type: application/json",
            ),
        ));

        $response = curl_exec($this->curl);
        curl_close($this->curl);
        try {
            $response = json_decode($response);
            if ($response->statusCode == 0) return (object)[
                "status" => true,
                "message" => $response->statusDesc,
                "data" => $response->data,
            ];
            return (object)[
                "status" => false,
                "message" => $response->statusDesc,
                "data" => $response->data,
            ];
        } catch (Exception $e) {
            return (object)[
                "status" => false,
                "message" => $e->getMessage(),
                "data" => null,
            ];
        }
    }
}
