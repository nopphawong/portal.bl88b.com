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
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $segmentModel = new SegmentModel();
        $segments = $segmentModel->where("wheel", $body->wheel)->where("agent", $agent->code)->orderBy("index")->findAll();

        return $this->sendData($segments);
    }
    public function shuffle()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $segmentModel = new SegmentModel();
        $segments = $segmentModel
            ->where("status", 1)
            ->where("wheel", $body->wheel)
            ->where("agent", $agent->code)
            ->findAll();

        shuffle($segments);
        foreach ($segments as $index => &$segment) {
            $segment->index = $index;
            $segmentModel->save($segment);
        }

        return $this->sendData($segments);
    }

    public function add()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $segmentModel = new SegmentModel();
        $body->add_date = date('Y-m-d H:i:s');
        $id = $segmentModel->insert($body);
        $segment = $segmentModel->find($id);
        return $this->sendData($segment);
    }

    public function info()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $segmentModel = new SegmentModel();
        $segment = $segmentModel->where("id", $body->id)->where("agent", $agent->code)->first();
        if (!$segment) return $this->sendData(null, "Segment not found !", false);

        return $this->sendData($segment);
    }
    public function info_update()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $segmentModel = new SegmentModel();
        $body->edit_date = date('Y-m-d H:i:s');
        $segmentModel->save($body);
        $segment = $segmentModel->find($body->id);
        return $this->sendData($segment);
    }

    // public function status_inactive()
    // {
    //     $body = $this->getPost();
    //     $agentModel = new AgentModel();
    //     $agent = $agentModel->where("secret", $body->secret)->first();
    //     if (!$agent) return $this->sendData(null, "Invalide agent !", false);
    //     if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

    //     $segmentModel = new SegmentModel();
    //     $segment = $segmentModel->find($body->id);
    //     if (!$segment) return $this->sendData(null, "Segment not found !", false);
    //     $segment->status = 0;
    //     $segment->edit_date = date('Y-m-d H:i:s');
    //     $segmentModel->save($segment);
    //     return $this->sendData($segment);
    // }

    // public function status_active()
    // {
    //     $body = $this->getPost();
    //     $agentModel = new AgentModel();
    //     $agent = $agentModel->where("secret", $body->secret)->first();
    //     if (!$agent) return $this->sendData(null, "Invalide agent !", false);
    //     if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

    //     $segmentModel = new SegmentModel();
    //     $segment = $segmentModel->find($body->id);
    //     if (!$segment) return $this->sendData(null, "Segment not found !", false);
    //     $segment->status = 1;
    //     $segment->edit_date = date('Y-m-d H:i:s');
    //     $segmentModel->save($segment);
    //     return $this->sendData($segment);
    // }

    // public function record_delete()
    // {
    //     $body = $this->getPost();
    //     $agentModel = new AgentModel();
    //     $agent = $agentModel->where("secret", $body->secret)->first();
    //     if (!$agent) return $this->sendData(null, "Invalide agent !", false);
    //     if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

    //     $segmentModel = new SegmentModel();
    //     $segment = $segmentModel->find($body->id);
    //     if (!$segment) return $this->sendData(null, "Segment not found !", false);
    //     $segmentModel->delete($segment->id);
    //     return $this->sendData($segment);
    // }
}
