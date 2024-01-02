<?php

namespace App\Controllers\serv;

use CodeIgniter\RESTful\ResourceController;
use Exception;
use stdClass;

class BaseController extends ResourceController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
    }
    protected function sendData($data = null, $message = "Successful !", $status = true)
    {
        $data = array(
            "status" => $status,
            "message" => $message,
            "data" => $data,
        );
        return $this->respond($data);
    }
    protected function getPost($index = false)
    {
        if ($this->request->is('json')) $body = !$index ? $this->request->getVar() : $this->request->getVar($index);
        else $body =  !$index ? $this->request->getPost() : $this->request->getPost($index);
        return (object) $body;
    }
    protected function resize_image($path, $maxw = 100, $maxh = 100)
    {
        return;
        if (!$path) return;
        $lib = \Config\Services::image();
        $image = $lib->withFile($path);
        $props = $image->getFile()->getProperties(true);

        if ($props["width"] > $maxw) $image->resize($maxw, $maxh, true, "width");
        if ($props["height"] > $maxh) $image->resize($maxw, $maxh, true, "height");

        $image->save($path);
        unset($lib, $image, $props);
    }

    protected function unlink_image($url)
    {
        if (!$url) return;
        $uri = new \CodeIgniter\HTTP\URI($url);
        $path = $uri->getPath();
        try {
            $full_path = $_SERVER['DOCUMENT_ROOT'] . $path;
            unlink($full_path);
        } catch (Exception $e) {
        }
        unset($uri, $path);
    }
}
