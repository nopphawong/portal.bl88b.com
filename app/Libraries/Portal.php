<?php

namespace App\Libraries;

use Exception;

class Portal
{
    private $curl;
    private $secret;
    private $key;

    public function __construct($agent = null)
    {
        $this->curl = service("curlrequest", ["baseURI" => "{$_ENV["api.portalURL"]}"]);
        if ($agent) $this->set_agent($agent);
    }

    public function set_agent($agent)
    {
        $this->secret = $agent->secret;
        $this->key = $agent->key;
    }
    // Login
    public function login($data = array())
    {
        return self::post("auth/login", $data);
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
    public function agent_list($data = array())
    {
        return self::post("agent/list", $data);
    }
    public function agent_add($data = array())
    {
        return self::post("agent/add", $data);
    }
    public function agent_config($data = array())
    {
        return self::post("agent/config", $data);
    }
    public function agent_inactive($data = array())
    {
        return self::post("agent/inactive", $data);
    }
    public function agent_active($data = array())
    {
        return self::post("agent/active", $data);
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
    public function banner_inactive($data = array())
    {
        return self::post("banner/inactive", $data);
    }
    public function banner_active($data = array())
    {
        return self::post("banner/active", $data);
    }
    public function banner_delete($data = array())
    {
        return self::post("banner/delete", $data);
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
    public function user_inactive($data = array())
    {
        return self::post("user/inactive", $data);
    }
    public function user_active($data = array())
    {
        return self::post("user/active", $data);
    }
    public function user_delete($data = array())
    {
        return self::post("user/delete", $data);
    }

    // wheel
    public function wheel_add($data = array())
    {
        return self::post("wheel/add", $data);
    }
    public function wheel_list($data = array())
    {
        return self::post("wheel/list", $data);
    }
    public function wheel_first($data = array())
    {
        return self::post("wheel/first", $data);
    }
    public function wheel_info($data = array())
    {
        return self::post("wheel/info", $data);
    }
    public function wheel_info_update($data = array())
    {
        return self::post("wheel/info/update", $data);
    }

    // segment
    public function segment_add($data = array())
    {
        return self::post("segment/add", $data);
    }
    public function segment_list($data = array())
    {
        return self::post("segment/list", $data);
    }
    public function segment_shuffle($data = array())
    {
        return self::post("segment/shuffle", $data);
    }
    public function segment_info($data = array())
    {
        return self::post("segment/info", $data);
    }
    public function segment_info_update($data = array())
    {
        return self::post("segment/info/update", $data);
    }

    // checkin
    public function checkin_add($data = array())
    {
        return self::post("checkin/add", $data);
    }
    public function checkin_list($data = array())
    {
        return self::post("checkin/list", $data);
    }
    public function checkin_first($data = array())
    {
        return self::post("checkin/first", $data);
    }
    public function checkin_info($data = array())
    {
        return self::post("checkin/info", $data);
    }
    public function checkin_info_update($data = array())
    {
        return self::post("checkin/info/update", $data);
    }

    // progress
    public function progress_add($data = array())
    {
        return self::post("progress/add", $data);
    }
    public function progress_list($data = array())
    {
        return self::post("progress/list", $data);
    }
    public function progress_info($data = array())
    {
        return self::post("progress/info", $data);
    }
    public function progress_info_update($data = array())
    {
        return self::post("progress/info/update", $data);
    }
    /* ========================================================================== */

    protected function post($path, $data = array())
    {
        $data = (object) $data;
        $data->secret = $this->secret;
        $data->key = $this->key;
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
        if (empty($array)) $array = array();
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
