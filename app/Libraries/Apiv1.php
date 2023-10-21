<?

namespace App\Libraries;

use Exception;

class Apiv1
{
    private $curl;
    private $secret;

    public function __construct($secret = null)
    {
        $this->curl = service("curlrequest", ["baseURI" => "{$_ENV["app.apiUrl"]}"]);
        $this->set_secret($secret);
    }

    public function set_secret($secret)
    {
        $this->secret = $secret;
    }

    // WEB
    public function web_info()
    {
        return self::post("{$_ENV["app.apiUrl"]}web/info");
    }
    public function web_info_update($data = array())
    {
        return self::post("{$_ENV["app.apiUrl"]}web/info/update", $data);
    }

    /* ========================================================================== */

    protected function post($path, $data = array())
    {
        $data = (object) $data;
        $data->secret = $this->secret;
        $body = self::hash_data($data);
        log_message("alert", "path: {$path} :: " . $body);
        $response = $this->curl->post($path, ["json" => $data]);
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
