<?php

namespace App\Controllers\serv;

use App\Controllers\RestController;
use App\Libraries\Portal;
use App\Libraries\Base64fileUploads;

class Banner extends RestController {
    public function list() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $banners = $portal->banner_list($body);
        if (!$banners->status) return $this->sendData(null, $banners->message, false);
        return $this->sendData($banners->data);
    }

    public function add() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);
        $file = new Base64fileUploads();

        if (!empty($body->image_upload)) {
            $this->unlink_image($body->image);
            $image = $file->du_uploads($body->image_upload, "images", "{$this->session->agent->code}banner_" . uniqid());
            $this->resize_image($image->file_path, 1000, 480);
            $body->image = site_url($image->file_path);
        }

        $body->agent = $this->session->agent->code;
        $body->add_by = $this->session->username;
        $banner = $portal->banner_add($body);
        if (!$banner->status) return $this->sendData(null, $banner->message, false);
        return $this->sendData($banner->data);
    }

    public function info() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $banner = $portal->banner_info($body);
        if (!$banner->status) return $this->sendData(null, $banner->message, false);
        return $this->sendData($banner->data);
    }

    public function info_update() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);
        $file = new Base64fileUploads();

        if (!empty($body->image_upload)) {
            $this->unlink_image($body->image);
            $image = $file->du_uploads($body->image_upload, "images", "{$this->session->agent->code}banner_" . uniqid());
            $this->resize_image($image->file_path, 1000, 480);
            $body->image = site_url($image->file_path);
        }

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $banner = $portal->banner_info_update($body);
        if (!$banner->status) return $this->sendData(null, $banner->message, false);
        return $this->sendData($banner->data);
    }

    public function status_inactive() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $banner = $portal->banner_inactive($body);
        if (!$banner->status) return $this->sendData(null, $banner->message, false);
        return $this->sendData($banner->data);
    }

    public function status_active() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $banner = $portal->banner_active($body);
        if (!$banner->status) return $this->sendData(null, $banner->message, false);
        return $this->sendData($banner->data);
    }

    public function record_delete() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $banner = $portal->banner_delete($body);
        if (!$banner->status) return $this->sendData(null, $banner->message, false);
        $this->unlink_image($banner->data->image);
        return $this->sendData($banner->data);
    }
}
