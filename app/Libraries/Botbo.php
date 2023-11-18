<?php

namespace App\Libraries;

use Exception;

class Botbo
{
    private $curl;

    // "appid" => $_ENV["app.apiWebkey"],
    // "web" => $_ENV["app.apiWeb"],

    protected $app;
    protected $web;

    public function __construct($app = null, $web = null)
    {
        $this->curl = service("curlrequest", ["baseURI" => $_ENV["api.botboURL"]]);
        $this->app = $app;
        $this->web = $web;
    }
    public function get_web()
    {
        return $_ENV["app.apiWeb"];
    }

    /* ========================================================================== */

    public function get_otp($tel)
    {
        return self::post("user/m_sentotp", ["tel" => $tel,]);
    }
    public function check_exist($tel)
    {
        return self::post("user/m_checkexits", ["user" => $tel,]);
    }
    public function register($user, $pass, $otpref, $otpcode, $name, $invite = "")
    {
        return self::post("user/m_register", ["user" => $user, "pass" => $pass, "name" => $name, "otpcode" => $otpcode, "otpref" => $otpref, "invite" => $invite,]);
    }
    public function registerx($user, $pass, $otpref, $otpcode, $name, $bankid, $bankno, $invite = "")
    {
        return self::post("user/m_registerx", ["user" => $user, "pass" => $pass, "name" => $name, "otpcode" => $otpcode, "otpref" => $otpref, "bankid" => $bankid, "bankno" => $bankno, "invite" => $invite,]);
    }
    public function forget_password($user, $pass, $otpref, $otpcode)
    {
        return self::post("user/m_forgetpass", ["user" => $user, "pass" => $pass, "otpcode" => $otpcode, "otpref" => $otpref,]);
    }

    public function login($user, $pass)
    {
        return self::post("user/m_login", ["user" => $user, "pass" => $pass,]);
    }
    public function check_login($user, $token)
    {
        return self::post("user/m_checklogin", ["user" => $user, "token" => $token,]);
    }

    public function user_info($user, $token)
    {
        return self::post("user/m_info", ["user" => $user, "token" => $token,]);
    }
    public function update_info($user, $token, $lineid, $email = '')
    {
        return self::post("user/m_updateinfo", ["user" => $user, "token" => $token, "email" => $email, "lineid" => $lineid,]);
    }
    public function verify_bank($user, $token, $accno, $bankid)
    {
        return self::post("user/m_bankverify", ["user" => $user, "token" => $token, "accno" => $accno, "bankid" => $bankid,]);
    }
    public function verifyx_bank($user, $accno, $bankid)
    {
        return self::post("user/m_bankverifyx", ["user" => $user, "accno" => $accno, "bankid" => $bankid,]);
    }
    public function update_bank($user, $token, $bankname, $bankid, $accno)
    {
        return self::post("user/m_updatebank", ["user" => $user, "token" => $token, "bankname" => $bankname, "bankid" => $bankid, "accno" => $accno,]);
    }
    public function change_password($user, $token, $oldpass, $newpass)
    {
        return self::post("user/m_uchangepass", ["user" => $user, "token" => $token, "oldpass" => $oldpass, "newpass" => $newpass,]);
    }

    public function bank_list($user, $token)
    {
        return self::post("user/m_banklists", ["user" => $user, "token" => $token,]);
    }
    public function bank_deposit($user, $token)
    {
        return self::post("user/m_bankdeposit", ["user" => $user, "token" => $token,]);
    }

    public function web_login($user, $token, $webuser, $webpass)
    {
        return self::post("user/m_weblogin", ["user" => $user, "token" => $token, "webuser" => $webuser, "webpass" => $webpass,]);
    }
    public function web_balance($user, $token, $webuser)
    {
        return self::post("user/m_webbalance", ["user" => $user, "token" => $token, "webuser" => $webuser,]);
    }
    public function web_transaction_list($user, $token, $sdate = '', $edate = '', $status = '')
    {
        return self::post("user/m_udidwidlists", ["user" => $user, "token" => $token, "sdate" => $sdate, "edate" => $edate, "status" => $status,]);
    }

    public function web_deposit($user, $token, $webuser, $amount, $frombankid, $frombankno, $tobankid, $tobankno, $bonus = '', $bonustxt = '', $turnover = '')
    {
        return self::post("user/m_udeposit", ["user" => $user, "token" => $token, "webuser" => $webuser, "amount" => self::number_2digit($amount), "frombankid" => $frombankid, "frombankno" => $frombankno, "tobankid" => $tobankid, "tobankno" => $tobankno, "bonus" => $bonus, "bonus" => $bonus, "bonustxt" => $bonustxt, "turnover" => $turnover,]);
    }
    public function web_deposit_list($user, $token, $sdate = '', $edate = '', $status = '')
    {
        return self::post("user/m_udepositlists", ["user" => $user, "token" => $token, "sdate" => $sdate, "edate" => $edate, "status" => $status,]);
    }
    public function web_cancel_deposit($user, $token, $webuser, $id)
    {
        return self::post("user/m_canceldeposit", ["user" => $user, "token" => $token, "webuser" => $webuser, "id" => $id,]);
    }
    public function web_deposit_bonus($user, $token, $webuser, $amount, $bonustxt = '', $turnover = '')
    {
        return self::post("user/m_didbonus", ["user" => $user, "token" => $token, "webuser" => $webuser, "amount" => self::number_2digit($amount), "bonustxt" => $bonustxt, "turnover" => $turnover,]);
    }

    public function web_withdraw($user, $token, $webuser, $amount)
    {
        return self::post("user/m_uwithdraw", ["user" => $user, "token" => $token, "webuser" => $webuser, "amount" => self::number_2digit($amount),]);
    }
    public function web_withdraw_list($user, $token, $sdate = '', $edate = '', $status = '')
    {
        return self::post("user/m_uwithdrawlists", ["user" => $user, "token" => $token, "sdate" => $sdate, "edate" => $edate, "status" => $status,]);
    }
    public function web_withdraw_bonus($user, $token, $webuser, $amount, $bonustxt = '')
    {
        return self::post("user/m_widbonus", ["user" => $user, "token" => $token, "webuser" => $webuser, "amount" => self::number_2digit($amount), "bonustxt" => $bonustxt,]);
    }

    public function game_list($user, $token, $webuser, $webpass)
    {
        return self::post("user/m_weblistgame", ["user" => $user, "token" => $token, "webuser" => $webuser, "webpass" => $webpass,]);
    }
    public function game_login($user, $token, $webuser, $webpass, $webgame)
    {
        return self::post("user/m_weblogin", ["user" => $user, "token" => $token, "webuser" => $webuser, "webpass" => $webpass, "webgame" => $webgame,]);
    }

    /* ========================================================================== */

    protected function post($path, $data = array())
    {
        $body = self::hash_data($data);
        log_message("alert", "path: {$path} :: " . $body);
        $response = $this->curl->setBody($body)->post($path);
        $result = self::prepare_result($response);
        log_message("alert", "path: {$path} :: " . json_encode($result));
        return $result;
    }

    protected function get($path, $data = array())
    {
        $response = $this->curl->get($path . "?" . http_build_query($data));
        return self::prepare_result($response);
    }

    protected function hash_data($array)
    {
        if (!is_array($array)) $array = array();
        $array = array_filter($array);
        $array = array_change_key_case($array, CASE_LOWER);
        $default = array(
            "appid" => $this->app,
            "web" => $this->web,
            "time" => round((microtime(true) * 1000)),
        );
        $array = array_merge($array, $default);
        ksort($array);
        $raw = array();
        foreach ($array as $key => $value) {
            $raw[] = "{$key}={$value}";
        }
        $raw = implode('&', $raw) . $_ENV["app.apiSecret"];
        $array['hash'] = md5($raw);
        return json_encode($array);
    }

    protected function prepare_result($response)
    {
        try {
            $result = json_decode($response->getBody(), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return array(
                    "status" => false,
                    "msg" => $response->getBody(),
                );
            }
            return $result;
        } catch (Exception $ex) {
            return array(
                "status" => false,
                "msg" => $ex->getMessage(),
            );
        }
    }
    protected function number_2digit($num)
    {
        if (!is_numeric($num)) return "0.00";
        return number_format($num, 2, '.', '');
    }
}
