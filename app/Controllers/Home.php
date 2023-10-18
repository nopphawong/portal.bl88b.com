<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return $this->cv->pageView('pages/home/index', $this->headerInfo);
    }
}
