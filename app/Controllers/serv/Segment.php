<?php

namespace App\Controllers\serv;

use App\Controllers\RestController;
use App\Libraries\Portal;
use App\Models\SegmentMasterModel;
use App\Libraries\Base64fileUploads;

class Segment extends RestController {
    public function list() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $segments = $portal->segment_list($body);
        if (!$segments->status) return $this->sendData(null, $segments->message, false);
        if ($segments->data) return $this->sendData($segments->data);

        $segmentMasterModel = new SegmentMasterModel();
        $segments = $segmentMasterModel->where("status", 1)->limit(8)->findAll();
        foreach ($segments as &$segment) {
            $segment->agent = $this->session->agent->code;
            $segment->wheel = $body->wheel;
            $segment->add_by = $this->session->username;
            $new_segment = $portal->segment_add($segment);
            if (!$new_segment->status) continue;
            $segment = $new_segment->data;
        }
        return $this->sendData($segments);
    }
    public function list_update() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);
        $file = new Base64fileUploads();

        foreach ($body->segments as $data) {
            $segment = (object) [];
            $segment->id = $data->id;
            $segment->wheel = $data->wheel;
            $segment->title = $data->title;
            $segment->type = $data->type;
            $segment->value = $data->value;
            $segment->rate = $data->rate;
            $segment->hex = $data->hex;

            if (!empty($data->new_image)) {
                $this->unlink_image($data->image);
                $image = $file->du_uploads($data->new_image, "images", "{$this->session->agent->code}segment_" . uniqid());
                $this->resize_image($image->file_path, 160, 123);
                $segment->image = site_url($image->file_path);
            }

            $segment->agent = $this->session->agent->code;
            $segment->edit_by = $this->session->username;
            $segment = $portal->segment_info_update($segment);
            if (!$segment->status) return $this->sendData(null, $segment->message, false);
        }
        return $this->sendData($body);
    }
    public function shuffle() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $segments = $portal->segment_shuffle($body);
        if (!$segments->status) return $this->sendData(null, $segments->message, false);
        return $this->sendData($segments->data);
    }

    public function add() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->add_by = $this->session->username;
        $segment = $portal->segment_add($body);
        if (!$segment->status) return $this->sendData(null, $segment->message, false);
        return $this->sendData($segment->data);
    }

    public function info() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $segment = $portal->segment_info($body);
        if (!$segment->status) return $this->sendData(null, $segment->message, false);
        return $this->sendData($segment->data);
    }

    public function info_update() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $segment = $portal->segment_info_update($body);
        if (!$segment->status) return $this->sendData(null, $segment->message, false);
        return $this->sendData($segment->data);
    }
}
