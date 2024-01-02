<?php

namespace App\Controllers\serv;

use App\Libraries\Portal;
use App\Models\ProgressMasterModel;

class Progress extends BaseController
{
    public function list()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $progresses = $portal->progress_list($body);
        if (!$progresses->status) return $this->sendData(null, $progresses->message, false);
        if ($progresses->data) return $this->sendData($progresses->data);

        $progressMasterModel = new ProgressMasterModel();
        $progresses = $progressMasterModel->where("status", 1)->limit(15)->findAll();
        foreach ($progresses as &$progress) {
            $progress->agent = $this->session->agent->code;
            $progress->checkin = $body->checkin;
            $progress->add_by = $this->session->username;
            $new_progress = $portal->progress_add($progress);
            if (!$new_progress->status) continue;
            $progress = $new_progress->data;
        }
        return $this->sendData($progresses);
    }

    public function add()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->add_by = $this->session->username;
        $progress = $portal->progress_add($body);
        if (!$progress->status) return $this->sendData(null, $progress->message, false);
        return $this->sendData($progress->data);
    }

    public function info()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $progress = $portal->progress_info($body);
        if (!$progress->status) return $this->sendData(null, $progress->message, false);
        return $this->sendData($progress->data);
    }

    public function info_update()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $progress = $portal->progress_info_update($body);
        if (!$progress->status) return $this->sendData(null, $progress->message, false);
        return $this->sendData($progress->data);
    }
}
