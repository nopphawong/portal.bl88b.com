<?php

namespace App\Controllers\api;

use App\Models\AgentModel;
use App\Models\SegmentModel;

class Segment extends BaseController
{
    public function list()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $segmentModel = new SegmentModel();
        $segments = $segmentModel->where("wheel", $body->wheel)->where("agent", $agent->code)->orderBy("index")->findAll();

        return $this->response($segments);
    }
    public function info()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $segmentModel = new SegmentModel();
        $segment = $segmentModel->where("id", $body->id)->where("agent", $agent->code)->findAll();
        if (!$segment) return $this->response(null, "Segment not found !", false);

        return $this->response($segment);
    }
}
