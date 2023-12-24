<?php

namespace App\Controllers\api;

use Exception;

class Bl88 extends BaseController
{
    private $url = "https://www.bl88-api.com/";
    private $code = "ag024";
    private $token = "7506d35fe9fe68d7785a44ddaee346e7";
    private $reffix = "blbet789.com";
    private $prefix = "bl789";
    private $curl;
    public function __construct()
    {
        $this->curl = curl_init();
    }
    public function login()
    {
        $body = $this->getPost();
        if (substr($body->username, 0, strlen($this->prefix)) != $this->prefix) $body->username = "{$this->prefix}{$body->username}";
        $form = [
            "s_username" => $body->username,
            "s_password" => $body->password,
        ];
        $login = $this->post("Authen/Login", $form);
        return $this->response($login->data, $login->message, $login->status);
    }
    public function register()
    {
        $body = $this->getPost();
        $form = [
            "s_firstname" => $body->name,
            "s_phone" => $body->tel,
            "s_line" => $body->line,
            "i_bank" => $body->bank,
            "s_account_no" => $body->bank_no,
        ];
        $register = $this->post("Authen/RegisterPlayer", $form);
        return $this->response($register->data, $register->message, $register->status);
        // { data: { username, endpoint } }
    }
    public function bank_list()
    {
        $banks = $this->get("Bank/InquiryBankList");
        return $this->response($banks->data, $banks->message, $banks->status, ["image_path" => "https://www.bl88enjoy.com/assets/images/iconbank/"]);
    }

    protected function post($path, $data = array())
    {
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
        try {
            $response = json_decode($response);
            if ($response->statusCode == 0) return (object)[
                "status" => true,
                "message" => $response->statusDesc,
                "data" => $response->bean,
            ];
        } catch (Exception $e) {
            return (object)[
                "status" => false,
                "message" => $e->getMessage(),
                "data" => null,
            ];
        }
    }
    protected function get($path)
    {
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
        } catch (Exception $e) {
            return (object)[
                "status" => false,
                "message" => $e->getMessage(),
                "data" => null,
            ];
        }
    }
}
