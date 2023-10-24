<?php

namespace App\Controllers\serv;

use App\Libraries\Apiv1;
use App\Libraries\Base64fileUploads;
use Exception;

class Agent extends BaseController
{
    public function info()
    {
        $api = new Apiv1($this->session->agent->secret);
        $agent = $api->agent_info();
        if (!$agent->status) return $this->response(null, $agent->message, false);
        return $this->response($agent->data, "Successful !");
    }

    public function info_update()
    {
        $api = new Apiv1($this->session->agent->secret);
        $body = $this->getPost();
        $file = new Base64fileUploads();

        if (!empty($body->logo_new)) {
            $this->unlink_image($body->logo);
            $logo = $file->du_uploads($body->logo_new, "images", "{$this->session->agent->key}logo_" . uniqid());
            $this->resize_image($logo->file_path, 150, 150);
            $body->logo = site_url($logo->file_path);
        }

        if (!empty($body->banner_new)) {
            $this->unlink_image($body->banner);
            $banner = $file->du_uploads($body->banner_new, "images", "{$this->session->agent->key}banner_" . uniqid());
            $this->resize_image($banner->file_path, 450, 150);
            $body->banner = site_url($banner->file_path);
        }

        $body->edit_by = $this->session->username;
        $agent = $api->agent_info_update($body);
        if (!$agent->status) return $this->response(null, $agent->message, false);
        return $this->response($agent->data, "Update successful !");
    }

    protected function unlink_image($url)
    {
        if (!$url) return;
        $uri = new \CodeIgniter\HTTP\URI($url);
        $path = $uri->getPath();
        try {
            unlink($_SERVER['DOCUMENT_ROOT'] . $path);
        } catch (Exception $e) {}
        unset($uri, $path);
    }

    protected function resize_image($path, $maxw = 100, $maxh = 100)
    {
        if (!$path) return;
        $lib = \Config\Services::image();
        $image = $lib->withFile($path);
        $props = $image->getFile()->getProperties(true);

        if ($props["width"] > $maxw) $image->resize($maxw, $maxh, true);
        if ($props["height"] > $maxh) $image->resize($maxw, $maxh, true);

        $image->save($path);
        unset($lib, $image, $props);
    }
}
