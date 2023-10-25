<?php

namespace App\Libraries;

use Exception;

class Apiv1
{
    private $curl;
    private $secret;

    public function __construct($secret = null)
    {
        $this->curl = service("curlrequest", ["baseURI" => "{$_ENV["app.apiUrl"]}"]);
        if ($secret) $this->set_secret($secret);
    }

    public function set_secret($secret)
    {
        $this->secret = $secret;
    }

    // Agent
    public function agent_info($data = array())
    {
        return self::post("agent/info", $data);
    }
    public function agent_info_update($data = array())
    {
        return self::post("agent/info/update", $data);
    }

    // banner
    public function banner_list($data = array())
    {
        return self::post("banner/list", $data);
    }
    public function banner_add($data = array())
    {
        return self::post("banner/add", $data);
    }
    public function banner_info($data = array())
    {
        return self::post("banner/info", $data);
    }
    public function banner_info_update($data = array())
    {
        return self::post("banner/info/update", $data);
    }
    public function banner_remove($data = array())
    {
        return self::post("banner/remove", $data);
    }
    public function banner_reuse($data = array())
    {
        return self::post("banner/reuse", $data);
    }

    // user
    public function user_list($data = array())
    {
        return self::post("user/list", $data);
    }
    public function user_add($data = array())
    {
        return self::post("user/add", $data);
    }
    public function user_info($data = array())
    {
        return self::post("user/info", $data);
    }
    public function user_info_update($data = array())
    {
        return self::post("user/info/update", $data);
    }
    public function user_remove($data = array())
    {
        return self::post("user/remove", $data);
    }
    public function user_reuse($data = array())
    {
        return self::post("user/reuse", $data);
    }

    /* ========================================================================== */

    protected function post($path, $data = array())
    {
        $data = (object) $data;
        $data->secret = $this->secret;
        $body = self::hash_data($data);
        log_message("alert", "path: {$path} :: " . $body);
        $response = $this->curl->post("{$path}", ["json" => $data]);
        $result = self::prepare_result($response);
        log_message("alert", "path: {$path} :: " . json_encode($result));
        return $result;
    }

    protected function get($path)
    {
        $response = $this->curl->get($path);
        return self::prepare_result($response);
    }

    protected function hash_data($array)
    {
        if (!is_array($array)) $array = array();
        return json_encode($array);
    }

    protected function prepare_result($response)
    {
        try {
            $result = json_decode($response->getBody());
            if (json_last_error() !== JSON_ERROR_NONE) {
                return (object) array(
                    "status" => false,
                    "message" => $response->getBody(),
                );
            }
            return $result;
        } catch (Exception $ex) {
            return (object) array(
                "status" => false,
                "message" => $ex->getMessage(),
            );
        }
    }
}
