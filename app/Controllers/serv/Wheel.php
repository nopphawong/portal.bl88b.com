<?php

namespace App\Controllers\serv;

use App\Controllers\RestController;
use App\Libraries\Base64fileUploads;
use App\Libraries\Portal;

class Wheel extends RestController {
    public function list() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $wheels = $portal->wheel_list($body);
        if (!$wheels->status) return $this->sendData(null, $wheels->message, false);
        return $this->sendData($wheels->data);
    }

    public function info() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $wheel = $portal->wheel_info($body);
        if (!$wheel->status) return $this->sendData(null, $wheel->message, false);
        return $this->sendData($wheel->data);
    }
    public function first() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $wheel = $portal->wheel_first($body);
        if ($wheel->status) return $this->sendData($wheel->data);

        $body->deposit_rule = 100;
        $body->agent = $this->session->agent->code;
        $wheel = $portal->wheel_add($body);
        if (!$wheel->status) return $this->sendData(null, $wheel->message, false);
        return $this->sendData($wheel->data);
    }

    public function info_update() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);
        $file = new Base64fileUploads();

        if (!empty($body->new_background_image)) {
            $this->unlink_image($body->background_image);
            $image = $file->du_uploads($body->new_background_image, "images", "{$this->session->agent->code}wheel_" . uniqid());
            $this->resize_image($image->file_path, 420, 420);
            $body->background_image = site_url($image->file_path);
        }
        if (!empty($body->new_arrow_image)) {
            $this->unlink_image($body->arrow_image);
            $image = $file->du_uploads($body->new_arrow_image, "images", "{$this->session->agent->code}arrow_" . uniqid());
            $this->resize_image($image->file_path, 100, 100);
            $body->arrow_image = site_url($image->file_path);
        }

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $wheel = $portal->wheel_info_update($body);
        if (!$wheel->status) return $this->sendData(null, $wheel->message, false);
        return $this->sendData($wheel->data);
    }
}
