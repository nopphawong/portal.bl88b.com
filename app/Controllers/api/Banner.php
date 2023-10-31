<?php

namespace App\Controllers\api;

use App\Models\AgentModel;
use App\Models\BannerModel;

class Banner extends BaseController
{
    public function list($status = null)
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $bannerModel = new BannerModel();
        if ($status) $bannerModel->where("status", $status);
        $banners = $bannerModel->where("agent", $agent->code)->findAll();

        return $this->response($banners);
    }

    public function add()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $bannerModel = new BannerModel();
        $body->add_date = date('Y-m-d H:i:s');
        $id = $bannerModel->insert($body);
        $banner = $bannerModel->find($id);
        return $this->response($banner);
    }

    public function info()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $bannerModel = new BannerModel();
        $banner = $bannerModel->find($body->id);

        return $this->response($banner);
    }

    public function info_update()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $bannerModel = new BannerModel();
        $body->edit_date = date('Y-m-d H:i:s');
        $bannerModel->save($body);
        $banner = $bannerModel->find($body->id);
        return $this->response($banner);
    }

    public function status_inactive()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $bannerModel = new BannerModel();
        $banner = $bannerModel->find($body->id);
        $banner->status = 0;
        $banner->edit_date = date('Y-m-d H:i:s');
        $bannerModel->save($banner);
        return $this->response($banner);
    }

    public function status_active()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $bannerModel = new BannerModel();
        $banner = $bannerModel->find($body->id);
        $banner->status = 1;
        $banner->edit_date = date('Y-m-d H:i:s');
        $bannerModel->save($banner);
        return $this->response($banner);
    }
}
