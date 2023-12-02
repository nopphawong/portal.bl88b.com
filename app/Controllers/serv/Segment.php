<?php

namespace App\Controllers\serv;

use App\Libraries\Portal;
use App\Models\SegmentMasterModel;

class Segment extends BaseController
{
    public function list()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $segments = $portal->segment_list($body);
        if (!$segments->status) return $this->response(null, $segments->message, false);
        if ($segments->data) return $this->response($segments->data);

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
        return $this->response($segments);
    }
    public function shuffle()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $segments = $portal->segment_shuffle($body);
        if (!$segments->status) return $this->response(null, $segments->message, false);
        return $this->response($segments->data);
    }

    public function add()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->add_by = $this->session->username;
        $segment = $portal->segment_add($body);
        if (!$segment->status) return $this->response(null, $segment->message, false);
        return $this->response($segment->data);
    }

    public function info()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $segment = $portal->segment_info($body);
        if (!$segment->status) return $this->response(null, $segment->message, false);
        return $this->response($segment->data);
    }

    public function info_update()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $segment = $portal->segment_info_update($body);
        if (!$segment->status) return $this->response(null, $segment->message, false);
        return $this->response($segment->data);
    }
}
