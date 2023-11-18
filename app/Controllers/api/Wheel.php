<?php

namespace App\Controllers\api;

use App\Models\AgentModel;
use App\Models\SegmentModel;
use App\Models\WheelModel;

class Wheel extends BaseController
{
    public function list()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $wheelModel = new WheelModel();
        $wheels = $wheelModel->where("agent", $agent->code)->findAll();

        return $this->response($wheels);
    }
    public function info()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $wheelModel = new WheelModel();
        $wheel = $wheelModel->where("id", $body->id)->where("agent", $agent->code)->findAll();
        if (!$wheel) return $this->response(null, "Wheel not found !", false);

        return $this->response($wheel);
    }
    public function first()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $wheelModel = new WheelModel();
        $wheel = $wheelModel->where("agent", $agent->code)->where("status", 1)->first();
        if (!$wheel) return $this->response(null, "Wheel not found !", false);

        return $this->response($wheel);
    }

    public function roll()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $wheelModel = new WheelModel();
        $wheel = $wheelModel->where("id", $body->id)->where("agent", $agent->code)->findAll();
        if (!$wheel) return $this->response(null, "Wheel not found !", false);

        $segmentModel = new SegmentModel();
        $segments = $segmentModel->where("wheel", $body->id)->where("agent", $agent->code)->findAll();
        shuffle($segments);
        $rate_min = 1;
        $rate_max = array_sum(array_column((array)$segments, "rate"));
        $lucky_number = rand($rate_min, $rate_max);
        $lucky_roll = null;
        $stack = 0;
        foreach ($segments as &$segment) {
            $segment->rate_min = $stack + $rate_min;
            $segment->rate_max  = $stack + $segment->rate;
            $segment->lucky_number = $lucky_number;
            $stack += $segment->rate;
            $lucky_roll = $segment;
            if ($lucky_number >= $segment->rate_min && $lucky_number <= $segment->rate_max) break;
        }

        return $this->response($lucky_roll);
    }
}
